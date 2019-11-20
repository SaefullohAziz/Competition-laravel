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
        $school_id = School::select('id')->limit(1)->get()[0];
        \App\User::create([
            'username' => 'user',
            'school_id' => $school_id->id,
            'name' => 'User',
            'email' => 'user@competition.org',
            'password' => \Illuminate\Support\Facades\Hash::make('usercompetition'),
        ]);
    }
}
