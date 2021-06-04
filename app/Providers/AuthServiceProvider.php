<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN');
        });

        Gate::define('manage-categories', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-products', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-vouchers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-orders', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN' || $user->roles == 'SUPERVISOR');
        });

        Gate::define('manage-edit-orders', function($user){
            //return count(array_intersect(["SUPERADMIN"], json_decode($user->roles)));
            return $user->roles == 'SUPERADMIN';
        });

        Gate::define('change-password', function($user){
           // return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-banner', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-sales', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-customers', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-spv', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-group', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });

        Gate::define('manage-paket', function($user){
            //return count(array_intersect(["SUPERADMIN", "ADMIN"], json_decode($user->roles)));
            return ($user->roles == 'SUPERADMIN' || $user->roles == 'ADMIN');
        });
    }
}
