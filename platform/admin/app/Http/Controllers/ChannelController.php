<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Repositories\ChannelRepository;
use DG\Dissertation\Admin\Repositories\EventRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ChannelController extends Controller
{
    /**
     * @var ChannelRepository
     */
    private $channelRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * ChannelController constructor.
     * @param ChannelRepository $channelRepository
     * @param EventRepository $eventRepository
     */
    public function __construct(ChannelRepository $channelRepository, EventRepository $eventRepository)
    {
        $this->middleware('auth');
        $this->channelRepository = $channelRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request, $event)
    {
        $this->validate($request, [
            'name' => ['required', 'string']
        ]);
        try {
            $this->eventRepository->findOrFail($event)
                ->channels()->create([
                    'name' => $request->get('name')
                ]);
            return response()
                ->json([
                        'message' => __('admin::curd.create', ['name' => 'channel']),
                        'errors' => [],
                    ]
                );
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.create', ['name' => 'channel']),
                    'errors' => []
                ],
                    422
                );
        }

    }

    /**
     * @param Request $request
     * @param $event
     * @param $channel
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $event, $channel)
    {
        $this->validate($request, [
            'name' => ['required', 'string']
        ]);
        try {
            $this->channelRepository->findOrFail($channel)
                ->update([
                    'name' => $request->get('name'),
                ]);
            return response()
                ->json([
                        'message' => __('admin::curd.update'),
                        'errors' => []
                    ]
                );
        } catch (\Exception $e) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update',['name' => 'channel']),
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
                ->channels()
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
     * @param $event
     * @param $channel
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($event, $channel)
    {
        try {
            $channel = $this->channelRepository->with([
                'rooms'
            ])->findOrFail($channel);
            if ($channel->rooms->count() > 0)
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete', ['name' => 'channel']),
                        'errors' => []],
                        422
                    );

            $channel->delete();
            return response()
                ->json([
                    'message' => __('admin::curd.delete',['name' => 'channel']),
                    'errors' => []]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'channel']),
                    'errors' => []],
                    422
                );
        }
    }
}
