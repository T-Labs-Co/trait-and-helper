<?php

/*
 * This file is a part of package t-co-labs/trait-and-helper
 *
 * (c) T.Labs & Co.
 * Contact for Work: T. <hongty.huynh@gmail.com>
 *
 * We're PHP and Laravel whizzes, and we'd love to work with you! We can:
 *  - Design the perfect fit solution for your app.
 *  - Make your code cleaner and faster.
 *  - Refactoring and Optimize performance.
 *  - Ensure Laravel best practices are followed.
 *  - Provide expert Laravel support.
 *  - Review code and Quality Assurance.
 *  - Offer team and project leadership.
 *  - Delivery Manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TLabsCo\TraitAndHelper\Misc;

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
        return camel2dashed($classNameOnly, '_');
    }
}
