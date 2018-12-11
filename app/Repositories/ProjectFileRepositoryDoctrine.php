<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 10/12/18
 * Time: 21:53
 */

namespace CodeProject\Repositories;


use Doctrine\ORM\EntityRepository;

class ProjectFileRepositoryDoctrine extends EntityRepository implements ProjectFileRepository {

  /**
   * @param int $projectId
   * @param int $fileId
   * @return mixed
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function getFileFromProject(int $projectId, int $fileId) {
    $DQL = <<<EOD
      SELECT pf
      FROM \CodeProject\Entities\Doctrine\ProjectFile pf
        INNER JOIN \CodeProject\Entities\Doctrine\Project p
          WITH pf.project = p
      WHERE
            p.id = :projectId
        AND pf.id = :fileId 
EOD;
    return $this->getEntityManager()->createQuery($DQL)
      ->setParameter(':projectId', $projectId)
      ->setParameter(':fileId', $fileId)
      ->getSingleResult();
  }
}