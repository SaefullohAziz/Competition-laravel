<?php

use Illuminate\Database\Seeder;
use App\Competition;
use App\Contest;

class ContestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Competition::all() as $competition) {
        	$competition->contests()->create([
        		'name' => 'Tandu',
        	]);
        	$competition->contests()->create([
        		'name' => 'PK',
        	]);
        	$competition->contests()->create([
        		'name' => 'PP',
        	]);
        }
    }
}
