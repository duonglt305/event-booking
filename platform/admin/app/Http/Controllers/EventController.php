<?php


namespace DG\Dissertation\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DG\Dissertation\Admin\Http\Requests\UpdateEvent;
use DG\Dissertation\Admin\Http\Requests\StoreEvent;
use DG\Dissertation\Admin\Models\Organizer;
use DG\Dissertation\Admin\Repositories\AttendeeRepository;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\RegistrationRepository;
use DG\Dissertation\Admin\Repositories\SessionRepository;
use DG\Dissertation\Admin\Repositories\TicketRespository;
use DG\Dissertation\Admin\Services\EventImageService;
use DG\Dissertation\Admin\Supports\ConstantDefine;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use function foo\func;

class EventController extends Controller
{
    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @var AttendeeRepository
     */
    protected $attendeeRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;

    /**
     * @var TicketRespository
     */
    protected $ticketRepository;

    /**
     * @var RegistrationRepository
     */
    protected $registrationRepository;

    /**
     * @var Organizer
     */
    protected $organizer;
    /**
     * @var EventImageService
     */
    private $imageService;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     * @param AttendeeRepository $attendeeRepository
     * @param EventImageService $imageService
     * @param SessionRepository $sessionRepository
     * @param TicketRespository $ticketRepository
     * @param RegistrationRepository $registrationRepository
     */
    public function __construct(
        EventRepository $eventRepository,
        AttendeeRepository $attendeeRepository,
        EventImageService $imageService,
        SessionRepository $sessionRepository,
        TicketRespository $ticketRepository,
        RegistrationRepository $registrationRepository
    )
    {
        $this->middleware('auth');
        $this->imageService = $imageService;
        $this->eventRepository = $eventRepository;
        $this->attendeeRepository = $attendeeRepository;
        $this->sessionRepository = $sessionRepository;
        $this->ticketRepository = $ticketRepository;
        $this->registrationRepository = $registrationRepository;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        set_page_title('Manage your event');
        $events = auth()->user()->events()
            ->with(['registrations', 'channels', 'rooms'])
            ->orderBy('date')
            ->paginate(10);
        return view('admin::events.index', compact('events'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        set_page_title('Create new event');
        return view('admin::events.create');
    }

    /**
     * @param StoreEvent $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEvent $request)
    {
        $validated = $request->validated();
        try {
            $validated['thumbnail'] = $this->imageService
                ->uploadEventThumbnail($request->file('thumbnail'), $validated['slug']);
            $event = $this->eventRepository->insert($validated);
            return redirect()->route('events.show', $event->id);
        } catch (\Exception $e) {
            return back()
                ->withErrors(['name' => [$e->getMessage()]])
                ->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $event = $this->eventRepository
            ->findOrFail(
                $id,
                ['channels.rooms', 'channels.sessions', 'tickets.registrations']
            );
        set_page_title($event->name);
        return view('admin::events.detail', compact('event'));
    }

    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function edit($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            set_page_title($event->name);
            return view('admin::events.update', compact('event'));
        } catch (\Exception $exception) {
            return abort(404);
        }
    }

    /**
     * @param $event
     * @param UpdateEvent $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($event, UpdateEvent $request)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $validate = $request->validated();
            if (isset($validate['thumbnail'])) {
                $validate['thumbnail'] = $this->imageService
                    ->uploadEventThumbnail($request->file('thumbnail'), $validate['slug']);
                $this->imageService->delete($event->thumbnail);
            } else $validate['thumbnail'] = $event->thumbnail;
            if ($this->eventRepository->update($event->id, $validate)) {
                return redirect()->route('events.show', $event->id);
            } else throw new \Exception();
        } catch (ModelNotFoundException $exception) {
            return abort(404);
        }
    }

    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roomCapacity($event)
    {
        $event = $this->eventRepository->findOrFail($event);
        return view('admin::events.room_capacity', compact('event'));
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function roomCapacityData($event)
    {
        $event = $this->eventRepository
            ->findOrFail(
                $event,
                ['sessions.sessionType', 'sessions.room', 'sessions.registrations']
            );
        $sessions = $event->sessions
            ->map(function ($session) use ($event) {
                if (intval($session->sessionType->cost) !== 0)
                    $session->attendees = $session->registrations->count();
                else $session->attendees = $event->registrations->count();
                $session->room_capacities = $session->room->capacity;
                return $session;
            })
            ->sortBy('start_time')
            ->values()
            ->toArray();
        return response()->json(['sessions' => $sessions]);
    }

    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report($event)
    {
        $event = $this->eventRepository->findOrFail($event);
        $time = Carbon::now();
        $today = [
            'from' => $time->toDateString(),
            'to' => $time->toDateString()
        ];

        $lastTenDay = [
            'to' => $time->toDateString(),
            'from' => $time->subDays(10)->toDateString(),
        ];

        set_page_title($event->name . ' | Report');
        return view('admin::events.report', compact('event', 'today', 'lastTenDay'));
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function reportData($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event, [
                'tickets.registrations',
                'sessions' => function ($query) {
                    $query->orderBy('start_time');
                },
                'sessions.registrations',
                'sessions.sessionRatings',
                'articles',
                'partners',
                'rooms',
                'articles',
                'partners',
                'channels.rooms',
                'channels.sessions',
            ]);
            return response()->json(['event' => $event]);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Opp... have an error'], 422);
        }
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeeRegistrationReport($event)
    {
        try {
            $time = resolve_between_time(request()->post('from', null), request()->post('to', null));

            $event = $this->eventRepository->findOrFail($event, [
                'registrations' => function ($query) use ($time) {
                    return $query->whereBetween('registrations.created_at', [$time['from'], $time['to']]);
                }
            ]);

            $days = [];

            $fromDate = Carbon::parse($time['from']);
            $toDate = Carbon::parse($time['to']);

            while ($fromDate->lte($toDate)) {
                $days[$fromDate->format('d/m/Y')] = 0;

                $fromDate->addDay();
            }

            $registrations = $event->registrations->toArray();

            foreach ($registrations as $registration) {
                $day = Carbon::parse($registration['created_at'])->format('d/m/Y');
                $days[$day]++;
            }
            return response()->json(['registrations' => $days]);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Opp... have an error'], 422);
        }
    }


    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attendeesVerifyShow($event)
    {
        $event = $this->eventRepository->findOrFail($event);
        return view('admin::events.attendees-verify', compact('event'));
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeesVerify($event)
    {
        $code = request()->post('code', '');
        $session = request()->post('session', '');

        if (empty($code) && empty($session)) {
            return response()->json([
                'message' => 'Data is invalid',
            ], 422);
        }

        $session = $this->sessionRepository->findOrFail($session, ['sessionType', 'room', 'speaker']);
        $session->start_time = date('d/m/Y H:i', strtotime($session->start_time));
        $session->end_time = date('d/m/Y H:i', strtotime($session->end_time));

        $event = $this->eventRepository->findOrFail($event, ['tickets']);

        $eventTickets = $event->tickets->pluck('id');

        $attendee = $this->attendeeRepository->firstBy(
            ['WHERE' => [['registration_code', '=', $code]]],
            [
                'registrations',
                'registrations.ticket',
                'registrations.sessions' => function ($query) use ($session) {
                    return $query->where('session_id', $session->id);
                }
            ]
        );

        if (empty($attendee)) {
            return response()->json([
                'message' => 'There are no attendee with provided code',
                'type' => 'attendee_not_found'
            ]);
        }

        $attendee = $attendee->toArray();


        $isSessionPremium = $session->sessionType->cost > 0;

        $attendeeTickets = collect($attendee['registrations'])
            ->map(function ($registration) {
                return $registration['ticket']['id'];
            });

        $sessionRegistration = collect($attendee['registrations'])
            ->first(function ($val, $key) {
                return !empty($val['sessions']);
            });

        $ticket = null;
        foreach ($eventTickets as $item) {
            if ($attendeeTickets->contains($item)) {
                $ticket = $item;
                break;
            }
        }

        $ticket = $this->ticketRepository->findById($ticket, [
            'registrations' => function ($query) use ($attendee) {
                return $query->where('attendee_id', $attendee['id']);
            }
        ]);

        $verifyHistory = json_decode(!empty($ticket->registrations[0]) ? $ticket->registrations[0]->verify_history : '[]');

        if (!empty($verifyHistory)) {
            $check = null;
            foreach ($verifyHistory as $history) {
                if ($history->session_id == $session->id) {
                    $check = $history;
                    break;
                }
            }

            if ($check) {
                return response()->json([
                    'message' => 'Attendee is already verify this session. <br>Verify at: ' . date('d/m/Y H:i', strtotime($check->verify_at)),
                    'type' => 'already_verified'
                ]);
            }
        }

        if (empty($attendee['registrations'])) {
            return response()->json([
                'message' => 'There is no attendee\'s registration for any events',
                'type' => 'no_registration'
            ]);
        } else {

            if ($isSessionPremium && !empty($sessionRegistration)) {
                return response()->json([
                    'session' => $session,
                    'attendee' => $attendee,
                    'ticket' => $ticket
                ]);
                // attendee is register for premium session
            } else if ($isSessionPremium && empty($sessionRegistration)) {
                // attendee is register for event but not register for this premium session
                return response()->json([
                    'message' => 'There is no attendee\'s registration for this session',
                    'type' => 'no_registration'
                ]);
            } else {
                // attendee is just register for event
                if (!empty($ticket)) {
                    return response()->json([
                        'session' => $session,
                        'ticket' => $ticket,
                        'attendee' => $attendee,

                    ]);
                } else {
                    return response()->json([
                        'message' => 'There is no attendee\'s registration for this event',
                        'type' => 'no_registration'
                    ]);
                }
            }
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function attendeesVerifyUpdate()
    {
        $attendeeId = request()->post('attendee_id', '');
        $sessionId = request()->post('session_id', '');
        $registrationId = request()->post('registration_id', '');

        if (empty($attendeeId) && empty($sessionId) && empty($registrationId)) {
            return response()->json([
                'message' => 'Data is invalid',
            ], 422);
        }

        $registration = $this->registrationRepository->findOrFail($registrationId);
        $session = $this->sessionRepository->findOrFail($sessionId);

        $verifyHistory = json_decode(empty($registration->verify_history) ? '[]' : $registration->verify_history);
        $verifyHistory[] = [
            'session_id' => $session->id,
            'verify_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->registrationRepository->update($registration->id, ['verify_history' => json_encode($verifyHistory)]);

        return $result ? response()->json([
            'message' => 'Verify to attendee to session successful'
        ]) : response()->json([
            'message' => 'Verify to attendee to session failed'
        ], 500);
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function sessionSelect($event)
    {
        $key = request()->key;
        $type = request()->type;
        $type_id = request()->type_id;
        $event = $this->eventRepository->findOrFail($event);
        switch ($type) {
            case 'rooms':
            {
                $sessions = $event->rooms()
                    ->where('rooms.id', $type_id)
                    ->with(['sessions' => function ($query) use ($key) {
                        return $query->where('title', 'like', "%{$key}%");
                    }, 'sessions.sessionType'])
                    ->first()
                    ->sessions
                    ->toArray();
                break;
            }
            case 'channels':
            {
                $sessions = $event->channels()
                    ->where('channels.id', $type_id)
                    ->with(['sessions' => function ($query) use ($key) {
                        return $query->where('title', 'like', "%{$key}%");
                    }, 'sessions.sessionType'])
                    ->first()
                    ->sessions
                    ->toArray();
                break;
            }
            default:
                $sessions = [];
                break;
        }

        return response()->json($sessions);
    }

    public function updateStatus($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            if ($event->status == ConstantDefine::EVENT_STATUS_ACTIVE)
                $event->status = ConstantDefine::EVENT_STATUS_PENDING;
            else $event->status = ConstantDefine::EVENT_STATUS_ACTIVE;

            if ($event->save()) {
                return response()->json([
                    'message' => __('admin::curd.update', ['name' => 'event']),
                    'errors' => []
                ]);
            } else {
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.update', ['name' => 'event']),
                        'errors' => []
                    ],
                        422
                    );
            }

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'event']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    public function registrations($event)
    {
        try {
            set_page_title('Attendee registration');
            $event = $this->eventRepository->findOrFail($event);
            return view('admin::events.registrations', compact('event'));
        } catch (\Exception $exception) {
            abort(404);
        }

    }

    /**
     * @param $event
     * @param Request $request
     */
    public function datatableRegistrations($event, Request $request)
    {
        try {
            $type = $request->get('status', 'paid');
            $event = $this->eventRepository->findById(
                $event,
                [
                    'registrations' => function ($query) use ($type) {
                        return $query->where('status', strtoupper($type));
                    },
                    'registrations.attendee'
                ]);

            return \DataTables::make($event->registrations)
                ->rawColumns(['full_name'])
                ->addColumn('full_name', function ($registration) {
                    $attendee = $registration->attendee;
                    return '<div class="text-left" style="padding-left: 20px">' . $attendee->firstname . ' ' . $attendee->lastname . '</div>';
                })
                ->addColumn('registered_at', function ($registration) {
                    return date('d/m/Y H:i', strtotime($registration->created_at));
                })
                ->addIndexColumn()
                ->toJson();

        } catch (\Exception $exception) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
        }
    }
}
