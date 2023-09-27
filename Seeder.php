<?php

class Seeder
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function run()
    {
        $this->createTable();

        $this->addUser('john_doe', 'john@example.com', 'password123');
    }

    private function createTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY,
                username TEXT NOT NULL,
                email TEXT NOT NULL,
                password TEXT NOT NULL
            )
        ");
    }

    private function addUser($username, $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
}

$pdo = new PDO('sqlite:database.sqlite');
$seeder = new Seeder($pdo);
$seeder->run();

