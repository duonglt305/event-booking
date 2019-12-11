<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\StoreSpeaker;
use DG\Dissertation\Admin\Http\Requests\UpdateSpeaker;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\SpeakerRepository;
use DG\Dissertation\Admin\Services\ImageService;
use DG\Dissertation\Admin\Services\SpeakerImageService;
use DG\Dissertation\Admin\Tables\SpeakerTable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;
    /**
     * @var SpeakerRepository
     */
    private $speakerRepository;

    /**
     * @var integer
     */
    private $photoWidth;

    /**
     * @var integer
     */
    private $photoHeight;

    /**
     * SpeakerController constructor.
     * @param EventRepository $eventRepository
     * @param SpeakerRepository $speakerRepository
     */
    public function __construct(EventRepository $eventRepository, SpeakerRepository $speakerRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->speakerRepository = $speakerRepository;
        $this->photoWidth = 500;
        $this->photoHeight = 500;
    }

    /**
     * @param $event
     * @param SpeakerTable $table
     * @return mixed
     */
    public function index($event, SpeakerTable $table)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            set_page_title($event->name . ' | Speaker manage');
            $table->setEvent($event);
            return $table->renderTable();
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
    }

    /**
     * @param $event
     * @param StoreSpeaker $request
     * @param SpeakerImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($event, StoreSpeaker $request, SpeakerImageService $imageService)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $validated = $request->validated();
            $photoName = \Str::slug($validated['firstname'] . '-' . $validated['lastname']);
            $file = $imageService->upload($validated['photo'], $photoName, $event->id, $this->photoWidth, $this->photoHeight);

            $validated['photo'] = $file;
            $validated['event_id'] = $event->id;

            $this->speakerRepository->insert($validated);
            return response()
                ->json([
                        'message' => __('admin::curd.create', ['name' => 'speaker']),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.create', ['name' => 'speaker']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $speaker
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($event, $speaker)
    {
        try {
            $model = $this->speakerRepository->findOrFail($speaker);
            $model->photo = asset($model->photo);
            return response()->json($model, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => __('admin::curd.failed.edit', ['name' => 'Speaker']),
                'errors' => []
            ],
                422
            );
        }
    }

    /**
     * @param $event
     * @param $speaker
     * @param UpdateSpeaker $request
     * @param ImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($event, $speaker, UpdateSpeaker $request, SpeakerImageService $imageService)
    {
        $validated = $request->validated();
        try {
            $model = $this->speakerRepository->findOrFail($speaker);
            if (!empty($validated['update_photo'])) {
                $imageService->delete($model->photo);
                $photoName = \Str::slug($validated['update_firstname'] . '-' . $validated['update_lastname']);
                $file = $imageService->upload($validated['update_photo'], $photoName, $event, $this->photoWidth, $this->photoHeight);

                $validated['update_photo'] = $file;
            } else $validated['update_photo'] = $model->photo;

            $this->speakerRepository->update($model->id, [
                'firstname' => $validated['update_firstname'],
                'lastname' => $validated['update_lastname'],
                'photo' => $validated['update_photo'],
                'company' => $validated['update_company'],
                'position' => $validated['update_position'],
                'description' => $validated['update_description'],
            ]);

            return response()
                ->json([
                    'message' => __('admin::curd.update', ['name' => 'speaker']),
                    'errors' => []
                ]);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'Speaker']),
                    'errors' => [],
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bulkChangesCompany($event, Request $request)
    {
        $validated = $this->validateBulkChangesCompany($request);
        try {
            $ids = json_decode($validated['ids']);
            $this->speakerRepository->updateMany($ids, [
                'company' => $validated['bulk_changes_company']
            ]);
            return response()->json([
                    'message' => __('admin::curd.bulk.change', ['name' => "speaker's company"]),
                    'errors' => []
                ]
            );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.change', ['name' => "speaker's company"]),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateBulkChangesCompany(Request $request)
    {
        return $this->validate($request, [
            'bulk_changes_company' => ['required', 'string'],
            'ids' => ['required', 'string']
        ], [], [
            'bulk_changes_company' => 'company'
        ]);
    }

    /**
     * @param $event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bulkChangesPosition($event, Request $request)
    {
        $validated = $this->validateBulkChangesPosition($request);

        try {
            $ids = json_decode($validated['ids']);
            $this->speakerRepository->updateMany($ids, [
                'position' => $validated['bulk_changes_position']
            ]);
            return response()
                ->json([
                        'message' => __('admin::curd.bulk.change', ['name' => "speaker's position"]),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.change', ['name' => "speaker's position"]),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateBulkChangesPosition(Request $request)
    {
        return $this->validate(
            $request,
            [
                'bulk_changes_position' => ['required', 'string'],
                'ids' => ['required', 'string']
            ], [], [
            'bulk_changes_position' => 'position'
        ]);
    }

    /**
     * @param $event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function bulkChangesDescription($event, Request $request)
    {
        $validated = $this->validateBulkChangesDescription($request);
        try {
            $ids = json_decode($validated['ids']);
            $this->speakerRepository->updateMany($ids, [
                'description' => $validated['bulk_changes_description']
            ]);
            return response()
                ->json([
                        'message' => __('admin::curd.bulk.change', ['name' => "speaker's description"]),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.bulk.failed.change', ['name' => "speaker's description"]),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateBulkChangesDescription(Request $request)
    {
        return $this->validate(
            $request,
            [
                'bulk_changes_description' => ['nullable', 'string'],
                'ids' => ['required', 'string']
            ], [], [
            'bulk_changes_description' => 'description'
        ]);
    }

    /**
     * @param $event
     * @param $speaker
     * @param SpeakerImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $speaker, SpeakerImageService $imageService)
    {
        try {
            $model = $this->speakerRepository->findOrFail($speaker, ['sessions']);
            if ($model->sessions->count() > 0)
                return response()
                    ->json([
                        'message' => __('admin::curd.failed.delete', ['name' => 'speaker']),
                        'errors' => []
                    ], 422);

            if ($this->speakerRepository->delete($model->id)) {
                $imageService->delete($model->photo);
                return response()->json([
                    'message' => __('admin::curd.delete', ['name' => 'speaker']),
                    'errors' => []
                ]);
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'speaker']),
                    'errors' => []
                ], 422);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMany()
    {
        $ids = \request()->get('ids');
        if ($ids) {
            $ids = json_decode($ids);
            $models = $this->speakerRepository->findManyById($ids);

            foreach ($models as $model) {
                $this->deletePhoto($model->photo);
            }

            $this->speakerRepository->deleteMany($ids);
            return response()->json([
                'message' => __('admin::bulk.delete', ['name' => 'speakers']),
                'errors' => []
            ]);
        }
        return response()
            ->json([
                'message' => __('admin::bulk.failed.delete', ['name' => 'speaker']),
                'errors' => []
            ],
                422
            );
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function select2($event)
    {
        try {
            $term = \request()->get('term');
            $models = $this->eventRepository->findOrFail($event)
                ->speakers()
                ->where('firstname', 'like', "%{$term}%")
                ->orWhere('lastname', 'like', "%{$term}%")
                ->paginate(10);
            return response()->json($models, 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'types' => null
            ], 500);
        }
    }
}
