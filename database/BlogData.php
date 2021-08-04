<?php

namespace App\Database;

class BlogData
{
    private $pdo;

    private $tablename = 'blog';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createTable()
    {
        $sql = "CREATE TABLE {$this->getTableName()}(
            blog_id SERIAL PRIMARY KEY,
            email_id VARCHAR(50) NOT NULL UNIQUE,
            title TEXT NOT NULL,
            block1 TEXT NOT NULL,
            block2 TEXT NOT NULL,
            date VARCHAR(20) NOT NULL,
            hero_image 
        )";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            echo 'Create Table Success';
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function loadSampleData()
    {
    }

    public function createBlog()
    {
    }

    public function updateBlog()
    {
    }

    public function deleteBlog()
    {
    }

    private function getTableName()
    {
        return $this->tablename;
    }
}