<?php

declare(strict_types=1);

namespace App\Library\Repository;

use PDO;

class BorrowRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }


    public function borrowBook(int $studentId, int $bookId, int $days): bool
    {
        $dueDate = date('Y-m-d', strtotime('+' . $days . ' days'));
        $borrowDate = date('Y-m-d');
        
        $sql = "INSERT INTO borrow_records (student_id, book_id, borrow_date, due_date, status) 
                VALUES (?, ?, ?, ?, 'borrowed')";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$studentId, $bookId, $borrowDate, $dueDate]);
    }


    public function getRecordById(int $recordId): ?array
    {
        $sql = "SELECT * FROM borrow_records WHERE record_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$recordId]);
        
        $result = $stmt->fetch();
        return $result ?: null;
    }


    public function updateReturnStatus(int $recordId, float $fineAmount): bool
    {
        $returnDate = date('Y-m-d');
        $sql = "UPDATE borrow_records 
                SET return_date = ?, fine_amount = ?, status = 'returned' 
                WHERE record_id = ?";
                
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$returnDate, $fineAmount, $recordId]);
    }


    public function getOverdueBooks(): array
    {
        $today = date('Y-m-d');
        $sql = "SELECT br.*, b.title, s.name 
                FROM borrow_records br 
                JOIN books b ON br.book_id = b.book_id 
                JOIN students s ON br.student_id = s.student_id 
                WHERE br.due_date < ? AND br.status = 'borrowed'";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$today]);
        
        return $stmt->fetchAll();
    }
}
