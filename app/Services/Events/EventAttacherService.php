<?php 

namespace App\Services\Events;

use App\Repositories\Eloquent\Criteria\AllowRegisterYet;
use App\Repositories\Eloquent\Criteria\HasUnconfirmedInvitationFor;
use App\Repositories\Eloquent\Criteria\IsJoinedBy;
use App\Repositories\Eloquent\Criteria\IsOwnedBy;
use App\Repositories\Eloquent\Criteria\NotHappenedYet;
use App\Repositories\Interfaces\EventRepository;
use App\Repositories\Interfaces\InvitationRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EventAttacherService
{
	private $event_repository, $invitation_repository;

	function __construct(
        EventRepository $event_repository, 
        InvitationRepository $invitation_repository)
    {
        $this->event_repository = $event_repository;
        $this->invitation_repository = $invitation_repository;
    }

    public function join(\App\User $user, \App\Event $event)
    {
    	return $this->invitation_repository->updateOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id
        ], [
            'is_confirmed' => true
        ]);
    }

    public function invite(\App\User $user, \App\Event $event)
    {
        return $this->invitation_repository->updateOrCreate([
            'event_id' => $event->id,
            'user_id' => $user->id
        ], [
            'is_confirmed' => false,
            'invited_by' => \Auth::user()->id
        ]);
    }

    public function leave(\App\User $user, \App\Event $event)
    {
    	$invitation = $this->invitation_repository->findWhere([
            'event_id' => $event->id,
            'user_id' => $user->id
        ])->first();

        if(empty($invitation))
            throw new NotFoundHttpException;

        return $this->invitation_repository->delete($invitation->id);
    }
}