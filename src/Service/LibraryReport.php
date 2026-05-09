<?php

/**
 * LibraryReport
 *
 * Generates statistical reports (total books, borrowed, fines, etc.).
 *
 * @author William Joseph Imperial
 * @since 2026-05-09
 */

declare(strict_types=1);

namespace App\Service;

use App\Config\DatabaseConfig;
use App\Exception\DatabaseException;
use PDO;

class LibraryReport
{
    private PDO $connection;

    public function __construct(DatabaseConfig $database)
    {
        $this->connection = $database->getConnection();
    }

    public function generateReport(): array
    {
        try {
            $report = [];

            $report['totalBooks'] = $this->connection->query('SELECT COUNT(*) FROM books')->fetchColumn();
            $report['totalBorrowed'] = $this->connection->query("SELECT COUNT(*) FROM borrow_records WHERE status='borrowed'")->fetchColumn();
            $report['totalReturned'] = $this->connection->query("SELECT COUNT(*) FROM borrow_records WHERE status='returned'")->fetchColumn();
            $report['totalFines'] = $this->connection->query("SELECT COALESCE(SUM(fine_amount), 0) FROM borrow_records")->fetchColumn();

            return $report;
        } catch (\PDOException $e) {
            throw new DatabaseException("Failed to generate report: " . $e->getMessage());
        }
    }
}
