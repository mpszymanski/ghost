<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upcomin_events = Event::with(['place', 'owner'])
            ->whereDate('end_date', '>', Carbon::tomorrow())
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->take(9)->get();

        return view('home.index', compact('upcomin_events', 'map'));
    }

    public function mapEvents($position)
    {
        list($lat, $lng) = explode(',', $position);

        // TODO: Move this query to repository
        $events = Event::join('places', 'places.event_id', '=', 'events.id')
            ->selectRaw("events.id, events.end_date, places.event_id, places.name, places.lat, places.lng, ( ACOS( COS( RADIANS( $lat ) ) 
                  * COS( RADIANS( lat ) )
                  * COS( RADIANS( lng ) - RADIANS( $lng ) )
                  + SIN( RADIANS( $lat  ) )
                  * SIN( RADIANS( lat ) )
              )
            * 6371
            ) AS distance")
            ->whereDate('events.end_date', '>', Carbon::tomorrow())
            ->having('distance', '<', 5)
            ->take(1000)
            ->get();

        // TODO: Move this code to Transformer
        $events = $events->map(function($event) {
            $e = [];
            $e['name'] = $event->name;
            $e['place_name'] = $event->place->name;
            $e['position'] = [];
            $e['position']['lat'] = (double)$event->place->lat;
            $e['position']['lng'] = (double)$event->place->lng;
            return $e;
        });

        return $events;
    }
}
