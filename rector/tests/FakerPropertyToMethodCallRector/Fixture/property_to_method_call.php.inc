<?php

use Faker\Generator;

/** @var Generator $faker */
$faker = new Generator();

$name = $faker->name;
$email = $faker->email;
$address = $faker->address;

?>
-----
<?php

use Faker\Generator;

/** @var Generator $faker */
$faker = new Generator();

$name = $faker->name();
$email = $faker->email();
$address = $faker->address();

?>
