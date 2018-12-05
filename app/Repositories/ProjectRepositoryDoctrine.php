<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Doctrine\Project;
use Doctrine\ORM\EntityRepository;
use CodeProject\Entities\Doctrine\User;

class ProjectRepositoryDoctrine extends EntityRepository implements ProjectRepository {

  /**
   * @param Project $project
   * @param User $member
   * @return bool
   */
  public function isMember(Project $project, User $member) {
    $DQL = <<<EOD
            SELECT p
            FROM \CodeProject\Entities\Doctrine\Project p
              INNER JOIN p.members pm
            WHERE
                  p = :project
              AND pm = :member
EOD;

    $project = $this->getEntityManager()
      ->createQuery($DQL)
      ->setParameter(':project', $project)
      ->setParameter(':member', $member)
      ->getResult();
    if ($project) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * @param Project $project
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function isOwner(Project $project, User $user) {
    if ($project->getOwner() == $user) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * @param Project $project
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function checkProjectPermissions(Project $project, User $user): bool {
    if ($this->isOwner($project, $user) ||
      $this->isMember($project, $user)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}