<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

trait BulkDeleteTrait
{
    /**
     * @param  Builder|Model|Collection  $builder
     */
    public static function deletes(mixed $builder, bool $forceDelete = false): bool
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
     * @param  Builder|Model|Collection  $builder
     */
    public static function forceDeletes(mixed $builder): bool
    {
        return static::deletes($builder, true);
    }

    /**
     * @param  Builder|Model|Collection  $builder
     */
    public static function deletesQuietly(mixed $builder, bool $forceDelete = false): bool
    {
        return static::withoutEvents(fn () => static::deletes($builder, $forceDelete));
    }

    /**
     * @return array<Model>
     */
    private static function getRecords(mixed $builder): array
    {
        if ($builder instanceof Model) {
            return [$builder];
        }

        if ($builder instanceof \Illuminate\Database\Eloquent\Collection) {
            return $builder->toArray();
        }

        if ($builder instanceof Collection) {
            return $builder->toArray();
        }

        if ($builder instanceof Builder) {
            return $builder->get()->toArray();
        }

        if ($builder instanceof \Illuminate\Database\Query\Builder) {
            return [];
        }

        return [];
    }
}
