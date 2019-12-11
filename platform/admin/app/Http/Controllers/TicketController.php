<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\StoreTicket;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\TicketRespository;

class TicketController extends Controller
{
    private $ticketRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * TicketController constructor.
     * @param TicketRespository $ticketRepository
     * @param EventRepository $eventRepository
     */
    public function __construct(TicketRespository $ticketRepository, EventRepository $eventRepository)
    {
        $this->middleware('auth');
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function create($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            return view('admin::events.tickets.create', compact('event'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    /**
     * @param StoreTicket $request
     * @param $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTicket $request, $event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);

            $validated = $request->validated();
            $validated['event_id'] = $event->id;
            $this->ticketRepository->insert($validated);
            return redirect()->route('events.show', $event);
        } catch (\Exception $exception) {
            abort(422);
        }
    }

    /**
     * @param $event
     * @param $ticket
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit($event, $ticket)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $ticket = $this->ticketRepository->findOrFail($ticket);
            return view('admin::events.tickets.edit', compact('event', 'ticket'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    /**
     * @param StoreTicket $request
     * @param $event
     * @param $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreTicket $request, $event, $ticket)
    {
        try {
            $validated = $request->validated();
            $ticket = $this->ticketRepository->findOrFail($ticket);
            $ticket->update($validated);
            return redirect()->route('events.show', $event);
        } catch (\Exception $exception) {
            abort(422);
        }
    }

    /**
     * @param $event
     * @param $ticket
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $ticket)
    {
        try {
            $ticket = $this->ticketRepository->with([
                'registrations'
            ])->findOrFail($ticket);
            if ($ticket->registrations->count() > 0)
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete', ['name' => 'Ticket']),
                        'errors' => []],
                        422
                    );
            $ticket->delete();
            return response()
                ->json([
                        'message' => __('admin::curd.delete', ['name' => 'Ticket']),
                        'errors' => []]
                );
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'Ticket']),
                    'errors' => []],
                    422
                );
        }
    }
}
