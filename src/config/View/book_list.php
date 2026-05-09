<?php

/**
 * Book List View
 *
 * Displays all books in the library in a table format.
 *
 * @author William Joseph Imperial
 * @since 2026-05-09
 */

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
