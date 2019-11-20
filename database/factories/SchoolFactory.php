<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\School;
use Faker\Generator as Faker;

$factory->define(School::class, function (Faker $faker) {
	$regency = ['Sumedang', 'Bandung', 'Subang', 'Indramayu', 'Purwakarta', 'Garut', 'Tasik', 'Bogor', 'Bekasi', 'Karawang', 'Majalengka'];
    return [
        'type' => $faker->randomElement(['SMPN', 'SMKN', 'MTS', 'MA']),
        'name' => $faker->numberBetween(1, 99) . ' ' . $faker->randomElement($regency),
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail, 
    ];
});
