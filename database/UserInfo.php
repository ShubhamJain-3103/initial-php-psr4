<?php

namespace App\Database;

class UserInfo
{
    private $pdo;

    private $tablename = 'userinfo';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
    }

    public function loadSampleData()
    {
    }

    public function createUser()
    {
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {
    }

    private function getTableName()
    {
        return $this->tablename;
    }
}