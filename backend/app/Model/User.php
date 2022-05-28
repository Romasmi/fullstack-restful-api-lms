<?php

namespace App\Model;

class User extends \App\Database\Database
{
    private $table = 'user';

    public function isValidUser(string $login, string $password): bool
    {
        $salt = $this->selectOne("
            SELECT salt 
            FROM {$this->table} 
            WHERE login = '{$login}' 
            LIMIT 1;
        ")['salt'] ?? false;

        $isValid = false;
        if ($salt) {
            $hash = $this->generateHash($password, $salt);

            $result = $this->selectOne("
                SELECT id  
                FROM {$this->table} 
                WHERE login = '{$login}' AND hash = '{$hash}' 
                LIMIT 1;
            ");
            $isValid = isset($result['id']);
        }

        return $isValid;
    }

    public function getByField(string $field, string $token)
    {
        return $this->selectOne("
            SELECT * 
            FROM {$this->table} 
            WHERE {$field} = '{$token}' 
            LIMIT 1;
        ");
    }

    public function clearToken(int $id): void
    {
        $this->query("
            UPDATE {$this->table} 
                SET token = ''
            WHERE id = '{$id}' 
        ");
    }

    public function setToken(string $login, string $token) :void
    {
        $this->query("
            UPDATE {$this->table} 
                SET token = '{$token}'
            WHERE login = '{$login}' 
        ");
    }

    private function generateHash(string $password, string $salt): string
    {
        return md5($salt . $password);
    }

    public function addUser($login, $password): void
    {
        $salt = uniqid(mt_rand(), true);
        $hash = $this->generateHash($password, $salt);

        $this->query("
            INSERT INTO user (login, hash, salt)    
            VALUES ('{$login}', '{$hash}', '{$salt}')
        ");
    }
}