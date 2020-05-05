<?php

namespace App\Providers;

use App\Circunscripciones;
use App\ColegiosElectorales;
use App\ComitesBases;
use App\Distritos;
use App\Municipios;
use App\People;
use App\Recintos;
use Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Circunscripciones::saved(function ($data) {
            Cache::flush();
        });

        Municipios::saved(function ($data) {
            Cache::flush();
        });

        Recintos::saved(function ($data) {
            Cache::flush();
        });

        Distritos::saved(function ($data) {
            Cache::flush();
        });

        ComitesBases::saved(function ($data) {
            Cache::flush();
        });

        ColegiosElectorales::saved(function ($data) {
            Cache::flush();
        });

        People::saved(function ($data) {
            Cache::flush();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
