<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RequestWriter;
use Faker\Generator as Faker;

$factory->define(RequestWriter::class, function (Faker $faker) {
    return [
        'note' => $faker->text,
        'user_id' => 1,
    ];
});
