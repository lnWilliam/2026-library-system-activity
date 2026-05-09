<?php

declare(strict_types=1);
require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Config\DatabaseConfig;
use App\Service\LibraryReport;
use App\Service\LibraryService;
use App\Config\LibraryConfig;
use DateTime;

$database = new DatabaseConfig();
$report = new LibraryReport($database);
$libraryService = new LibraryService($database);

$reports = [];
$overDueBooks = [];

try {
    $reports = $report->generateReport();
    $overDueBooks = $libraryService->getOverdueBooks();
} catch (\Exception $e) {
    $reports = [];
    $overDueBooks = [];
}
