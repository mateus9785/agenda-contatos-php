<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    /**
     * Registra a classe e a interface para a injeção de dependência
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Clients\IbgeProvincesClientInterface', 'App\Clients\IbgeProvincesClient');
    }
}
