<?php


namespace DG\Dissertation\Api\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Supports\ConstantDefine;
use DG\Dissertation\Api\Http\Resources\Article as ArticleResource;
use DG\Dissertation\Api\Http\Resources\Event as EventResource;
use DG\Dissertation\Api\Http\Resources\EventDetail as EventDetailResource;
use DG\Dissertation\Api\Models\Article;
use DG\Dissertation\Api\Models\Contact;
use DG\Dissertation\Api\Models\Event;
use DG\Dissertation\Api\Models\Organizer;
use DG\Dissertation\Api\Repositories\EventRepository;
use DG\Dissertation\Api\Repositories\Interfaces\EventRepositoryInterface;
use DG\Dissertation\Api\Repositories\Interfaces\OrganizerRepositoryInterface;
use DG\Dissertation\Api\Repositories\OrganizerRepository;
use DG\Dissertation\Api\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var OrganizerRepositoryInterface
     */
    private $organizerRepository;

    /**
     * EventController constructor.
     * @param EventRepository $eventRepository
     * @param OrganizerRepository $organizerRepository
     */
    public function __construct(EventRepository $eventRepository, OrganizerRepository $organizerRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->organizerRepository = $organizerRepository;
        $this->middleware('api.jwt.auth')->only(['contact']);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $events = $this->eventRepository->
        getModel()
            ->where('status', '=', 1)
            ->orderBy('date')
            ->where(function ($query) {
                return $query->where('date', '>=', now()->toDateTimeString())
                    ->where('status', '=', ConstantDefine::EVENT_STATUS_ACTIVE);
            })
            ->paginate(8);
        return EventResource::collection($events);
    }

    /**
     * @param $organizer
     * @param $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($organizer, $event)
    {
        $organizer = $this->getOrganizerBySlug($organizer);

        if (!$organizer instanceof Organizer)
            return response()->json(['message' => 'Organizer not found.'], 404);

        $event = $this->eventRepository->firstBy(
            ['WHERE' => [
                ['organizer_id', '=', $organizer->id],
                ['slug', '=', $event]
            ]],
            ['channels', 'organizer','tickets','partners','speakers']
        );

        if (!$event instanceof Event)
            return response()->json(['message' => 'Event not found'], 404);

        return response()->json(new EventDetailResource($event));
    }

    /**
     * @param $organizer
     * @return Organizer|null
     */
    protected function getOrganizerBySlug($organizer)
    {
        return $this->organizerRepository->firstBy(
            ['WHERE' => [['slug', '=', $organizer]]]
        );
    }

    public function articles($organizer, $event)
    {
        $organizer = $this->getOrganizerBySlug($organizer);

        if (!$organizer instanceof Organizer)
            return response()->json(['message' => 'Organizer not found.'], 404);

        $articles = $this->eventRepository->firstBy(
            ['WHERE' => [
                ['organizer_id', '=', $organizer->id],
                ['slug', '=', $event]
            ]],
            ['articles']
        )->articles()->where(
            'status', '=', ConstantDefine::ARTICLE_STATUS_PUBLISH
        )->paginate(9);
        return ArticleResource::collection($articles);
    }

    public function articleDetail($organizer, $event, $article)
    {
        if (!$organizer = $this->getOrganizerBySlug($organizer))
            return response()->json(['message' => 'Organizer not found.'], 404);
        $event = $this->eventRepository->firstBy(
            ['WHERE' => [
                ['organizer_id', '=', $organizer->id],
                ['slug', '=', $event]
            ]],
            ['articles' => function ($query) use ($article) {
                return $query->where('slug', '=', $article)
                    ->where('status', '=', ConstantDefine::ARTICLE_STATUS_PUBLISH);
            }]
        );
        $article = $event->articles->first();
        if ($article instanceof Article)
            return response()->json(new ArticleResource($article));
        return response()->json(['message' => 'Article not found'], 404);
    }

    public function contact(Request $request, Recaptcha $recaptcha)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => ['required', 'email'],
                'message' => ['required', 'string', 'max:255'],
                'recaptcha' => ['required', $recaptcha]
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        try {
            Contact::create($request->only(['name', 'email', 'message', 'event_id']));
            return response()->json(['message' => 'Thank you for contact us.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Data cannot be processed.'], 422);
        }
    }
}
