<?php

declare(strict_types=1);

namespace App\Library\Entity;

class BorrowRecord
{
    private int $recordId;
    private int $studentId;
    private int $bookId;
    private string $status;

    public function __construct(int $recordId, int $studentId, int $bookId, string $status)
    {
        $this->recordId = $recordId;
        $this->studentId = $studentId;
        $this->bookId = $bookId;
        $this->status = $status;
    }
}
