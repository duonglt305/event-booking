<?php

namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DG\Dissertation\Admin\Http\Requests\StoreSession;
use DG\Dissertation\Admin\Http\Requests\UpdateSession;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\SessionRepository;

class SessionController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var SessionRepository
     */
    private $sessionRepository;

    /**
     * SessionController constructor.
     * @param EventRepository $eventRepository
     * @param SessionRepository $sessionRepository
     */
    public function __construct(EventRepository $eventRepository, SessionRepository $sessionRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->sessionRepository = $sessionRepository;
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $sessions = $event->sessions()->with(['sessionType', 'speaker', 'room' => function ($query) {
                return $query->with(['channel']);
            }])
                ->orderBy('start_time')
                ->orderBy('end_time')->get();

            return \DataTables::make($sessions)
                ->editColumn('time', function ($session) {
                    $startTime = Carbon::parse($session->start_time);
                    $endTime = Carbon::parse($session->end_time);
                    $sameDate = $startTime->isSameAs($endTime);
                    if ($sameDate) {
                        $text = $startTime->format('d/m/Y') . ', ' . $startTime->format('H:i') . ' - ' . $endTime->format('H:i');
                    } else {
                        $text = $startTime->format('d/m/Y') . ', ' . $startTime->format('H:i') . ' - ' . $endTime->format('d/m/Y') . ', ' . $endTime->format('H:i');
                    }
                    return $text;
                })
                ->editColumn('type', function ($session) {
                    return $session->sessionType->name;
                })
                ->editColumn('title', function ($session) {
                    return '<div class="text-left ml-3">' . $session->title . '</div>';
                })
                ->editColumn('speaker', function ($session) {
                    $name = $session->speaker->firstname . ' ' . $session->speaker->lastname;
                    return '<div class="text-left ml-3">' . $name . '</div>';
                })
                ->editColumn('channel', function ($session) {
                    return '<div class="text-left ml-3">' . $session->room->channel->name . ' / ' . $session->room->name . '</div>';
                })
                ->editColumn('actions', function ($session) use ($event) {
                    return view('admin::events.sessions.components.actions')
                        ->with([
                            'event' => $event,
                            'session' => $session
                        ]);
                })
                ->removeColumn('id')
                ->rawColumns(['title', 'speaker', 'channel'])
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
//            return response()->json(['message' => 'Not found', 'errors' => []], 404);
            return response()->json(['message' => $e->getMessage(), 'errors' => []], 404);
        }
    }

    /**
     * @param $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            return view('admin::events.sessions.create', compact('event'));
        } catch (\Exception $exception) {
            abort(404);
        }

    }

    /**
     * @param $event
     * @param StoreSession $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($event, StoreSession $request)
    {
        try {
            $validated = $request->validated();
            $validated['start_time'] = Carbon::parse(str_replace('/', '-', $validated['start_time']))->toDateTimeString();
            $validated['end_time'] = Carbon::parse(str_replace('/', '-', $validated['end_time']))->toDateTimeString();

            if ($this->sessionRepository->insert($validated)) {
                return response()
                    ->json([
                            'message' => __('admin::curd.create', ['name' => 'session']),
                            'url' => route('events.show', $event)]
                    );
            } else {
                throw new \Exception();
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => __('admin::curd.failed.create', ['name' => 'session']),
                'errors' => []
            ],
                422
            );
        }
    }

    /**
     * @param $event
     * @param $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($event, $session)
    {
        try {
            $model = $this->sessionRepository->findOrFail($session, ['speaker', 'room', 'sessionType']);
            $model->start_time = date('d/m/Y H:i', strtotime($model->start_time));
            $model->end_time = date('d/m/Y H:i', strtotime($model->end_time));
            $model->channel = $model->room->channel;
            return response()->json($model, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => __('admin::curd.failed.edit', ['name' => 'session']),
                'errors' => []
            ], 422
            );
        }
    }

    /**
     * @param $event
     * @param $session
     * @param UpdateSession $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($event, $session, UpdateSession $request)
    {
        try {
            $model = $this->sessionRepository->findOrFail($session);
            $validated = $request->validated();
            $validated['session_start_time'] = Carbon::parse(str_replace('/', '-', $validated['session_start_time']))->toDateTimeString();
            $validated['session_end_time'] = Carbon::parse(str_replace('/', '-', $validated['session_end_time']))->toDateTimeString();

            if ($this->sessionRepository->update($model->id, [
                'title' => $validated['session_title'],
                'session_type_id' => $validated['session_session_type_id'],
                'speaker_id' => $validated['session_speaker_id'],
                'room_id' => $validated['session_room_id'],
                'start_time' => $validated['session_start_time'],
                'end_time' => $validated['session_end_time'],
                'description' => $validated['session_description'],
            ])) {
                return response()
                    ->json([
                            'message' => __('admin::curd.update', ['name' => 'session']),
                            'url' => route('events.show', $event)]
                    );
            } else {
                throw new \Exception();
            }
        } catch (\Exception $exception) {
            return response()->json([
                'message' => __('admin::curd.failed.update', ['name' => 'session']),
                'errors' => []
            ], 422
            );
        }
    }

    /**
     * @param $event
     * @param $session
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $session)
    {
        try {
            $model = $this->sessionRepository->findOrFail($session);

            if ($model->registrations->count() > 0) {
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete', ['name' => 'session']),
                        'errors' => []
                    ],
                        422
                    );
            }

            $this->sessionRepository->delete($model->id);
            return response()
                ->json([
                        'message' => __('admin::curd.delete', ['name' => 'session'])
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'session']),
                    'errors' => []
                ],
                    422
                );
        }
    }
}
