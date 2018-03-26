<?php 

namespace App\Services\Profile;

use App\Http\Requests\EventRequest;
use App\Http\Requests\ProfileRequest;
use App\Repositories\Interfaces\UserRepository;
use Carbon\Carbon;

class ProfileUpdaterService
{
	private $user_repository;

	function __construct(
        UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function make($id, ProfileRequest $request)
    {
        $user = $request->all();

        $data = [
            'nick' => $user['nick'],
            'email' => $user['email'],
            'gender' => $user['gender'],
            'birthdate' => Carbon::createFromFormat('d.m.Y', $user['birthdate']),
        ];

        if(!empty($user['password']))
            $data['password'] = bcrypt($user['password']);

        return $this->user_repository->update($id, $data);
    }
}