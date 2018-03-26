<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnonymizationRequest;
use App\Http\Requests\ProfileRequest;
use App\Services\Profile\ProfileAnonymizerService;
use App\Services\Profile\ProfileUpdaterService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	private $profile_updater, $profile_anonymizer;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProfileUpdaterService $profile_updater, ProfileAnonymizerService $profile_anonymizer)
    {
    	$this->profile_updater = $profile_updater;
    	$this->profile_anonymizer = $profile_anonymizer;
    }

    public function profile()
    {
    	$user = \Auth::user();

    	return view('profile.index', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
    	try {
            $this->profile_updater->make(\Auth::user()->id, $request);

            \Alert::success('Profile was updated!');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            \Alert::error('Whops! Something went wrong!');
        }

        return redirect()->route('profile.index');
    }

    public function destroy(AnonymizationRequest $request)
    {
    	try {
            $this->profile_anonymizer->make(\Auth::user()->id, $request);

            return redirect()->route('home');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            \Alert::error('Whops! Something went wrong!');

            return redirect()->back();
        }
    }
}
