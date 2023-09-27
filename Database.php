<?php

class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('sqlite:database.sqlite');
    }

    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
