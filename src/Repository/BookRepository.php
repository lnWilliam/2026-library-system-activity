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
