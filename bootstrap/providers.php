<?php

use App\Providers\AppServiceProvider;
use App\Providers\ClientServiceProvider;
use App\Providers\EventServiceProvider;
use App\Providers\RepositoryServiceProvider;
use App\Providers\ServiceServiceProvider;

return [
    AppServiceProvider::class,
    EventServiceProvider::class,
    ServiceServiceProvider::class,
    RepositoryServiceProvider::class,
    ClientServiceProvider::class,
];
