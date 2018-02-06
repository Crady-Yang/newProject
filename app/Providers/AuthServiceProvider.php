<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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
//        Passport::tokensCan([
//            'activity' => 'activity user',
//            'frozen' => 'frozen user',
//            'manager' => 'platform user'
//        ]);
        Passport::routes(); //令牌永久有效
//
//        //设置/获取 令牌过期时间
//        Passport::tokensExpireIn(Carbon::now()->addDays(15));
//
//        //设置/获取 令牌刷新时间
//        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        //
    }
}
