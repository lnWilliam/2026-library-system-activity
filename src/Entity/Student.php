<?php

/**
 * Student Entity
 *
 * Represents a student who can borrow books.
 *
 * @author William Joseph Imperial
 * @since 2026-05-09
 */

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
