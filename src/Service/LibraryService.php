<?php

declare(strict_types=1);

namespace App\Library\Service;

use DateTime;

class LibraryService
{
    private float $dailyFineRate = 5.0;

    public function calculateOverdueFine(DateTime $dueDate): float
    {
        $today = new DateTime();
        $interval = $today->diff($dueDate);


        $daysOverdue = (int) $interval->format('%r%a');


        return $today > $dueDate ? abs($daysOverdue) * $this->dailyFineRate : 0.0;
    }
}
