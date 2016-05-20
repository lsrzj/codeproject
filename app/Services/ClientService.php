<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Description of ClientService
 *
 * @author leandro
 */
class ClientService {
    
    /**
     *
     * @var ClientRepository 
     */
    protected $repository;
    
    /**
     *
     * @var ClientValidator
     */
    protected $validator;
    
    public function __construct(ClientRepository $repository, ClientValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create(array $data){
        //Enviar e-mail
        //Disparar notificação
        //Publicar um tweet
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return response()->json([
                'error' => TRUE,
                'message' => $e->getMessageBag()
            ]);
        }
        
    }
    
    public function update(array $data, $id){
        try{
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return response()->json([
                'error' => TRUE,
                'message' => $e->getMessageBag()
            ]);
        }
        
        
    }
}
