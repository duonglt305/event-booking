<?php


namespace DG\Dissertation\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use DB;
use DG\Dissertation\Api\Http\Resources\Registration as RegistrationResource;
use DG\Dissertation\Api\Models\Attendee;
use DG\Dissertation\Api\Models\Event;
use DG\Dissertation\Api\Models\Organizer;
use DG\Dissertation\Api\Models\Registration;
use DG\Dissertation\Api\Models\Ticket;
use DG\Dissertation\Api\Repositories\EventRepository;
use DG\Dissertation\Api\Repositories\OrganizerRepository;
use DG\Dissertation\Api\Repositories\RegistrationRepository;
use DG\Dissertation\Api\Repositories\TicketRespository;
use DG\Dissertation\Api\Services\PayPal\CreatePayment;
use DG\Dissertation\Api\Services\PayPal\ExecutePayment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use PayPal\Api\Item;

class RegistrationController extends Controller
{

    /**
     * @var TicketRespository
     */
    private $ticketRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var RegistrationRepository
     */
    private $registrationRepository;
    /**
     * @var RegistrationRepository
     */
    private $organizerRepository;

    public function __construct(
        TicketRespository $ticketRepository,
        EventRepository $eventRepository,
        RegistrationRepository $registrationRepository,
        OrganizerRepository $organizerRepository)
    {
        $this->middleware(['api.jwt.auth']);
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
        $this->registrationRepository = $registrationRepository;
        $this->organizerRepository = $organizerRepository;
    }

