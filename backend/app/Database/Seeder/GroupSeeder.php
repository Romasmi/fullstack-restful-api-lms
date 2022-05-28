<?php

namespace App\Database\Seeder;

use App\Model\Group;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'Default group',
            'First month group',
            'Beginners group'
        ];

        $group = new Group();
        foreach ($groups as $name)
        {
            $group->addGroup($name);
        }
    }
}
