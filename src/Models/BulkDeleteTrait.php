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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait BulkDeleteTrait
{
    /**
     * @param  Builder|\Illuminate\Database\Query\Builder|Model|Collection|\Illuminate\Database\Eloquent\Collection  $builder
     * @param  bool  $forceDelete
     * @return bool
     */
    public static function deletes($builder, $forceDelete = false)
    {
        DB::transaction(function () use ($builder, $forceDelete) {
            $records = static::getRecords($builder);
            foreach ($records as $record) {
                if ($forceDelete && has_use(SoftDeletes::class, $record)) {
                    $record->forceDelete();
                } else {
                    $record->delete();
                }
            }
        });

        return true;
    }

    /**
     * @param  Builder|\Illuminate\Database\Query\Builder|Model|Collection|\Illuminate\Database\Eloquent\Collection  $builder
     * @return bool
     */
    public static function forceDeletes($builder)
    {
        return static::deletes($builder, true);
    }

    /**
     * @param  Builder|\Illuminate\Database\Query\Builder|Model|Collection|\Illuminate\Database\Eloquent\Collection  $builder
     * @param  bool  $forceDelete
     * @return bool
     */
    public static function deletesQuietly($builder, $forceDelete = false)
    {
        return static::withoutEvents(fn () => $this->deletes($builder, $forceDelete));
    }

    private static function getRecords($builder)
    {
        return match ($builder) {
            $builder instanceof Model => [$builder],
            $builder instanceof Collection => $builder->toArray(),
            $builder instanceof \Illuminate\Database\Eloquent\Collection => $builder->toArray(),
            $builder instanceof Builder => $builder->get(),
            $builder instanceof \Illuminate\Database\Query\Builder => $builder->get(),
            default => []
        };
    }
}
