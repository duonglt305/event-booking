<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Repositories\EventRepository;
use DG\Dissertation\Admin\Supports\ConstantDefine;

class DashboardController extends Controller
{
    /**
     * @var EventRepository;
     */
    private $eventRepository;

    /**
     * DashboardController constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->middleware('auth');
        $this->eventRepository = $eventRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin::dashboard');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $events = $this->eventRepository->allBy(
            ['WHERE' => [['organizer_id', '=', auth()->user()->id]]],
            [
                'sessions' => function ($query) {
                    $query->orderBy('end_time', 'desc');
                },
                'ratings' => function ($query) {
                    $query->avg('rate');
                },
                'registrations'
            ]
        );


        $totalEvents = $events->count();
        $tookPlaceEvents = 0;
        $upcomingEvents = 0;
        $ongoingEvents = 0;
        $totalEventUnComplete = 0;
        $activeEvent = 0;
        $pendingEvent = 0;

        $registrations = [];

        $averages = [];

        foreach ($events as $event) {
            /* Get end sesssion end time*/
            $event->status == ConstantDefine::EVENT_STATUS_ACTIVE ? $activeEvent++ : $pendingEvent++;
            $endTime = $event->sessions->first();
            if ($endTime) {
                $ctime = time();
                /* event start time */
                $eventStartDate = strtotime($event->date);
                /* event end time */
                $eventEndTime = strtotime($endTime->end_time);

                if ($eventStartDate < $ctime && $ctime < $eventEndTime) $ongoingEvents++;

                if ($eventEndTime < $ctime) $tookPlaceEvents++;

                if ($ctime < $eventStartDate) {
                    $upcomingEvents++;
                    $reTmp = $event->registrations->filter(function ($item) {
                        return $item->status == 'PAID';
                    });
                    $registrations[] = [
                        'event_id' => $event->id,
                        'event_name' => $event->name,
                        'registrations' => array_values($reTmp->toArray())
                    ];
                };

                if ((($eventStartDate < $ctime && $ctime < $eventEndTime) || $ctime < $eventStartDate) && $event->ratings->count() > 0) {
                    $average = 0;
                    foreach ($event->ratings as $rating) {
                        $average += intval($rating->rate);
                    }
                    $averages[] = [
                        'total_ratings' => $event->ratings->count(),
                        'id' => $event->id,
                        'title' => $event->name,
                        'average' => round($average / $event->ratings->count(), 2),
                        'percent' => round(round($average / $event->ratings->count(), 2) / 5, '2') * 100
                    ];
                } else {
                    $averages[] = [
                        'total_ratings' => 0,
                        'id' => $event->id,
                        'title' => $event->name,
                        'average' => 0
                    ];
                }
            } else $totalEventUnComplete++;
        }

        $averages = collect($averages)->sortByDesc('average')->toArray();

        return response()->json([
            'total_events' => $totalEvents,
            'took_place_events' => $tookPlaceEvents,
            'upcoming_events' => $upcomingEvents,
            'ongoing_events' => $ongoingEvents,
            'total_un_complete_events' => $totalEventUnComplete,
            'averages' => $averages,
            'registrations' => $registrations,
            'active_event' => $activeEvent,
            'pending_event' => $pendingEvent
        ]);
    }
}
