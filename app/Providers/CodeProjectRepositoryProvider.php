<?php

namespace CodeProject\Providers;

use CodeProject\Entities\Doctrine\Client;
use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ClientRepositoryDoctrine;
use CodeProject\Repositories\ClientRepositoryEloquent;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectNoteRepositoryDoctrine;
use CodeProject\Repositories\ProjectNoteRepositoryEloquent;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryDoctrine;
use CodeProject\Repositories\ProjectRepositoryEloquent;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Repositories\ProjectTaskRepositoryDoctrine;
use CodeProject\Repositories\ProjectTaskRepositoryEloquent;
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
        /*$this->app->bind(
            ClientRepository::class,
            ClientRepositoryEloquent::class
        );*/

        $this->app->bind(ClientRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ClientRepositoryDoctrine(
                    $app['em'], $app['em']->getClassMetaData(Client::class)
            );
        });

        /*$this->app->bind(
            ProjectRepository::class,
            ProjectRepositoryEloquent::class);*/

        $this->app->bind(ProjectRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ProjectRepositoryDoctrine(
                    $app['em'], $app['em']->getClassMetaData(Project::class)
            );
        });

        /*$this->app->bind(
            ProjectNoteRepository::class,
            ProjectNoteRepositoryEloquent::class);*/

        $this->app->bind(ProjectNoteRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ProjectNoteRepositoryDoctrine(
                $app['em'], $app['em']->getClassMetaData(ProjectNote::class)
            );
        });

        /*$this->app->bind(
            ProjectTaskRepository::class,
            ProjectTaskRepositoryEloquent::class);*/

        $this->app->bind(ProjectTaskRepository::class, function($app) {
            // This is what Doctrine's EntityRepository needs in its constructor.
            return new ProjectTaskRepositoryDoctrine(
                $app['em'], $app['em']->getClassMetaData(ProjectTask::class)
            );
        });

    }

}
