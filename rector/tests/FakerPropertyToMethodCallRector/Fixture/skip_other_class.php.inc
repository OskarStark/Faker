<?php

class SomeOtherClass
{
    public string $name;
    public string $email;
}

$other = new SomeOtherClass();

// Should not change - not a Faker\Generator instance
$name = $other->name;
$email = $other->email;
