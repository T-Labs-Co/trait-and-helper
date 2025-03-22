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
namespace TLabsCo\TraitAndHelper\Exceptions;

class ReadOnlyException extends \RuntimeException
{
    public function __construct($action, $model, $code = 0, Throwable $previous = null)
    {
        $message = "Can not $action the read-only model " . class_name_only($model);

        parent::__construct($message, $code, $previous);
    }
}
