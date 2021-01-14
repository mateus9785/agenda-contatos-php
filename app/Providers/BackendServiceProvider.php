<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Http\Services\GroupServiceInterface','App\Http\Services\GroupService');
        $this->app->bind('App\Http\Repositories\GroupRepositoryInterface', 'App\Http\Repositories\GroupRepository');

        $this->app->bind('App\Http\Services\ContactServiceInterface','App\Http\Services\ContactService');
        $this->app->bind('App\Http\Repositories\ContactRepositoryInterface', 'App\Http\Repositories\ContactRepository');

        $this->app->bind('App\Http\Repositories\AddressRepositoryInterface', 'App\Http\Repositories\AddressRepository');

        $this->app->bind('App\Http\Repositories\PhoneRepositoryInterface', 'App\Http\Repositories\PhoneRepository');

        $this->app->bind('App\Http\Repositories\ContactGroupRepositoryInterface', 'App\Http\Repositories\ContactGroupRepository');

        $this->app->bind('App\Http\Repositories\UserRepositoryInterface', 'App\Http\Repositories\UserRepository');

        $this->app->bind('App\Http\Services\RegisterServiceInterface', 'App\Http\Services\RegisterService');
    }
}
