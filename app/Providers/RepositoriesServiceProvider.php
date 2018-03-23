<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Interfaces\EventRepository', 
            'App\Repositories\Eloquent\EloquentEventRepository'
        );

        $this->app->bind(
            'App\Repositories\Interfaces\InvitationRepository', 
            'App\Repositories\Eloquent\EloquentInvitationRepository'
        );

        $this->app->bind(
            'App\Repositories\Interfaces\PlaceRepository', 
            'App\Repositories\Eloquent\EloquentPlaceRepository'
        );

        $this->app->bind(
            'App\Repositories\Interfaces\UserRepository', 
            'App\Repositories\Eloquent\EloquentUserRepository'
        );
    }
}
