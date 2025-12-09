<?php

use Faker\Generator;

/** @var Generator $faker */
$faker = new Generator();

// Should not change - 'firstName' is not in the configured list
$firstName = $faker->firstName;
