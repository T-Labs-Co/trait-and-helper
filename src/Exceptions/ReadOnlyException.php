<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Exceptions;

class ReadOnlyException extends \RuntimeException
{
    public function __construct(string $action, object|string $model, int $code = 0, ?\Throwable $previous = null)
    {
        $message = "Can not {$action} the read-only model ".class_name_only($model);

        parent::__construct($message, $code, $previous);
    }
}
