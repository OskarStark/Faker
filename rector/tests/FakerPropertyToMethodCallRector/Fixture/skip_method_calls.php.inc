<?php

use Faker\Generator;

/** @var Generator $faker */
$faker = new Generator();

// Already method calls - should not change
$name = $faker->name();
$email = $faker->email();
$address = $faker->address();
