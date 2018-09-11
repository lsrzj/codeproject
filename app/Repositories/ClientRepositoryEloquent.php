<?php
/**
 * Created by PhpStorm.
 * User: carlos
 * Date: 07/08/18
 * Time: 10:58
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Eloquent\Client;
use Prettus\Repository\Eloquent\BaseRepository;


class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Client::class;
    }
}