<?php

use Illuminate\Database\Seeder;
use App\School;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(defined('PASSWORD_ARGON2ID')) {
            $hash = password_hash('usercompetition', PASSWORD_ARGON2ID, array('time_cost' => 10, 'memory_cost' => '2048k', 'threads' => 6));
        } else {
            $hash = password_hash('usercompetition', PASSWORD_DEFAULT, array('time_cost' => 10, 'memory_cost' => '2048k', 'threads' => 6));
        }
        $school_id = School::select('id')->limit(1)->get()[0];
        \App\User::create([
            'username' => 'user',
            'school_id' => $school_id->id,
            'name' => 'User',
            'email' => 'user@competition.org',
            'password' => $hash,
        ]);
    }
}
