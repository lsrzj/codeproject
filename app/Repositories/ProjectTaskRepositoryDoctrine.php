<?php

namespace CodeProject\Repositories;


use Doctrine\ORM\EntityRepository;

class ProjectTaskRepositoryDoctrine extends EntityRepository implements ProjectTaskRepository {

  /**
   * @param $projectId
   * @param $taskId
   * @return bool|mixed
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getTaskFromProject($projectId, $taskId) {
    $DQL = <<<EOD
        SELECT pt
        FROM \CodeProject\Entities\Doctrine\ProjectTask pt
          INNER JOIN \CodeProject\Entities\Doctrine\Project p
            WITH pt.project = p
          WHERE
                pt.id = :taskId
            AND p.id = :projectId
EOD;
    return $this->getEntityManager()
      ->createQuery($DQL)
      ->setParameter(':taskId', $taskId)
      ->setParameter(':projectId', $projectId)
      ->getSingleResult();
  }
}