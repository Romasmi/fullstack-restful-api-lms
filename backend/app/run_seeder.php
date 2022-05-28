<?php

require 'bootstrap.inc.php';

$userSeeder = new App\Database\Seeder\UserSeeder();
$users = $userSeeder->run();

foreach ($users as $user)
{
    echo "{$user['login']} - {$user['password']}" . PHP_EOL;
}

$groupSeeder = new App\Database\Seeder\GroupSeeder();
$groupSeeder->run();

$studentSeeder = new App\Database\Seeder\StudentSeeder();
$studentSeeder->run();
