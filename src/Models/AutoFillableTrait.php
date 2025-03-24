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

namespace TLabsCo\TraitAndHelper\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

trait AutoFillableTrait
{
    private $disableAutoFillable = false;

    /**
     * @return array
     */
    protected function ignoreAutoFillableFor()
    {
        return [];
    }

    public function disableAutoFillable()
    {
        $this->disableAutoFillable = true;

        return $this;
    }

    public function enableAutoFillable()
    {
        $this->disableAutoFillable = false;

        return $this;
    }

    public static function bootAutoFillableTrait() {}

    public function initializeAutoFillableTrait()
    {
        if (! $this->disableAutoFillable) {
            $this->mergeFillable($this->getModelAutoFillable());
        }
    }

    public function saveWithAutoFillable()
    {
        $data = request()->only($this->getModelAutoFillable());
        $this->fill($data)->save();

        return $this;
    }

    protected function getIgnoreAutoFillableFor()
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

    protected function getSoftDeletedAtColumn()
    {
        return defined('static::DELETED_AT') ? static::DELETED_AT : 'deleted_at';
    }

    protected function getModelTableConnection()
    {
        return $this->getConnectionName();
    }

    protected function getModelTableName()
    {
        return $this->getTable();
    }

    protected function getModelTableColumns()
    {
        $table = $this->getModelTableName();

        $columns = Schema::connection($this->getModelTableConnection())
            ->getColumnListing($table);

        return $columns;
    }

    protected function getModelAutoFillable()
    {
        return array_diff($this->getModelTableColumns(), $this->getIgnoreAutoFillableFor());
    }
}
