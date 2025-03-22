<?php

namespace TLabsCo\TraitAndHelper\Commands;

use Illuminate\Console\Command;

class TraitAndHelperCommand extends Command
{
    public $signature = 't-labs-co:trait-and-helper';

    public $description = 'Listing all the available traits and helpers';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
