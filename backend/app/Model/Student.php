<?php

namespace App\Model;

class Student extends \App\Database\Database
{
    private $table = 'student';

    public function getStudents(int $offset, int $limit): array
    {
        return $this->select("
            SELECT * 
            FROM `{$this->table}` 
            LIMIT {$offset}, {$limit}");
    }

    public function addStudent($login, $firstName, $lastName, $groupId, $checked): void
    {
        $this->query("
            INSERT INTO `{$this->table}` (login, first_name, last_name, group_id, checked)    
            VALUES ('{$login}', '{$firstName}', '{$lastName}', '{$groupId}', '{$checked}')
        ");
    }

    public function getCount(): int
    {
        return ($this->selectOne("
            SELECT COUNT(*) as `count`
            FROM `{$this->table}`"))['count'];
    }
}