<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Config\DatabaseConfig;
use App\Repository\BookRepository;

$database = new DatabaseConfig();
$bookrepo = new BookRepository($database);

$bookList = [];
try {
    $bookList = $bookrepo->listBooks();
} catch (\Exception $e) {
    $bookList = [];
}
?>