<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (! app()->isProduction()) {
            Model::preventLazyLoading();

            // DB::listen(function (QueryExecuted $event) {
            //     if ($event->time > 100) {
            //         throw new QueryException(
            //             $event->sql,
            //             $event->bindings,
            //             new Exception("Individual database query exceed 100ms")
            //         );
            //     }
            // });
        }
    }
}
