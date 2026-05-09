<?php

/**
 * DatabaseException
 *
 * Custom exception for database-related errors.
 *
 * @author William Joseph Imperial
 * @since 2026-05-09
 */

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;


class DatabaseException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
