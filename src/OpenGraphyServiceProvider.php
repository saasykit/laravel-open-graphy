<?php

namespace SaaSykit\OpenGraphy;

use SaaSykit\OpenGraphy\Commands\ClearCache;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OpenGraphyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('open-graphy')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasCommand(ClearCache::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('saasykit/laravel-open-graphy');
            });
    }
}
