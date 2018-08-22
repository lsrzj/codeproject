<?php

namespace CodeProject\Providers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ClientRepositoryEloquent;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );

        $this->app->bind(
            ProjectRepository::class,
            ProjectRepositoryEloquent::class);

    }
}
