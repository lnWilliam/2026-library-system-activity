<?php

declare(strict_types=1);

namespace App\Library\Repository;

use PDO;

class BookRepository
{
    private PDO $databaseConnection;

    public function __construct()
    {
        $this->databaseConnection =
            DatabaseConnection::getInstance()
                ->getConnection();
    }

    public function addBook(
        string $title,
        string $author,
        int $year,
        string $genre
    ): int {
        $sql = 'INSERT INTO books (
                    title,
                    author,
                    year,
                    genre
                )
                VALUES (?, ?, ?, ?)';

        $statement =
            $this->databaseConnection->prepare($sql);

        $statement->execute([
            $title,
            $author,
            $year,
            $genre,
        ]);

        return (int) 
            $this->databaseConnection->lastInsertId();
    }

    public function findById(
        int $bookId
    ): ?array {
        $sql = 'SELECT * FROM books
                WHERE book_id = ?';

        $statement =
            $this->databaseConnection->prepare($sql);

        $statement->execute([$bookId]);

        $book = $statement->fetch();

        return $book ?: null;
    }

    public function findAll(): array
    {
        $sql = 'SELECT * FROM books';

        $statement =
            $this->databaseConnection->query($sql);

        return $statement->fetchAll();
    }

    public function searchBooks(
        string $keyword
    ): array {
        $sql = 'SELECT * FROM books
                WHERE title LIKE ?
                OR author LIKE ?';

        $searchKeyword = '%' . $keyword . '%';

        $statement =
            $this->databaseConnection->prepare($sql);

        $statement->execute([
            $searchKeyword,
            $searchKeyword,
        ]);

        return $statement->fetchAll();
    }
}