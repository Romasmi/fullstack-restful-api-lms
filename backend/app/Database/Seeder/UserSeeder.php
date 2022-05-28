<?php

namespace App\Database\Seeder;

use App\Model\User;

class UserSeeder extends Seeder
{
    private int $usersCountToSeed = 100;

    public function run(): array
    {
        $user = new User();
        $data = [];

        for ($i = 0; $i < $this->usersCountToSeed; ++$i) {
            $login = $this::generateLogin();
            $password = $this::generatePassword();
            $user->addUser($login, $password);

            $data[] = [
                'login' => $login,
                'password' => $password
            ];
        }

        return $data;
    }
}
