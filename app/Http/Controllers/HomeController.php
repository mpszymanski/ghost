<?php

namespace App\Http\Controllers;

use App\Event;
use App\Repositories\Eloquent\Criteria\IsEventForMe;
use App\Repositories\Eloquent\Criteria\NotHappenedYet;
use App\Repositories\Interfaces\EventRepository;
use App\Transformers\MapEventTransformer;
use Carbon\Carbon;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $event_repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepository $event_repository)
    {
        $this->middleware('guest');
        $this->event_repository = $event_repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->event_repository->addCriteria(new NotHappenedYet);
        $this->event_repository->addCriteria(new IsEventForMe);

        $upcomin_events = $this->event_repository
            ->with(['place', 'owner'])
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->take(9);

        return view('home.index', compact('upcomin_events', 'map'));
    }

    /**
     * Return nerby events in json.
     * @param  string $position f.e."45.45465465,32.45123321"
     * @return Json
     */
    public function mapEvents($position)
    {
        $this->event_repository->addCriteria(new NotHappenedYet);

        list($lat, $lng) = explode(',', $position);

        $events = $this->event_repository
            ->eventsNearby($lat, $lng, $distance = 5)
            ->take(1000);

        $events = MapEventTransformer::transform($events);

        return $events;
    }
}
