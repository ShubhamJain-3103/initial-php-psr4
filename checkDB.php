<?php

require 'vendor/autoload.php';
use App\Database\Connection as Connection;

try {
    Connection::get()->connect();
    echo 'A connection to the PostgreSQL database sever has been established successfully.';
} catch (\PDOException $error) {
    echo $error->getMessage();
}