<?php

namespace App\Database;

class ShowBlogs
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
}