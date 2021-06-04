<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        Gate::define('isAdmin', function($user) {
            //return in_array("ADMIN", json_decode($user->roles));
            return $user->roles == 'ADMIN';
         });
    
         Gate::define('isSuperadmin', function($user) {
             //return in_array("SUPERADMIN", json_decode($user->roles));
             return $user->roles == 'SUPERADMIN';
         });

         Gate::define('isSales', function($user) {
            //return in_array("SALES", json_decode($user->roles));
            return $user->roles == 'SALES';
        });

        Gate::define('isSpv', function($user) {
            //return in_array("SALES", json_decode($user->roles));
            return $user->roles == 'SUPERVISOR';
        });
        
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Schema::defaultStringLength(191);
    }
}
