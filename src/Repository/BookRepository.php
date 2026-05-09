<?php
declare(strict_types=1);

namespace App\Repository;

use App\Config\DatabaseConfig;
use App\Entity\Book;
use PDO;

/**
 * Book Repository
 *
 * @author Your Name
 * @since 2026-05-09
 */
class BookRepository
{
    private PDO $connection;

    public function __construct(DatabaseConfig $database)
    {
        $this->connection = $database->getConnection();
    }

    public function addBook(Book $book): int
    {
        $sql = "INSERT INTO books(title, author, year, genre) 
                VALUES(:title, :author, :year, :genre)";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'title'  => $book->getTitle(),
            'author' => $book->getAuthor(),
            'year'   => $book->getYear(),
            'genre'  => $book->getGenre()
        ]);

        return (int) $this->connection->lastInsertId();
    }

    public function listBooks(): array
    {
        $sql = "SELECT * FROM books ORDER BY book_id DESC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}