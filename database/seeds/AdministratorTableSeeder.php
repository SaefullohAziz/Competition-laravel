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
        $admin = Administrator::create([
            'username' => 'admin',
            'name' => 'Administrator',
            'email' => 'admin@competition.org',
            'password' => \Illuminate\Support\Facades\Hash::make('admincompetition'),
        ]);
        $admin->assignRole('supersu');
    }
}
