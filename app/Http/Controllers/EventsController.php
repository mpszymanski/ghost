<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Criteria\AllowRegisterYet;
use App\Repositories\Eloquent\Criteria\HasUnconfirmedInvitationFor;
use App\Repositories\Eloquent\Criteria\IsEventForMe;
use App\Repositories\Eloquent\Criteria\IsJoinedBy;
use App\Repositories\Eloquent\Criteria\IsOwnedBy;
use App\Repositories\Eloquent\Criteria\NotHappenedYet;
use App\Repositories\Interfaces\EventRepository;
use App\Repositories\Interfaces\InvitationRepository;
use Illuminate\Http\Request;

class EventsController extends Controller
{
	private $event_repository, $invitation_repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EventRepository $event_repository, InvitationRepository $invitation_repository)
    {
        $this->middleware('guest');
        $this->event_repository = $event_repository;
        $this->invitation_repository = $invitation_repository;
    }

    public function index()
    {
        $me = \Auth::user();

        // Get owned events.
        $this->event_repository->addCriteria(new IsOwnedBy($me));
        $owned_events = $this->event_repository
            ->with(['place', 'invitations'])->orderBy('end_date')->all();
        $this->event_repository->resetCriteria();

        // Get events I'm joinde.
        $this->event_repository->addCriteria(new NotHappenedYet);
        $this->event_repository->addCriteria(new IsJoinedBy($me));
        $joined_events = $this->event_repository
            ->with(['place', 'owner', 'invitations'])->orderBy('end_date')->all();
        $this->event_repository->resetCriteria();

        // Get events I'm invited to.
        $this->event_repository->addCriteria(new AllowRegisterYet);
        $this->event_repository->addCriteria(new HasUnconfirmedInvitationFor($me));
        $unconfirmed_events = $this->event_repository
            ->with(['place', 'owner', 'invitations'])->orderBy('end_date')->all();
        $this->event_repository->resetCriteria();

        return view('events.index', compact('owned_events',
            'joined_events', 'unconfirmed_events'));
    }

    public function show($id, $slug)
    {	
    	$event = $this->event_repository->with(['place', 'owner', 'invitations.user'])->find($id);

        $this->authorize('show-event', $event);

    	return view('events.show', compact('event'));
    }

    public function join($id)
    {
        $user = \Auth::user();
        $event = $this->event_repository->find($id);
        
        $this->authorize('join-event', $event);

        try {
            $invitation = $this->invitation_repository->updateOrCreate([
                'event_id' => $event->id,
                'user_id' => $user->id
            ], [
                'is_confirmed' => true
            ]);

            \Alert::success('You join to event: ' . $event->name);

        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            \Alert::danger('Opps! Something went wrong!');
        }
        
        return redirect()->back();
    }

    public function leave($id)
    {
        $user = \Auth::user();
        $event = $this->event_repository->find($id);

        if(! ($user->can('leave-event', $event) || $user->can('join-event', $event))) {
            abort(403);
        }

        $invitation = $this->invitation_repository->findWhere([
            'event_id' => $event->id,
            'user_id' => $user->id
        ])->first();

        $invitation ?? abort(404);
        
        try {
            $invitation = $this->invitation_repository->delete($invitation->id);

            \Alert::success('You leaved event: ' . $event->name);

        } catch(\Exception $e) {
            \Log::error($e->getMessage());
            \Alert::danger('Opps! Something went wrong!');
        }
        
        return redirect()->back();
    }

}
