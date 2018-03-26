<?php 

namespace App\Services\Events;

use App\Http\Requests\EventRequest;
use App\Repositories\Interfaces\EventRepository;
use App\Repositories\Interfaces\PlaceRepository;
use Carbon\Carbon;

class EventCreatorService
{
	private $event_repository, $place_repository;

	function __construct(
        EventRepository $event_repository, 
        PlaceRepository $place_repository)
    {
        $this->event_repository = $event_repository;
        $this->place_repository = $place_repository;
    }

    public function make(EventRequest $request)
    {
        $event_data = $request->get('event');
        $place_data = $request->get('place');
        
        \DB::beginTransaction();

        $event = $this->event_repository->create([
            'name' => $event_data['name'],
            'description' => $event_data['description'],
            'start_date' => Carbon::createFromFormat('d.m.Y', $event_data['start_date']),
            'end_date' => Carbon::createFromFormat('d.m.Y', $event_data['end_date']),
            'start_time' => Carbon::createFromFormat('H:i', $event_data['start_time']),
            'end_time' => Carbon::createFromFormat('H:i', $event_data['end_time']),
            'register_deadline' => Carbon::createFromFormat('d.m.Y', $event_data['register_deadline']),
            'participants_limit' => $event_data['participants_limit'],
            'is_public' => isset($event_data['is_public']),
            'user_id' =>  \Auth::user()->id
        ]);

        $place_data['event_id'] = $event->id;
        $place = $this->place_repository->create($place_data);

        \DB::commit();
    }
}