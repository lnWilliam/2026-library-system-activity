<?php

declare(strict_types=1);
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\DatabaseConfig;
use App\Repository\BookRepository;
use App\Entity\Book;
use App\Exception\ValidationException;

$database = new DatabaseConfig();
$bookrepo = new BookRepository($database);

$message = '';
$messageType = '';

if (isset($_POST['BookList']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../src/config/View/Book_list.php');
    exit();
}

if (isset($_POST['borrow_book']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../src/config/View/Borrow_form.php');
    exit();
}

if (isset($_POST['report_view']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Location: ../src/config/View/Report_view.php');
    exit();
}

if (isset($_POST['addbook']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $book = new Book(
            trim($_POST['book_title'] ?? ''),
            trim($_POST['book_author'] ?? ''),
            (int)($_POST['book_year'] ?? 0),
            trim($_POST['book_genre'] ?? '')
        );

        $result = $bookrepo->addBook($book);

        if ($result > 0) {
            $_SESSION['message'] = 'Book added successfully!';
            $_SESSION['messageType'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to add book';
            $_SESSION['messageType'] = 'error';
        }
    } catch (ValidationException $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['messageType'] = 'error';
    } catch (\Exception $e) {
        $_SESSION['message'] = 'An error occurred while adding the book';
        $_SESSION['messageType'] = 'error';
    }

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $messageType = $_SESSION['messageType'];
    unset($_SESSION['message'], $_SESSION['messageType']);
}
