<?php

namespace CodeProject\Repositories;

use Doctrine\ORM\EntityRepository;
use CodeProject\Entities\Doctrine\User;

class ProjectRepositoryDoctrine extends EntityRepository implements ProjectRepository {

  /**
   * @param $id
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function isMember($id, User $user) {
    $project = $this->find($id);
    if ($project) {
      if ($project->getMembers()->contains($user)) {
        return true;
      } else {
        return false;
      }
    } else {
      throw new \Exception('Projeto não encontrado');
    }
  }

  /**
   * @param $id
   * @param User $user
   * @return bool
   * @throws \Exception
   */
  public function isOwner($id, User $user) {
    try {
      $project = $this->find($id);
      if ($project) {
        if ($project->getOwner() == $user) {
          return true;
        } else {
          return false;
        }
      } else {
        throw new \Exception('Projeto ou usuário não encontrado');
      }
    } catch (\Exception $e) {
      throw $e;
    }
  }
}