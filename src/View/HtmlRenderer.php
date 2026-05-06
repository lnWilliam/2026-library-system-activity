<?php

declare(strict_types=1);

namespace App\Library\View;

class HtmlRenderer
{
    public function listBooks(array $books): void
    {
        echo "<table border='1'><tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Genre</th></tr>";
        
        foreach ($books as $row) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars((string)$row['book_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['author']) . "</td>";
            echo "<td>" . htmlspecialchars((string)$row['year']) . "</td>";
            echo "<td>" . htmlspecialchars($row['genre']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }

    public function generateReport(array $data): void
    {
        echo "<h2>Library Report</h2>";
        echo "<p>Total Books: " . $data['totalBooks'] . "</p>";
        echo "<p>Borrowed: " . $data['totalBorrowed'] . "</p>";
        echo "<p>Returned: " . $data['totalReturned'] . "</p>";
        echo "<p>Total Fines Collected: $" . $data['totalFines'] . "</p>";
    }
}
