<?php 

namespace App\Services\Events;

use App\Repositories\Eloquent\Criteria\AllowRegisterYet;
use App\Repositories\Eloquent\Criteria\HasUnconfirmedInvitationFor;
use App\Repositories\Eloquent\Criteria\IsJoinedBy;
use App\Repositories\Eloquent\Criteria\IsOwnedBy;
use App\Repositories\Eloquent\Criteria\NotHappenedYet;
use App\Repositories\Interfaces\EventRepository;

class UserEventsFetcherService
{
	private $event_repository;

	function __construct(EventRepository $event_repository)
    {
        $this->event_repository = $event_repository;
    }

    public function ownEvents()
    {
    	$this->event_repository->addCriteria(new IsOwnedBy(\Auth::user()));
        $result = $this->event_repository
            ->with(['place', 'invitations'])->orderBy('end_date')->all();

        $this->event_repository->resetCriteria();

        return $result;
    }

    public function joinedEvents()
    {
    	$this->event_repository->addCriteria(new NotHappenedYet);
        $this->event_repository->addCriteria(new IsJoinedBy(\Auth::user()));
        $result = $this->event_repository
            ->with(['place', 'owner', 'invitations'])->orderBy('end_date')->all();

        $this->event_repository->resetCriteria();

        return $result;
    }

    public function withInvitationsEvents()
    {
    	$this->event_repository->addCriteria(new AllowRegisterYet);
        $this->event_repository->addCriteria(new HasUnconfirmedInvitationFor(\Auth::user()));
        $result = $this->event_repository
            ->with(['place', 'owner', 'invitations'])->orderBy('end_date')->all();

        $this->event_repository->resetCriteria();

        return $result;
    }
}