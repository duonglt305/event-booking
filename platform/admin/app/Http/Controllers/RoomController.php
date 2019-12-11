<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\StoreRoom;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\RoomRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\Store;

class RoomController extends Controller
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * RoomController constructor.
     * @param RoomRepository $roomRepository
     * @param EventRepository $eventRepository
     */
    public function __construct(RoomRepository $roomRepository, EventRepository $eventRepository)
    {
        $this->middleware('auth');
        $this->roomRepository = $roomRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($event)
    {
        try {
            $event = $this->eventRepository->with([
                'rooms',
            ])->findOrFail($event);

            return \DataTables::make($event->rooms)
                ->editColumn('capacity', function ($room) {
                    return number_format($room->capacity);
                })
                ->addColumn('action', function ($room) {
                    return view('admin::events.rooms.components.actions', compact('room'));
                })
                ->removeColumn('id')
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
        }
    }

    /**
     * @param StoreRoom $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoom $request)
    {
        try {
            $validated = $request->validated();
            $this->roomRepository->insert($validated);
            return response()
                ->json([
                        'message' => __('admin::curd.create', ['name' => 'room']),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json(
                    [
                        'message' => __('admin::curd.create', ['name' => 'room']),
                        'errors' => []
                    ],
                    422
                );
        }

    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function select2($event)
    {
        try {
            $models = $this->eventRepository->findOrFail($event)
                ->rooms()
                ->with('channel')
                ->paginate(10);
            return response()->json($models, 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'types' => null,
                'errors' => $exception->getMessage()
            ], 422);
        }
    }

    /**
     * @param StoreRoom $request
     * @param $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreRoom $request, $room)
    {
        try {
            $validated = $request->validated();
            $room = $this->roomRepository->findOrFail($room);
            if ($this->roomRepository->update($room->id, $validated)) {
                return response()
                    ->json([
                        'message' => __('admin::curd.update', ['name' => 'room'])
                    ]);
            } else {
                throw new \Exception();
            }

        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'room']),
                    'errors' => []
                ],
                    422
                );
        }

    }

    /**
     * @param $room
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($room)
    {
        try {
            $room = $this->roomRepository->with([
                'sessions'
            ])->findOrFail($room);
            if ($room->sessions->count() > 0)
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete'),
                        'errors' => []
                    ], 422);
            $room->delete();
            return response()
                ->json([
                        'message' => __('admin::curd.delete'),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete'),
                    'errors' => []
                ], 422);
        }

    }

}
