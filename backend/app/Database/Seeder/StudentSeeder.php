<?php

namespace App\Database\Seeder;

use App\Model\Student;
use App\Model\Group;

class StudentSeeder extends Seeder
{
    private int $studentsCountToSeed = 100;

    public function run(): void
    {
        $student = new Student();

        $groups = (new Group())->getAll();

        for ($i = 0; $i < $this->studentsCountToSeed; ++$i) {
            $login = $this::generateLogin();
            $firstName = $this::generateLogin();
            $lastName = $this::generateLogin();
            $groupId = $groups[array_rand($groups, 1)]['id'];
            $checked = rand(0, 1);
            $student->addStudent($login, $firstName, $lastName, $groupId, $checked);
        }
    }
}
