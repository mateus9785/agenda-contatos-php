<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Registra a classe e a interface para a injeção de dependência
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind('App\Services\GroupServiceInterface', 'App\Services\GroupService');
        $this->app->bind('App\Services\ContactServiceInterface', 'App\Services\ContactService');
        $this->app->bind('App\Services\RegisterServiceInterface', 'App\Services\RegisterService');
    }
}
