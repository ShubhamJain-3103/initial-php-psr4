<?php

namespace App\Database;

class UserData
{
    private $pdo;
    private $tablename = 'users';

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM {$this->getTableName()}";
        $list = [];
        /*
         *  [
         *      0 => ['user_id','name','email_id','password']
         * ]
         */
        try {
            $stmt = $this->pdo->query($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }

            foreach ($list as $key => $value) {
                echo '<br>'.$key.' '.$value['user_id'].' '.$value['email_id'].' '.$value['name'].' '.$value['password'].'<br>';
            }

            echo 'Select success';

            return $list;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getAllEmailId()
    {
        $sql = "SELECT email_id FROM {$this->getTableName()}";
        $list = [];
        /*
         *  [
         *      0 => ['email_id']
         * ]
         */
        try {
            $stmt = $this->pdo->query($sql);
            $stmt->execute();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }
            foreach ($list as $key => $value) {
                echo '<br>'.$key.' '.$value['email_id'].'<br>';
            }
            echo 'Get emails success';

            return $list;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function getPassword($email_id)
    {
        $sql = "SELECT password FROM {$this->getTableName()} 
            WHERE email_id = :email_id";
        $list = [];
        /*
         *  [
         *      0 => ['password']
         * ]
         */
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email_id', $email_id);
            $stmt->execute();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $list[] = $row;
            }
            foreach ($list as $key => $value) {
                echo '<br>'.$key.' '.$value['password'].'<br>';
            }
            echo 'Get password success';

            return $list;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->getTableName()}(
            user_id serial PRIMARY KEY, 
            name varchar(50) UNIQUE NOT NULL, 
            email_id varchar(255) UNIQUE NOT NULL, 
            password varchar(50) NOT NULL
        )";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $this;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function loadSampleData()
    {
        $sample_data = [
            ['name' => 'shubham', 'email_id' => 'shubham@gmail.com', 'password' => 'jain1234'],
            ['name' => 'aman', 'email_id' => 'aman@gmail.com', 'password' => 'aman1234'],
            ['name' => 'jatin', 'email_id' => 'jatin@gmail.com', 'password' => 'jatin1234'],
            ['name' => 'anwar', 'email_id' => 'anwar@gmail.com', 'password' => 'anwar1234'],
            ['name' => 'ajay', 'email_id' => 'ajay@gmail.com', 'password' => 'ajay1234'],
        ];
        $sql = "INSERT INTO {$this->getTableName()}(name,email_id,password) 
            VALUES (:name,:email_id,:password)";
        $idList = [];

        try {
            $stmt = $this->pdo->prepare($sql);

            foreach ($sample_data as $array) {
                $stmt->bindValue(
                    ':name',
                    $array['name']
                );
                $stmt->bindValue(
                    ':email_id',
                    $array['email_id'],
                );
                $stmt->bindValue(
                    ':password',
                    $array['password']
                );
                $stmt->execute();
                $idList[] = $this->pdo->lastInsertId("{$this->getTableName()}_user_id_seq");
            }
            var_dump($idList);
        } catch (\Throwable $th) {
            echo $th->getMessage().'<br>';
            if (23505 == $th->getCode()) {
                echo 'User Already exists';

                return;

                exit;
            }
        }
    }

    public function createUser($name, $email_id, $password)
    {
        $sql = "INSERT INTO {$this->getTableName()}(name,email_id,password) 
            VALUES (:name,:email_id,:password)";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(
                ':name',
                $name
            );
            $stmt->bindValue(
                ':email_id',
                $email_id
            );
            $stmt->bindValue(
                ':password',
                $password
            );
            $stmt->execute();
            echo 'Insert Success';
            echo 'User is created wit id:'." {$this->pdo->lastInsertId("{$this->getTableName()}_user_id_seq")}";
        } catch (\Throwable $th) {
            echo $th->getMessage();
            if (23505 == $th->getCode()) {
                echo 'User Already Exists';

                return;

                exit;
            }
        }
    }

    // Todo
    public function updateUser()
    {
    }

    // Todo
    public function deleteUser($email_id)
    {
        $sql = "DELETE FROM {$this->getTableName()} WHERE email_id = :email_id";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email_id', $email_id);
            $stmt->execute();
            echo "{$email_id} had been deleted";
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    private function getTableName()
    {
        return $this->tablename;
    }
}