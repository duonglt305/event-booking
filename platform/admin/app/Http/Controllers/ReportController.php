<?php


namespace DG\Dissertation\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use DG\Dissertation\Admin\Repositories\EventRepository;

class ReportController extends Controller
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index($event)
    {
        try {
            $event = $this->eventRepository->findOrFail($event);
            $sessions = $event->sessions()->with(['speaker','room'])->get();
        } catch (\Exception $exception) {

        }
    }

    public function romCapacity($event)
    {
        $event = $this->eventRepository->with([
            'rooms' => function($query){
                $query->with(['sessions']);
            },
        ])->findOrFail($event);

    }
}
