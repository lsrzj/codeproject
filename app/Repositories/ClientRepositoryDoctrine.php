<?php

namespace CodeProject\Repositories;

use Doctrine\ORM\EntityRepository;
use CodeProject\Repositories\ClientRepository;

class ClientRepositoryDoctrine extends EntityRepository implements ClientRepository {

}