<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

trait AutoFillableTrait
{
    private bool $disableAutoFillable = false;

    /**
     * @return array<string>
     */
    protected function ignoreAutoFillableFor(): array
    {
        return [];
    }

    public function disableAutoFillable(): static
    {
        $this->disableAutoFillable = true;

        return $this;
    }

    public function enableAutoFillable(): static
    {
        $this->disableAutoFillable = false;

        return $this;
    }

    public static function bootAutoFillableTrait(): void {}

    public function initializeAutoFillableTrait(): void
    {
        if (! $this->disableAutoFillable) {
            $this->mergeFillable($this->getModelAutoFillable());
        }
    }

    public function saveWithAutoFillable(): static
    {
        $data = request()->only($this->getModelAutoFillable());
        $this->fill($data)->save();

        return $this;
    }

    /**
     * @return array<string>
     */
    protected function getIgnoreAutoFillableFor(): array
    {
        $ignores = [
            $this->getKeyName(),
            self::CREATED_AT,
            self::UPDATED_AT,
        ];

        if (has_use(SoftDeletes::class, $this)) {
            $ignores = array_merge($ignores, [$this->getSoftDeletedAtColumn()]);
        }

        $ignores = array_merge($ignores, $this->getGuarded());

        if (! empty($this->ignoreAutoFillableFor())) {
            $ignores = array_merge($ignores, $this->ignoreAutoFillableFor());
        }

        return array_values(array_unique($ignores));
    }

    protected function getSoftDeletedAtColumn(): string
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    protected function getModelTableConnection(): ?string
    {
        return $this->getConnectionName();
    }

    protected function getModelTableName(): string
    {
        return $this->getTable();
    }

    /**
     * @return array<string>
     */
    protected function getModelTableColumns(): array
    {
        $table = $this->getModelTableName();

        $columns = Schema::connection($this->getModelTableConnection())
            ->getColumnListing($table);

        return $columns;
    }

    /**
     * @return array<string>
     */
    protected function getModelAutoFillable(): array
    {
        return array_diff($this->getModelTableColumns(), $this->getIgnoreAutoFillableFor());
    }
}
