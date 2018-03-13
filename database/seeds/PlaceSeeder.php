<?php

use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Event::class, 50)->create()->each(function ($u) {
            $u->place()->save(factory(App\Place::class)->make());
        });
    }
}
