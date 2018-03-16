<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Criteria\IsEventForMe;
use App\Repositories\Interfaces\EventRepository;
use Illuminate\Http\Request;

class EventsController extends Controller
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

    public function show($id, $slug)
    {	
    	$this->event_repository->addCriteria(new IsEventForMe);
    	$event = $this->event_repository->with(['place', 'owner', 'invitations.user'])->find($id);

    	if(empty($event))
    		abort(404);

    	return view('events.show', compact('event'));
    }
}
