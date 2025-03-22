<?php

namespace TLabsCo\TraitAndHelper;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TLabsCo\TraitAndHelper\Commands\TraitAndHelperCommand;

class TraitAndHelperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('trait-and-helper')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_trait_and_helper_table')
            ->hasCommand(TraitAndHelperCommand::class);
    }
}
