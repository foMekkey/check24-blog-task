<?php

declare(strict_types=1);

namespace App\Database;

use App\Database\Interfaces\DBInterface;
use PDOException;
use PDO;

class DB implements DBInterface
{
    private $connection;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        $this->host = env('DB_HOST');
        $this->user = env('DB_USERNAME');
        $this->password = env('DB_PASSWORD');
        $this->database = env('DB_DATABASE');
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function connect()
    {
        if (!$this->connection instanceof PDO) {
            throw new PDOException("Couldn't Reach Database Connection!");
        }
        return $this->connection;
    }
}