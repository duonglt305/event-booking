<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\StorePartner;
use DG\Dissertation\Admin\Http\Requests\UpdatePartner;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Repositories\Interfaces\PartnerRepositoryInterface;
use DG\Dissertation\Admin\Repositories\PartnerRepository;
use DG\Dissertation\Admin\Services\ImageService;
use DG\Dissertation\Admin\Services\PartnerImageServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PartnerController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var PartnerRepository
     */
    private $partnerRepository;
    /**
     * @var integer
     */
    private $logoWidth;

    /**
     * @var integer
     */
    private $logoHeight;

    /**
     * PartnerController constructor.
     * @param EventRepository $eventRepository
     * @param PartnerRepository $partnerRepository
     */
    public function __construct(EventRepository $eventRepository, PartnerRepository $partnerRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->partnerRepository = $partnerRepository;
        $this->logoWidth = 300;
        $this->logoHeight = 300;
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            return \DataTables::make($event->partners)
                ->addColumn('actions', function ($partner) use ($event) {
                    return view('admin::events.partners.components.actions')
                        ->with([
                            'event' => $event,
                            'partner' => $partner
                        ]);
                })
                ->addColumn('name', function ($partner) {
                    return '<div class="ml-2">' . $partner->name . '</div>';
                })
                ->addColumn('logo', function ($partner) {
                    return '<div class="text-center"><img class="img-responsive" style="width: 100px" src="' . asset($partner->logo) . '" alt=""></div>';
                })
                ->addColumn('description', function ($partner) {
                    return '<div class="ml-2">' . (empty($partner->description) ? 'N/A' : $partner->description) . '</div>';
                })
                ->removeColumn('id')
                ->rawColumns(['logo', 'actions', 'description', 'name'])
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
        }
    }

    /**
     * @param $event
     * @param StorePartner $request
     * @param PartnerRepositoryInterface $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($event, StorePartner $request, PartnerImageServices $imageService)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $validated = $request->validated();
            $image = $imageService->upload($validated['logo'], $validated['name'], $event->id, $this->logoWidth, $this->logoHeight);
            $validated['logo'] = $image->getPathname();
            $validated['event_id'] = $event->id;
            if ($this->partnerRepository->insert($validated)) {
                return response()->json([
                    'message' => __('admin::curd.create', ['name' => 'partner'])
                ]);
            } else throw  new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.create', ['name' => 'partner']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $partner
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($event, $partner)
    {
        try {
            $partner = $this->partnerRepository->findOrFail($partner);
            $partner->logo = asset($partner->logo);
            return response()->json($partner, 200);
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.edit', ['name' => 'partner']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $partner
     * @param UpdatePartner $request
     * @param ImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($event, $partner, UpdatePartner $request, PartnerImageServices $imageService)
    {
        try {
            $partner = $this->partnerRepository->findOrFail($partner);
            $validated = $request->validated();
            if (isset($validated['logo'])) {
                $image = $imageService->upload($validated['logo'], $validated['name'], $event, $this->logoWidth, $this->logoHeight);
                $validated['logo'] = $image->getPathname();
                $imageService->delete($partner->logo);
            } else $validated['logo'] = $partner->logo;
            if ($this->partnerRepository->update($partner->id, $validated)) {
                return response()
                    ->json([
                            'message' => __('admin::curd.update', ['name' => 'partner'])
                        ]
                    );
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'partner']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $partner
     * @param PartnerImageServices $imageServices
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $partner, PartnerImageServices $imageServices)
    {
        try {
            $partner = $this->partnerRepository->findOrFail($partner);
            if ($this->partnerRepository->delete($partner->id)) {
                $imageServices->delete($partner->logo);
                return response()
                    ->json([
                        'message' => __('admin::curd.delete', ['name' => 'partner'])
                    ]);
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'partner']),
                    'errors' => []
                ], 422
                );
        }
    }
}
