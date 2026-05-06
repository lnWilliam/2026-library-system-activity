<?php

declare(strict_types=1);

namespace App\Library\Repository;

use PDO;
use PDOException;
use RuntimeException;
use Exception;

class DatabaseConnection
{
    private string $host = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $database = "library_db";
    private ?PDO $connection = null;
    private static ?DatabaseConnection $instance = null;

    private function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            $this->connection = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
