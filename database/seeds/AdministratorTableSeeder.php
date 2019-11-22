<?php

use Illuminate\Database\Seeder;
use App\Administrator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(defined('PASSWORD_ARGON2ID')) {
            $hash = password_hash('admincompetition', PASSWORD_ARGON2ID, array('time_cost' => 10, 'memory_cost' => '2048k', 'threads' => 6));
        } else {
            $hash = password_hash('admincompetition', PASSWORD_DEFAULT, array('time_cost' => 10, 'memory_cost' => '2048k', 'threads' => 6));
        }

        $admin = Administrator::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@competition.org',
            'password' => $hash,
        ]);
        $admin->assignRole('supersu');
    }
}
