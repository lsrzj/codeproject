<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Doctrine\Project;
use Doctrine\ORM\EntityRepository;
use CodeProject\Entities\Doctrine\User;

class ProjectRepositoryDoctrine extends EntityRepository implements ProjectRepository {

  /**
   * @param $id
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function isMember(Project $project, User $user) {
    if ($project->getMembers()->contains($user)) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @param $id
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function isOwner(Project $project, User $user) {
    if ($project->getOwner() == $user) {
      return true;
    } else {
      return false;
    }
  }
}