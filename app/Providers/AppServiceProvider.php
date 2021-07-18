<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Dao Registration
        $this->app->bind('App\Contracts\Dao\User\UserDaoInterface','App\Dao\User\UserDao');
        $this->app->bind('App\Contracts\Dao\Post\PostDaoInterface','App\Dao\Post\PostDao');
        //business logic 
        $this->app->bind('App\Contracts\Services\User\UserServiceInterface','App\Services\User\UserService');
        $this->app->bind('App\Contracts\Services\Post\PostServiceInterface','App\Services\Post\PostService');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        //To avoid running into errors,specify the default string length before running migration.
        //Schema::defaultStringLength(191);
    }
}
