<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Support;

use Illuminate\Support\Str;

final class ClassHelper
{
    public static function classNameOnly(object|string $obj): string
    {
        $class = is_object($obj) ? get_class($obj) : $obj;

        // get only class name without namespace
        // from 'App\Enums\StatusEnum' to 'StatusEnum'
        $classNameOnly = Str::afterLast($class, '\\');

        // convert camel to dashed or snake case
        // from 'App\Enums\StatusEnum' to 'status_enum'
        return camel2dashed($classNameOnly, '_');
    }

    public static function hasUseTrait(string $trait, object|string $instance): bool
    {
        return in_array($trait, class_uses_recursive($instance));
    }
}
