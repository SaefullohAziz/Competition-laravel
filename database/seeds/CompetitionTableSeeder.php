<?php

use Illuminate\Database\Seeder;
use App\Competition;

class CompetitionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Competition::create([
        	'name' => 'Temu Aksi dan Prestasi V',
        	'alias' => 'Musisi V',
        	'theme' => 'Menjejak langkah meraih prestasi!',
        	'date' => '2017-10-12'
        ]);

        Competition::create([
        	'name' => 'Temu Aksi dan Prestasi VI',
        	'alias' => 'Musisi VI',
        	'theme' => 'Menjejak langkah meraih prestasi!',
        	'date' => '2018-09-21'
        ]);
    }
}
