<?php

require_once('Database.php');

class User
{
    private $data;
    private $db;

    public function __construct($data)
    {
        $this->data = $data;
        $this->db = new Database();
    }

    public function register()
    {
        $hashedPassword = password_hash($this->data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $this->db->query($sql, [$this->data['username'], $this->data['email'], $hashedPassword]);
    }
}
