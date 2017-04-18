<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ClientRepositoryEloquent;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectNoteRepositoryEloquent;


class CodeProjectRepositoryProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind(
                ClientRepository::class, ClientRepositoryEloquent::class);

        $this->app->bind(
                ProjectRepository::class, ProjectRepositoryEloquent::class);
        
        $this->app->bind(
                ProjectNoteRepository::class, ProjectNoteRepositoryEloquent::class);
        
    
    }

}
