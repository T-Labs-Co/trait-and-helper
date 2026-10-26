<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Model;

use Illuminate\Database\Eloquent\Model;
use TLabsCo\TraitAndHelper\Exceptions\ReadOnlyException;

trait ReadOnlyTrait
{
    private bool $readonly = true;

    public static function bootReadOnlyTrait(): void
    {
        static::saving(function (Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('save', $model);
            }
        });

        static::updating(function (Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('update', $model);
            }
        });

        static::deleting(function (Model $model) {
            if ($model->isReadOnly()) {
                throw new ReadOnlyException('delete', $model);
            }
        });
    }

    public function isReadOnly(): bool
    {
        return $this->readonly;
    }

    public function enableReadOnly(): static
    {
        $this->readonly = true;

        return $this;
    }

    public function disableReadOnly(): static
    {
        $this->readonly = false;

        return $this;
    }
}
