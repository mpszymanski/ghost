<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $owned = function($user, $event) {
            return $event->user_id == $user->id;
        };

        Gate::define('join-event', function($user, $event) {
            return ($event->is_public 
                || $user->invitations->where('event_id', $event->id)->count()) 
                && ! $user->invitations->where('event_id', $event->id)->where('is_confirmed', 1)->count()
                && $event->user_id != $user->id;
        });

        Gate::define('leave-event', function($user, $event) {
            return $user->invitations->where('event_id', $event->id)->where('is_confirmed', 1)->count();
        });

        Gate::define('show-event', function($user, $event) {
            return $event->is_public || $user->invitations->where('event_id', $event->id)->count() || $event->user_id == $user->id;
        });

        Gate::define('edit-event', $owned);

        Gate::define('remove-event', $owned);

        Gate::define('invite-to-event', function($user, $event) {
            return $event->is_public || $user->invitations->where('event_id', $event->id)->count() || $event->user_id == $user->id;
        });
    }
}
