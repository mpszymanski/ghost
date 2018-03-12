<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
	        'nick' => 'Szyman',
	        'email' => 'szyman@example.com',
	        'password' => bcrypt('secret'), // secret
	        'remember_token' => str_random(10),
	        'birth_date' => Carbon\Carbon::createFromFormat('Y-m-d', '1995-03-04'),
			'gender' => 'M'
		]);

		factory(App\User::class, 50)->create();
    }
}
