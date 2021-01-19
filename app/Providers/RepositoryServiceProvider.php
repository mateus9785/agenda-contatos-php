<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Registra a classe e a interface para a injeção de dependência
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind('App\Repositories\GroupRepositoryInterface', 'App\Repositories\GroupRepository');
        $this->app->bind('App\Repositories\ContactRepositoryInterface', 'App\Repositories\ContactRepository');
        $this->app->bind('App\Repositories\AddressRepositoryInterface', 'App\Repositories\AddressRepository');
        $this->app->bind('App\Repositories\PhoneRepositoryInterface', 'App\Repositories\PhoneRepository');
        $this->app->bind('App\Repositories\ContactGroupRepositoryInterface', 'App\Repositories\ContactGroupRepository');
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
    }
}
