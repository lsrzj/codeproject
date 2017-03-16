<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\Eloquent\Client;
use CodeProject\Repositories\ClientRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {

    public function model() {
        return Client::class;
    }

}
