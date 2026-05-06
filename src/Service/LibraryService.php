<?php

declare(strict_types=1);

namespace App\Library\Service;

class LibraryService
{
    public $fine_rate = 5;

    function calculateFine($due_date)
    {
        $due = strtotime($due_date);
        $today = strtotime(date('Y-m-d'));
        $diff = ($today - $due) / (60 * 60 * 24);
        $fine = 0;
        if ($diff > 0) {
            $fine = $diff * $this->fine_rate;
        }
        return $fine;
    }
}
