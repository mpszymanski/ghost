<?php

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();
        factory(App\Event::class, 5000)->create()->each(function ($event) use ($users) {
            $event->place()->save(factory(App\Place::class)->make());
            
            $group = $users->random(rand(0, 5));
            foreach ($group as $user) {
                $invitation = new App\Invitation;
                $invitation->is_confirmed = rand(0, 1);
                $invitation->user_id = $user->id;
                $invitation->event_id = $event->id;
                $invitation->save();
            }
        });
    }
}
