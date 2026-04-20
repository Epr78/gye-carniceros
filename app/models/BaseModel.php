<?php

require_once __DIR__ . '/../core/Database.php';

class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}