<?php

declare(strict_types=1);

use Carbon\Carbon;

if (! function_exists('isValidDomain')) {
    function isValidDomain(string $domain): bool
    {
        if (preg_match('/^(https?:\/\/|www\.)/i', $domain)) {
            return false;
        }

        return preg_match('/^([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/', $domain) === 1;
    }
}

if (! function_exists('calculatePercentage')) {
    function calculatePercentage(int|float $total, int|float $compareTo, int $decimals = 0, bool $invert = false): int|float
    {
        if ($total === 0) {
            return 0;
        }

        $percentage = ($compareTo / $total) * 100;

        if ($invert) {
            $percentage = 100 - $percentage;
        }

        return round($percentage, $decimals);
    }
}

if (! function_exists('isDateInPeriod')) {
    /**
     * Check if a date is within a given period (Y-m)
     */
    function isDateInPeriod(string $date, string $period): bool
    {
        $carbonDate = Carbon::parse($date);
        $periodDate = Carbon::make($period);

        return $carbonDate->year == $periodDate->year &&
            $carbonDate->month == $periodDate->month;
    }
}
