<?php

namespace Piyook\Csvseeder;

use Illuminate\Support\ServiceProvider;
use Piyook\Csvseeder\ImportDataContract;
use Piyook\Csvseeder\ImportCSVService;

use Piyook\Csvseeder\CsvseederCommand;

class CsvseederServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImportDataContract::class, ImportCSVService::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                CsvseederCommand::class,
            ]);
        }
    }
}
