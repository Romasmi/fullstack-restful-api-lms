<?php

namespace App\Database;

use PDO;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $host = DATABASE['host'];
        $port = DATABASE['port'];
        $name = DATABASE['name'];
        $user = DATABASE['user'];
        $password = DATABASE['password'];

        $this->connection = new PDO(
            "mysql:host={$host};port={$port};dbname={$name}",
            $user,
            $password
        );
    }

    public function select(string $query): bool|array
    {
        return ($this->connection->query($query))->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne(string $query): bool|array
    {
        $result = $this->connection->query($query);
        $result = $result->fetchAll();
        return $result ? $result[0] : false;
    }

    public function query(string $query)
    {
        $this->connection->query($query);
    }
}