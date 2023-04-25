<?php

namespace App\Providers;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

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
        Schema::defaultStringLength(191);

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
