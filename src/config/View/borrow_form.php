<?php

declare(strict_types=1);
session_start();
require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Config\DatabaseConfig;
use App\Repository\BorrowRepository;

$database = new DatabaseConfig();
$borrowrepo = new BorrowRepository($database);

$message = '';
$messageType = '';

if (isset($_POST['borrowBook'])) {
    try {
        $studentId = (int) $_POST['student_id'];
        $bookId = (int) $_POST['book_id'];
        $days = (int) $_POST['borrow_days'];

        $result = $borrowrepo->borrowBook($studentId, $bookId, $days);

        if ($result > 0) {
            $_SESSION['message'] = 'Book borrowed successfully!';
            $_SESSION['messageType'] = 'success';
        }
    } catch (\Exception $e) {
        $_SESSION['message'] = 'Failed to borrow book';
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
