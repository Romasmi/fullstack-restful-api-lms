<?php

namespace App\Model;

class Group extends \App\Database\Database
{
    private $table = 'group';

    public function addGroup($name): void
    {
        $this->query("
            INSERT IGNORE INTO `{$this->table}` (name)    
            VALUES ('{$name}')
        ");
    }

    public function getAll(): array
    {
        return $this->select("
            SELECT * 
            FROM `{$this->table}`");
    }
}