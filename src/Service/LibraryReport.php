<?php

declare(strict_types=1);

namespace App\Library\Service;

class LibraryReport
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getReportData()
    {
        return [
            'totalBooks' => $this->conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'],
            'totalBorrowed' => $this->conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='borrowed'")->fetch_assoc()['c'],
            'totalReturned' => $this->conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='returned'")->fetch_assoc()['c'],
            'totalFines' => $this->conn->query("SELECT SUM(fine_amount) as s FROM borrow_records WHERE fine_amount>0")->fetch_assoc()['s']
        ];
    }
}
