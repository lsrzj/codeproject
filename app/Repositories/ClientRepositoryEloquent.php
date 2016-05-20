<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\Client;
use CodeProject\Repositories\ClientRepository;
/**
 * Description of ClientRepositoryEloquent
 *
 * @author leandro
 */
class ClientRepositoryEloquent extends BaseRepository implements ClientRepository {
    public function model(){
        return Client::class;
    }
}
