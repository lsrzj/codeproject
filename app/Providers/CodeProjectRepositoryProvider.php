<?php

namespace CodeProject\Providers;

use CodeProject\Entities\Doctrine\Client;
use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectFile;
use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ClientRepositoryDoctrine;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectFileRepositoryDoctrine;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectNoteRepositoryDoctrine;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectRepositoryDoctrine;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Repositories\ProjectTaskRepositoryDoctrine;
use CodeProject\Repositories\UserRepository;
use CodeProject\Repositories\UserRepositoryDoctrine;
use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider {
  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot() {
    //
  }

  /**
   * Register services.
   *
   * @return void
   */
  public function register() {
    $this->app->bind(ClientRepository::class, function ($app) {
      // This is what Doctrine's EntityRepository needs in its constructor.
      return new ClientRepositoryDoctrine(
        $app['em'], $app['em']->getClassMetaData(Client::class)
      );
    });

    $this->app->bind(ProjectRepository::class, function ($app) {
      // This is what Doctrine's EntityRepository needs in its constructor.
      return new ProjectRepositoryDoctrine(
        $app['em'], $app['em']->getClassMetaData(Project::class)
      );
    });

    $this->app->bind(ProjectTaskRepository::class, function ($app) {
      // This is what Doctrine's EntityRepository needs in its constructor.
      return new ProjectTaskRepositoryDoctrine(
        $app['em'], $app['em']->getClassMetaData(Project::class)
      );
    });

    $this->app->bind(ProjectFileRepository::class, function ($app) {
      // This is what Doctrine's EntityRepository needs in its constructor.
      return new ProjectFileRepositoryDoctrine(
        $app['em'], $app['em']->getClassMetaData(ProjectFile::class)
      );
    });

    $this->app->bind(UserRepository::class, function ($app) {
      // This is what Doctrine's EntityRepository needs in its constructor.
      return new UserRepositoryDoctrine(
        $app['em'], $app['em']->getClassMetaData(User::class)
      );
    });
  }
}
