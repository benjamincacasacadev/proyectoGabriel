<?php

namespace App\Providers;

use App\User;
use App\Vehiculos;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        //  Mapeo para polimorfismo
        Relation::morphMap([
            // Inventario
            'A0' => User::class,
            'A1' => Vehiculos::class,
        ]);
    }
}
