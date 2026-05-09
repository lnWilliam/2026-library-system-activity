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

if (isset($_POST['BookList'])) {
    header('Location: ../src/config/View/Book_list.php');
    exit();
}
if (isset($_POST['borrow_book'])) {
    header('Location: ../src/config/View/Borrow_form.php');
    exit();
}
if (isset($_POST['report_view'])) {
    header('Location: ../src/config/View/Report_view.php');
    exit();
}

if (isset($_POST['addbook'])) {
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
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2026 Library System</title>
    <style>
        body { font-family: Arial; text-align: center; margin-top: 50px; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>2026 Library System</h1>

    <?php if ($message): ?>
        <p class="<?= $messageType ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <h3>Add New Book</h3>
        Title: <input type="text" name="book_title" required><br><br>
        Author: <input type="text" name="book_author" required><br><br>
        Genre: <input type="text" name="book_genre" required><br><br>
        Year: <input type="number" name="book_year" required><br><br>
        <button type="submit" name="addbook">Add Book</button>
    </form>

    <br><br>
    <form method="POST">
        <button type="submit" name="BookList">View Book List</button>
        <button type="submit" name="borrow_book">Borrow Book</button>
        <button type="submit" name="report_view">Library Report</button>
    </form>
</body>
</html>