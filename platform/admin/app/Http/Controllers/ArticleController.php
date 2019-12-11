<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Http\Requests\StoreArticle;
use DG\Dissertation\Admin\Http\Requests\UpdateArticle;
use DG\Dissertation\Admin\Repositories\ArticleRepository;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Services\ArticleImageService;
use DG\Dissertation\Admin\Services\ImageService;
use DG\Dissertation\Admin\Supports\ConstantDefine;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ArticleController
 * @package DG\Dissertation\Admin\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var integer
     */
    private $thumbnailWidth;
    /**
     * @var integer
     */
    private $thumbnailHeight;

    /**
     * ArticleController constructor.
     * @param EventRepository $eventRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(EventRepository $eventRepository, ArticleRepository $articleRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->articleRepository = $articleRepository;
        $this->thumbnailWidth = 500;
        $this->thumbnailHeight = 300;
    }

    /**
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            return \DataTables::make($event->articles)
                ->addColumn('actions', function ($article) use ($event) {
                    $updateStatus = ($article->status === ConstantDefine::ARTICLE_STATUS_DRAFT) ? 'Publish' :
                        (($article->status === ConstantDefine::ARTICLE_STATUS_PUBLISH) ? 'Hide' : 'Show');
                    return view('admin::events.articles.components.actions')
                        ->with([
                            'updateStatus' => $updateStatus,
                            'event' => $event,
                            'article' => $article
                        ])->render();
                })
                ->addColumn('title', function ($article) {
                    return '<div class="ml-3">' . $article->title . '</div>';
                })
                ->addColumn('feature', function ($article) {
                    return '<div class="ml-3">' . ($article->is_feature == 1 ? '<i class="fa fa-check text-success">' : '') . '</div>';
                })
                ->addColumn('status', function ($article) {
                    switch ($article->status) {
                        case ConstantDefine::ARTICLE_STATUS_DRAFT:
                        {
                            $text = 'draft';
                            $class = 'badge-warning';
                            break;
                        }
                        case ConstantDefine::ARTICLE_STATUS_HIDE:
                        {
                            $text = 'hide';
                            $class = 'badge-danger';
                            break;
                        }
                        default:
                        {
                            $text = 'publish';
                            $class = 'badge-success';
                        }
                    }
                    return '<label class="badge ' . $class . '">' . $text . '</label>';
                })
                ->addColumn('thumbnail', function ($article) {
                    return '<img class="img-responsive img-thumbnail" src="' . asset($article->thumbnail) . '" style="width:100px">';
                })
                ->removeColumn('id')
                ->rawColumns(['actions', 'status', 'thumbnail', 'title', 'feature'])
                ->addIndexColumn()
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Not found', 'errors' => []], 404);
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
            set_page_title($event->name . ' | Create new article');
            return view('admin::events.articles.create', compact('event'));
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
    }

    /**
     * @param $event
     * @param StoreArticle $request
     * @param ArticleImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($event, StoreArticle $request, ArticleImageService $imageService)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $validated = $request->validated();
            $name = \Str::slug($validated['title']);
            $image = $imageService->upload($validated['thumbnail'], $name, $event->id, $this->thumbnailWidth, $this->thumbnailHeight);
            $validated['thumbnail'] = $image->getPathname();
            $validated['slug'] = $name;
            $validated['event_id'] = $event->id;
            $validated['status'] = ConstantDefine::ARTICLE_STATUS_DRAFT;
            if ($this->articleRepository->insert($validated)) {
                $route = route('events.show', ['event' => $event->id]) . '#articles';
                return response()
                    ->json([
                            'message' => __('admin::curd.create', ['name' => 'article']),
                            'redirect' => $route
                        ]
                    );
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.create', ['name' => 'article']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($event, $article)
    {
        try {
            $article = $this->articleRepository->findOrFail($article);
            $event = $article->event;
            set_page_title($event->name . ' | ' . $article->title);
            return view('admin::events.articles.edit', compact('article', 'event'));
        } catch (ModelNotFoundException $exception) {
            abort(404);
        }
    }

    /**
     * @param $event
     * @param $article
     * @param UpdateArticle $request
     * @param ArticleImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($event, $article, UpdateArticle $request, ArticleImageService $imageService)
    {
        try {
            $article = $this->articleRepository->findOrFail($article);
            $validated = $request->validated();

            /* if has new thumbnail */
            if (isset($validated['thumbnail'])) {
                $name = \Str::slug($validated['title']);
                $image = $imageService->upload($validated['thumbnail'], $name, $event, $this->thumbnailWidth, $this->thumbnailHeight);
                $validated['thumbnail'] = $image->getPathname();
                $imageService->delete($article->thumbnail);
            } else $validated['thumbnail'] = $article->thumbnail;

            if ($this->articleRepository->update($article->id, $validated)) {
                return response()->json([
                        'message' => __('admin::curd.update', ['name' => 'article']),
                        'redirect' => route('events.show', ['event' => $event]) . '#articles'
                    ]
                );
            } else {
                throw new \Exception();
            }
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'article']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    /**
     * @param $event
     * @param $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus($event, $article)
    {
        try {
            $article = $this->articleRepository->findOrFail($article);

            if ($article->status === ConstantDefine::ARTICLE_STATUS_PUBLISH) {
                $status = ConstantDefine::ARTICLE_STATUS_HIDE;
            } else {
                $status = ConstantDefine::ARTICLE_STATUS_PUBLISH;
            }

            if ($this->articleRepository->update($article->id, ['status' => $status])) {
                return response()
                    ->json([
                            'message' => __('admin::curd.update', ['name' => 'article']),
                            'errors' => []
                        ]
                    );
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'article']),
                    'errors' => []
                ],
                    422
                );
        }
    }

    public function setFeature($event)
    {
        try {
            $article = request()->get('id');
            $article = $this->articleRepository->findOrFail($article);
            $feature = $this->articleRepository->firstBy([
                'WHERE' => [
                    ['event_id', '=', $event],
                    ['is_feature', '=', 1]
                ]
            ]);
            if ($feature) $this->articleRepository->update($feature->id, [
                'is_feature' => 0
            ]);
            $this->articleRepository->update($article->id, [
                'is_feature' => 1
            ]);

            return response()
                ->json([
                        'message' => __('admin::curd.update', ['name' => 'article']),
                        'errors' => []
                    ]
                );
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.update', ['name' => 'article']),
                    'errors' => []
                ],
                    422
                );
        }

    }

    /**
     * @param $event
     * @param $article
     * @param ArticleImageService $imageService
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($event, $article, ArticleImageService $imageService)
    {
        try {
            $article = $this->articleRepository->findOrFail($article);
            if ($this->articleRepository->delete($article->id)) {
                $imageService->delete($article->thumbnail);
                return response()
                    ->json([
                            'message' => __('admin::curd.delete', ['name' => 'article']),
                        ]
                    );
            } else throw new \Exception();
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'message' => __('admin::curd.failed.delete', ['name' => 'article']),
                    'errors' => []
                ],
                    422
                );
        }
    }

}
