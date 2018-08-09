<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\Client;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {
    public function model () {
        return Client::class;
    }
}