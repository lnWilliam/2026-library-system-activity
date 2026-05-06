<?php

declare(strict_types=1);

namespace App\Library\View;

class HtmlRenderer
{
    function listBooks($result)
    {
        echo "<table border='1'><tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Genre</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['book_id'] . "</td><td>" . $row['title'] . "</td><td>" . $row['author'] . "</td><td>" . $row['year'] . "</td><td>" . $row['genre'] . "</td></tr>";
        }
        echo "</table>";
    }

    function generateReport($data)
    {
        echo "<h2>Library Report</h2>";
        echo "<p>Total Books: " . $data['totalBooks'] . "</p>";
        echo "<p>Borrowed: " . $data['totalBorrowed'] . "</p>";
        echo "<p>Returned: " . $data['totalReturned'] . "</p>";
        echo "<p>Total Fines Collected: $" . $data['totalFines'] . "</p>";
    }
}
