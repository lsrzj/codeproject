<?php

namespace CodeProject\Repositories;

use Doctrine\ORM\EntityRepository;
use CodeProject\Repositories\ProjectRepository;

class ProjectRepositoryDoctrine extends EntityRepository implements ProjectRepository {
    
}