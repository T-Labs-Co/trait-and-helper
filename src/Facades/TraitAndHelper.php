<?php

namespace TLabsCo\TraitAndHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TLabsCo\TraitAndHelper\TraitAndHelper
 */
class TraitAndHelper extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TLabsCo\TraitAndHelper\TraitAndHelper::class;
    }
}
