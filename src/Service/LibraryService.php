<?php
declare(strict_types=1);

namespace App\Service;

use App\Config\DatabaseConfig;
use App\Config\LibraryConfig;
use App\Exception\DatabaseException;
use DateTime;
use PDO;

class LibraryService
{
    private PDO $connection;

    public function __construct(DatabaseConfig $database)
    {
        $this->connection = $database->getConnection();
    }

    public static function calculateOverduefine(DateTime $dueDate, float $dailyRate): float
    {
        $today = new DateTime();
        $diff = $dueDate->diff($today);
        $daysOverdue = (int)$diff->format('%r%a');
        return $daysOverdue > 0 ? $daysOverdue * $dailyRate : 0.0;
    }

    public function getOverdueBooks(): array
    {
        try {
            $sql = "SELECT br.*, b.title, s.name 
                    FROM borrow_records br 
                    JOIN books b ON br.book_id = b.book_id 
                    JOIN student s ON br.student_id = s.student_id 
                    WHERE br.due_date < CURDATE() AND br.status = 'borrowed'";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new DatabaseException("Failed to get overdue books: " . $e->getMessage());
        }
    }
}