<?php 

namespace App\Services\Profile;

use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileAnonymizerService
{
	private $user_repository;

	function __construct(
        UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function make($id, Request $request)
    {
        $user = $this->user_repository->find($id);

        $this->user_repository->update($id, [
            'nick' => bcrypt($user->nick),
            'email' => bcrypt($user->email),
            'gender' => 'X',
            'birthdate' => Carbon::create(1920,1,1,0,0,0),
        ]);

        return $this->user_repository->delete($id);
    }
}