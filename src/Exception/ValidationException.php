<?php

declare(strict_types=1);

namespace App\Exception;

use InvalidArgumentException;
use Throwable;


/**
 * ValidationException
 *
 * Custom exception used when input validation fails in the library system.
 * This exception is thrown when user-provided data does not meet
 * defined business rules or constraints.
 *
 * Responsibilities:
 * - Handle invalid user inputs
 * - Enforce validation rules across entities and services
 * - Provide clear validation error feedback
 *
 * @author William Joseph Imperial
 * @since 2026-05-08
 */
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
