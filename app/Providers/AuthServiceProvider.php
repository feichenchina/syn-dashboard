<?php

namespace App\Providers;

use Encore\Admin\Facades\Admin;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function boot(Request $request)
    {

        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config) use ($request) {
            $type = $request->input("type");
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            // return new CustomUserProvider($app->make('App\Models\Teacher'));

            if (!$type) {
                $type = session('type');
            }

            if ($type == "teacher") {
                return new CustomUserProvider($app->make('App\Models\Teacher'));
            } else {
                return new CustomUserProvider($app->make('Encore\Admin\Auth\Database\Administrator'));
            }


            // if ($type == "admin") {
            //     return new CustomUserProvider($app->make('Encore\Admin\Auth\Database\Administrator'));

            // }if ($type == "teacher") {
            //     return new CustomUserProvider($app->make('App\Models\Teacher'));
            // }

            // return new CustomUserProvider($app['hash'], $config['model']);
        });
    }
}
