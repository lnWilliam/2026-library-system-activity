<?php

declare(strict_types=1);

namespace App\Library\Repository;

use PDO;

class BookRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::getInstance()->getConnection();
    }

    public function addBook(string $title, string $author, int $year, string $genre): int
    {
        $sql = "INSERT INTO books (title, author, year, genre) VALUES (?, ?, ?, ?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([$title, $author, $year, $genre]);

        return (int) $this->db->lastInsertId();
    }

    public function findById(int $bookId): ?array
    {
        $sql = "SELECT * FROM books WHERE book_id = ?";
        $statement = $this->db->prepare($sql);
        $statement->execute([$bookId]);

        $record = $statement->fetch();
        return $record ?: null;
    }

    public function searchBooks(string $keyword): array
    {
        $sql = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
        $statement = $this->db->prepare($sql);

        $searchTerm = "%$keyword%";
        $statement->execute([$searchTerm, $searchTerm]);

        return $statement->fetchAll();
    }

    public function findAll(): array
    {
        $sql = "SELECT * FROM books";
        $statement = $this->db->query($sql);

        return $statement->fetchAll();
    }
}
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
