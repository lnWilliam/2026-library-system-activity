<?php

declare(strict_types=1);

namespace App\Library\Service;

use App\Library\Repository\DatabaseConnection;
use PDO;

class LibraryReport
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function getReportData(): array
    {
        return [
            'totalBooks' => $this->db->query("SELECT COUNT(*) FROM books")->fetchColumn(),
            'totalBorrowed' => $this->db->query("SELECT COUNT(*) FROM borrow_records WHERE status = 'borrowed'")->fetchColumn(),
            'totalReturned' => $this->db->query("SELECT COUNT(*) FROM borrow_records WHERE status = 'returned'")->fetchColumn(),
            'totalFines' => $this->db->query("SELECT SUM(fine_amount) FROM borrow_records WHERE fine_amount > 0")->fetchColumn() ?: 0
        ];
    }
}
