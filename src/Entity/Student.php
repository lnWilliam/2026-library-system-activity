<?php

declare(strict_types=1);

namespace App\Entity;


class Student
{
    private ?int $studentId;
    private string $name;

    public function __construct(?int $studentId, string $name)
    {
        $this->studentId = $studentId;
        $this->name = $name;
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
