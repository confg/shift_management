<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        //管理者
        Gate::define('admin', function ($user) {    
		return ($user->role == true);
        });
        
        //ユーザー
        Gate::define('user', function ($user) {
		return ($user->role == false);
        });
        
        //ログインユーザーのみ
        Gate::define('login_user', function ($user) {
		return ($user->id == Auth::id());
        });
    }
}