    public function registration(Request $request, $oSlug, $eSlug)
    {
        try {
            $this->validate($request, [
                'return_url' => ['required', 'url'],
                'cancel_url' => ['required', 'url'],
                'ticket_id' => ['required', 'exists:tickets,id'],
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }

        $oSlug = $this->getOrganizer($oSlug);

        if (!$oSlug) return response()->json(['message' => 'Organizer not found.'], 404);

        $event = $this->getEvent($eSlug);
        if (!$event) return response()->json(['message' => 'Event not found.'], 404);

        $ticket = $this->getTicket($request->get('ticket_id'));
        if (!$ticket) return response()->json(['message' => 'Ticket not found.'], 404);

        /* Check ticket available */
        if (!$ticket->available)
            return response()->json(['message' => 'Ticket is no longer available.'], 400);

        $registration = $this->getRegistration($event);

        if ($registration && $registration->paid()) return response()->json(['message' => 'User already registered.'], 400);

        try {
            DB::beginTransaction();
            if ($registration) $registration->update(['ticket_id' => $ticket->id]);
            else $registration = $this->newRegistration($event, $ticket->id);

            $createPayment = $this->createPaymentWithTicket($ticket);
            if (is_array($request->get('session_ids')) && count($request->get('session_ids'))) {
                $registration->sessions()->detach();
                $sessions = $event->sessions()->whereIn('sessions.id', $request->get('session_ids'))->get();
                $registrationSessions = $this->mappedSessions($sessions, $createPayment);
                $registration->sessions()->sync($registrationSessions);
            }
            DB::commit();
            return response()->json([
                'url' => $createPayment->create(),
            ]);
        } catch (Exception $e) {
            try {
                DB::rollBack();
            } catch (Exception $e) {
            }
            return response()->json([
                'message' => 'Data cannot be processed.',
                'er' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * @param string $oSlug
     * @return Organizer|null
     */
    protected function getOrganizer(string $oSlug)
    {
        return $this->organizerRepository->firstBy(
            ['WHERE' => [
                ['slug', '=', $oSlug]
            ]]
        );
    }

    /**
     * @param string $eSlug
     * @return Event|null
     */
    protected function getEvent(string $eSlug)
    {
        return $this->eventRepository->firstBy(
            ['WHERE' => [
                ['slug', '=', $eSlug]
            ]],
            ['tickets', 'sessions']
        );
    }

    /**
     * @param $ticket_id
     * @return Ticket|null
     */
    protected function getTicket(int $ticket_id)
    {
        return $this->ticketRepository->firstBy([
            'WHERE' => [
                ['id', '=', $ticket_id],
            ]
        ]);
    }

    /**
     * @param Event $event
     * @return Registration|null
     */
    protected function getRegistration(Event $event)
    {
        return $event->registrations()
            ->where('attendee_id', '=', auth('api')->id())
            ->first();
    }

    /**
     * @param Event $event
     * @param int $ticket_id
     * @return mixed
     */
    protected function newRegistration(Event $event, int $ticket_id)
    {
        return $event->registrations()->create([
            'attendee_id' => auth('api')->id(),
            'ticket_id' => $ticket_id,
            'status' => 'PENDING'
        ]);
    }

    /**
     * @param Ticket $ticket
     * @return CreatePayment
     */
    protected function createPaymentWithTicket(Ticket $ticket)
    {
        $createPayment = new CreatePayment;
        $createPayment->setReturnUrl(request()->get('return_url'))
            ->setCancelUrl(request()->get('cancel_url'));

        $ticketItem = new Item();
        $ticketItem->setName($ticket->name)
            ->setQuantity(1)
            ->setPrice($ticket->cost);
        $createPayment->addItem($ticketItem);
        return $createPayment;
    }

    /**
     * @param Collection $sessions
     * @param CreatePayment $createPayment
     * @return array
     */
    protected function mappedSessions(Collection $sessions, CreatePayment $createPayment): array
    {
        return $sessions->mapWithKeys(function ($session) use ($createPayment) {
            $item = new Item();
            $item->setName($session->title)
                ->setQuantity(1)
                ->setPrice($session->cost);
            $createPayment->addItem($item);
            return [
                $session->id => [
                    'cost' => $session->cost,
                ]
            ];
        })->toArray();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function confirmPayment(Request $request)
    {
        try {
            $this->validate($request, [
                'payment_id' => ['required', 'string'],
                'payer_id' => ['required', 'string'],
                'registration_id' => ['required', 'numeric', 'exists:registrations,id']
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        try {
            DB::beginTransaction();
            $registration = $this->registrationRepository
                ->findById($request->get('registration_id'), [
                    'ticket', 'sessions'
                ]);
            if (!$registration instanceof Registration)
                return response()->json(['message' => 'Registration not found.'], 404);
            if ($registration->paid())
                return response()->json(['message' => 'Event already paid.'], 400);
            $total = collect([$registration->ticket])
                ->merge($registration->sessions)
                ->reduce(function ($total, $item) {
                    $total += $item->cost;
                    return $total;
                }, 0);

            $executePayment = new ExecutePayment;
            $executePayment->setTotal($total)
                ->execute();
            $registration->update(['status' => 'PAID']);
            DB::commit();
            return response()->json([
                'message' => 'Registration successfully, thank for purchase.',
                'registration' => new RegistrationResource($registration)
            ]);
        } catch (Exception $e) {
            try {
                DB::rollBack();
            } catch (Exception $e) {
            }
            return response()->json(['message' => 'Data cannot be processed.', 'er' => $e->getMessage()], 422);
        }
    }

    /**
     * @param $oSlug
     * @param $eSlug
     * @return RegistrationResource|JsonResponse
     */
    public function paymentDetail($oSlug, $eSlug)
    {
        if (!$this->getOrganizer($oSlug)) return response()->json(['message' => 'Organizer not found'], 404);
        $event = $this->getEvent($eSlug);

        if (!$event) return response()->json(['message' => 'Event not found'], 404);
        $registration = $this->getRegistration($event);
        return new RegistrationResource($registration);
    }

    /**
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function registrations()
    {
        $attendee = auth('api')->user();
        if ($attendee instanceof Attendee) {
            $registrations = $attendee->registrations()
                ->orderBy('created_at')
                ->paginate(10);
            return RegistrationResource::collection($registrations);
        }
        return response()->json([]);
    }

    public function payment(Request $request)
    {
        try {
            $this->validate($request, [
                'registration_id' => ['required', 'numeric', 'exists:registrations,id']
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Registration not found.'], 404);
        }
        try {
            $registration = $this->registrationRepository
                ->findById($request->get('registration_id'), ['ticket', 'sessions']);
            $createPayment = $this->createPaymentWithTicket($registration->ticket);
            $this->mappedSessions($registration->sessions, $createPayment);
            return response()->json([
                'url' => $createPayment->create(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
