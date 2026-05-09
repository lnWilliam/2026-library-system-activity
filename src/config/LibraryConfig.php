<?php

declare(strict_types=1);

namespace App\Config;

/**
 * Library Configuration
 *
 * @author William Joseph Imperial
 * @since 2026-05-09
 */
class LibraryConfig
{
    public const STATUS_RETURNED = 'returned';
    public const STATUS_BORROWED = 'borrowed';
    public const DEFAULT_BORROW_DAYS = 14;
    public const DAILY_FINE_RATE = 5.00;
    public const MAX_BORROW_LIMIT = 3;
}
