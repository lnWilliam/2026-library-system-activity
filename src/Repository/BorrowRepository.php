<?php
declare(strict_types=1);

namespace App\Repository;

use App\Config\DatabaseConfig;
use App\Config\LibraryConfig;
use PDO;

class BorrowRepository
{
    private PDO $connection;

    public function __construct(DatabaseConfig $database)
    {
        $this->connection = $database->getConnection();
    }

    public function borrowBook(int $studentId, int $bookId, int $days): int
    {
        $dueDate = date('Y-m-d', strtotime('+' . $days . ' days'));

        $sql = "INSERT INTO borrow_records 
                (student_id, book_id, borrow_date, due_date, status) 
                VALUES (:student_id, :book_id, :borrow_date, :due_date, :status)";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'student_id'  => $studentId,
            'book_id'     => $bookId,
            'borrow_date' => date('Y-m-d'),
            'due_date'    => $dueDate,
            'status'      => LibraryConfig::STATUS_BORROWED
        ]);

        return (int) $this->connection->lastInsertId();
    }
}