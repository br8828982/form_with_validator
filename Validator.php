<?php

require_once('Database.php');

class Validator
{
    private $data;
    private $errors = [];
    private $db;

    public function __construct($data)
    {
        $this->data = $data;
        $this->db = new Database();
    }

    public function validate($rules)
    {
        foreach ($rules as $field => $rulesArray) {
            foreach ($rulesArray as $rule) {
                $this->applyRule($field, $rule);
            }
        }
    }

    private function applyRule($field, $rule)
    {
        $params = [];
        if (strpos($rule, ':') !== false) {
            list($rule, $param) = explode(':', $rule);
            $params = explode(',', $param);
        }

        switch ($rule) {
            case 'required':
                if (!isset($this->data[$field]) || empty($this->data[$field])) {
                    $this->addError($field, "$field is required.");
                }
                break;

            case 'min':
                if (strlen($this->data[$field]) < $params[0]) {
                    $this->addError($field, "$field must be at least {$params[0]} characters.");
                }
                break;

            case 'unique':
                if (!$this->isUnique($field, $this->data[$field])) {
                    $this->addError($field, "$field already exists.");
                }
                break;

            case 'email':
                if (!filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, "$field must be valid.");
                }
                break;

            default:
                break;
        }
    }

    private function addError($field, $message)
    {
        $this->errors[$field][] = $message;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function showError($field)
    {
        $errors = $this->getErrors();
        return array_map('htmlspecialchars', $errors[$field] ?? []);
    }

    public function passes()
    {
        return empty($this->errors);
    }

    private function isUnique($field, $value)
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE $field = ?", [$value]);
        $count = $stmt->fetchColumn();
        return $count === 0;
    }
}
