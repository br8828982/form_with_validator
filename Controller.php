<?php

require_once('Validator.php');
require_once('User.php');

class Controller
{
    private $validator;
    private $user;

    public function __construct($data)
    {
        $this->validator = new Validator($data);
        $this->user = new User($data);
    }
  
    public function handleForm()
    {
        $rules = [
            'username' => 'required|min:6|unique',
            'email' => 'required|email|unique',
            'password' => 'required|min:8',
        ];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->validator->validate($rules);


            if ($this->validator->passes()) {
                $this->user->register();
                echo "User registration successful!";
            }
        }
    }

    public function getValidator()
    {
        return $this->validator;
    }
}
