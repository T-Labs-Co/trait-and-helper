<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Support;

use Carbon\Carbon;

final class DateHelper
{
    public static function parseCarbon(mixed $date): ?Carbon
    {
        try {
            if ($date instanceof Carbon) {
                return $date;
            }

            if ($date && is_string($date)) {
                return Carbon::parse($date);
            }
        } catch (\Throwable $e) {
            return null;
        }

        return null;
    }
}
