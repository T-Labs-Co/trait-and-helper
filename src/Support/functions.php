<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Str;
use TLabsCo\TraitAndHelper\Support\ClassHelper;
use TLabsCo\TraitAndHelper\Support\DateHelper;

if (! function_exists('camel2dashed')) {
    /**
     * Convert camelCase to dashed-case
     */
    function camel2dashed(string $str, string $character = '-'): string
    {
        return strtolower(preg_replace('/([^A-Z-])([A-Z])/', "$1{$character}$2", $str) ?? $str);
    }
}

if (! function_exists('class2camel')) {
    /**
     * Convert class name to camelCase
     */
    function class2camel(string|object $class): string
    {
        return Str::camel(Str::afterLast(is_object($class) ? get_class($class) : $class, '\\'));
    }
}

if (! function_exists('class_name_only')) {
    /**
     * Convert class/object to class name
     */
    function class_name_only(string|object $class): string
    {
        return ClassHelper::classNameOnly($class);
    }
}

if (! function_exists('parse_date_carbon')) {
    /**
     * Parse a date string to Carbon instance
     */
    function parse_date_carbon(mixed $date): ?Carbon
    {
        return DateHelper::parseCarbon($date);
    }
}

if (! function_exists('has_use')) {
    /**
     * Check if a class uses a trait
     */
    function has_use(string $trait, mixed $instance): bool
    {
        return ClassHelper::hasUseTrait($trait, $instance);
    }
}
