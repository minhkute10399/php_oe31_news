<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RequestWriter;
use Faker\Generator as Faker;

$factory->define(RequestWriter::class, function (Faker $faker) {
    return [
        'note' => 'Test Note',
        'user_id' => 5,
    ];
});
