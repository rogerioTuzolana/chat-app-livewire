<?php

namespace App\Providers;

use App\Http\Middleware\Authenticate;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('is_admin',function(Authenticatable $user){
            return $user->type == 'admin';
        });

        Gate::define('is_edit',function(Authenticatable $user){
            return $user->type == 'edit';
        });
    }
}
