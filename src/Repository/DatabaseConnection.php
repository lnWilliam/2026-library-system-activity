<?php

declare(strict_types=1);

namespace App\Library\Repository;

use App\Library\Config\DatabaseConfig;
use PDO;
use PDOException;
use RuntimeException;

class DatabaseConnection
{
    private ?PDO $connection = null;

    private static ?DatabaseConnection $instance = null;

    private function __construct()
    {
        $this->connect();
    }

    private function connect(): void
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                DatabaseConfig::HOST,
                DatabaseConfig::DATABASE
            );

            $this->connection = new PDO(
                $dsn,
                DatabaseConfig::USERNAME,
                DatabaseConfig::PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Database connection failed: ' .
                $exception->getMessage()
            );
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
        if ($this->connection === null) {
            throw new RuntimeException(
                'Database connection unavailable.'
            );
        }

        return $this->connection;
    }
}