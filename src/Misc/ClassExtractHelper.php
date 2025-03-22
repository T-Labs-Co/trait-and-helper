<?php

namespace App\Supports;

use Illuminate\Support\Str;

final class ClassExtractHelper
{
    public static function classNameOnly(object|string $obj)
    {
        $class = $obj;

        if (is_object($obj)) {
            $class = get_class($obj);
        }

        // get only class name without namespace
        // from 'App\Enums\StatusEnum' to 'StatusEnum'
        $classNameOnly = Str::afterLast($class, '\\');

        // convert camel to dashed or snake case
        // from 'App\Enums\StatusEnum' to 'status_enum'
        return self::camel2dashed($classNameOnly, '_');
    }

    /**
     * Convert camelCase to dashed-case
     *
     * @param string $character
     */
    private static function camel2dashed(string $str, $character = '-'): string
    {
        return strtolower(preg_replace('/([^A-Z-])([A-Z])/', "$1{$character}$2", $str));
    }

    /**
     * Convert class name to camelCase
     */
    private static function class2camel(string|object $class): string
    {
        return Str::camel(Str::afterLast(is_object($class) ? get_class($class) : $class, '\\'));
    }
}
