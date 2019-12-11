<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\UpdateSessionType;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\SessionTypeRepository;
use DG\Dissertation\Admin\Tables\SessionTypeTable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SessionTypeController
 * @package DG\Dissertation\Admin\Http\Controllers
 */
class SessionTypeController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var SessionTypeRepository
     */
    private $sessionTypeRepository;

    /**
     * SessionTypeController constructor.
     * @param EventRepository $eventRepository
     * @param SessionTypeRepository $sessionTypeRepository
     */
    public function __construct(EventRepository $eventRepository, SessionTypeRepository $sessionTypeRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->sessionTypeRepository = $sessionTypeRepository;
    }

    /**
     * @param $event
     * @param SessionTypeTable $table
     * @return mixed
     */
    public function index($event, SessionTypeTable $table)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            set_page_title($event->name . ' | Session type manage');
            $table->setEvent($event);
            return $table->renderTable();
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
    }

    /**
     * @param Request $request
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $event)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'string'],
            'cost' => ['nullable', 'numeric', 'integer', 'min:0']
        ]);
        try {
            $this->eventRepository->findOrFail($event)
                ->sessionTypes()->create($validated);
            return response()
                ->json([
                    'message' => __('admin::curd.create', ['name' => 'session type']),
                    'errors' => []
                ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.create', ['name' => 'session type']),
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
            $term = \request()->get('term');
            $sessionTypes = $this->eventRepository->findOrFail($event)
                ->sessionTypes()
                ->where('name', 'like', "%{$term}%")
                ->get()->map(function ($sessionType) {
                    $sessionType->cost = $sessionType->cost ?? 'Free';
                    return $sessionType;
                });
            return response()
                ->json([
                        'types' => $sessionTypes,
                        'errors' => []]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                        'types' => null,
                        'errors' => [$exception->getMessage()]
                    ]
                );
        }
    }

    /**
     * @param $event
     * @param $sessionTypeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($event, $sessionTypeId)
    {
        try {
            $model = $this->sessionTypeRepository->findById($sessionTypeId);
            return response()->json($model);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.edit', ['name' => 'session type']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $sessionTypeId
     * @param UpdateSessionType $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($event, $sessionTypeId, UpdateSessionType $request)
    {
        try {
            $validated = $request->validated();
            $model = $this->sessionTypeRepository->findOrFail($sessionTypeId);
            $this->sessionTypeRepository->update($model->id, [
                'name' => $validated['session_type_name'],
                'cost' => $validated['session_type_cost']
            ]);
            return response()
                ->json([
                        'message' => __('admin::curd.update', ['name' => 'session type']),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'session type']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function bulkChangeName($event, Request $request)
    {
        $validated = $this->validateBulkChangeName($request);
        try {
            $ids = json_decode($validated['ids']);
            $this->sessionTypeRepository->updateMany($ids, ['name' => $validated['bulk_change_name']]);
            return response()
                ->json([
                        'message' => __('admin::curd.bulk.change', ['name' => "session type's name"]),
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.change', ['name' => "session type's name"]),
                    'errors' => []
                ], 422);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function validateBulkChangeName(Request $request)
    {
        return $this->validate($request, [
            'bulk_change_name' => ['required', 'string'],
            'ids' => ['required']
        ]);
    }

    /**
     * @param $event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function bulkChangeCost($event, Request $request)
    {
        try {
            $validate = $this->validateBulkChangeCost($request);
            $ids = json_decode($validate['ids']);
            $this->sessionTypeRepository->updateMany($ids, ['cost' => $validate['bulk_change_cost']]);
            return response()
                ->json([
                        'message' => __('admin::curd.bulk.change', ['name' => "session type's cost"])
                    ]
                );
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.change', ['name' => "session type's cost"]),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    private function validateBulkChangeCost(Request $request)
    {
        return $this->validate($request, [
            'bulk_change_cost' => ['nullable', 'numeric', 'integer'],
            'ids' => ['required']
        ]);
    }

    /**
     * @param $event
     * @param $sessionTypeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $sessionTypeId)
    {
        try {
            $model = $this->sessionTypeRepository->findOrFail($sessionTypeId);
            if ($model->sessions->count > 0)
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete', ['name' => 'session type']),
                        'errors' => []
                    ],
                        422
                    );

            $this->sessionTypeRepository->delete($model->id);
            return response()
                ->json([
                    'message' => __('admin::curd.delete', ['name' => 'session type'])
                ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'session type']),
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
    public function destroyMany($event)
    {
        try {
            $ids = \request()->get('ids');
            $ids = json_decode($ids);
            $model = $this->sessionTypeRepository
                ->allBy(['WHERE' => [['id', 'IN', $ids]]], ['sessions'])
                ->first(function ($model) {
                    return !empty($model->sessions);
                });
            if (!is_null($model))
                return response()
                    ->json([
                        'message' => __('admin::curd.bulk.failed.delete', ['name' => 'session type']),
                        'errors' => []
                    ],
                        422
                    );

            $this->sessionTypeRepository->deleteMany($ids);
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.delete', ['name' => 'session type'])
                ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.delete', ['name' => 'session type']),
                    'errors' => []
                ],
                    422
                );
        }
    }
}
