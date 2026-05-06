<?php

declare(strict_types=1);

namespace App\Library\Repository;

use PDO;
use PDOException;
use RuntimeException;
use Exception;

class DatabaseConnection
{
    private ?PDO $conn = null;
    private array $config;
    private static ?DatabaseConnection $instance = null;
    private function __construct()
    {
        $this->loadConfig();
        $this->connect();
    }


    private function __clone() {}


    public function __wakeup()
    {
        throw new RuntimeException("Cannot unserialize singleton");
    }


    private function loadConfig(): void
    {
        $this->config = [
            'host' => 'localhost',
            'port' => '3306',
            'name' => 'library_db',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'driver' => 'mysql'
        ];
    }


    private function connect(): void
    {
        try {
            $dsn = sprintf(
                "%s:host=%s;port=%s;dbname=%s;charset=%s",
                $this->config['driver'],
                $this->config['host'],
                $this->config['port'],
                $this->config['name'],
                $this->config['charset']
            );

            $this->conn = new PDO(
                $dsn,
                $this->config['user'],
                $this->config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
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
        return $this->conn;
    }
}
