<?php

/*
 * This file is a part of package t-co-labs/trait-and-helper.
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

use Illuminate\Support\Str;
use TLabsCo\TraitAndHelper\Misc\ClassExtractHelper;

if (! function_exists('camel2dashed')) {
    /**
     * Convert camelCase to dashed-case
     *
     * @param  string  $character
     */
    function camel2dashed(string $str, $character = '-'): string
    {
        return strtolower(preg_replace('/([^A-Z-])([A-Z])/', "$1{$character}$2", $str));
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
        return ClassExtractHelper::classNameOnly($class);
    }
}
