<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ClientRepositoryEloquent;
//use CodeProject\Repositories\ClientRepositoryDoctrine;
//use CodeProject\Entities\Doctrine\Client;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryEloquent;
//use CodeProject\Repositories\ProjectRepositoryDoctrine;
//use CodeProject\Entities\Doctrine\Project;


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

        /*$this->app->bind(ClientRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ClientRepositoryDoctrine(
                    $app['em'], $app['em']->getClassMetaData(Client::class)
            );
        });*/
        
        $this->app->bind(
                ProjectRepository::class, ProjectRepositoryEloquent::class);

        /*$this->app->bind(ProjectRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ProjectRepositoryDoctrine(
                    $app['em'], $app['em']->getClassMetaData(Project::class)
            );
        });*/
        
        $this->app->bind(
                ProjectNoteRepository::class, ProjectNoteRepositoryEloquent::class);
    }

}
