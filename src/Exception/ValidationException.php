<?php

/**
 * ValidationException
 *
 * Custom exception thrown when input validation fails.
 *
 * @author Your Full Name
 * @since 2026-05-09
 */

declare(strict_types=1);

namespace App\Exception;

use InvalidArgumentException;
use Throwable;


class ValidationException extends InvalidArgumentException
{

    /**
     * ValidationException constructor
     *
     * Initializes a validation error with optional message
     *
     *
     * @param string $message Error message describing validation failure
     * @param int $code Optional error code
     * @param Throwable or null $previous Previous exception for chaining
     */

    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
