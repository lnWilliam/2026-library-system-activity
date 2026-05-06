<?php

declare(strict_types=1);

namespace App\Library\Repository;

class BookRepository
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function addBook($t, $a, $y, $g)
    {
        $sql = "INSERT INTO books(title,author,year,genre) VALUES('" . $t . "','" . $a . "'," . $y . ",'" . $g . "')";
        $this->conn->query($sql);
        return $this->conn->insert_id;
    }

    function getBook($id)
    {
        $sql = "SELECT * FROM books WHERE book_id=" . $id;
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    function searchBooks($kw)
    {
        $sql = "SELECT * FROM books WHERE title LIKE '%" . $kw . "%' OR author LIKE '%" . $kw . "%'";
        $result = $this->conn->query($sql);
        $books = array();
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        return $books;
    }

    function listBooksRaw()
    {
        $sql = "SELECT * FROM books";
        return $this->conn->query($sql);
    }
}
