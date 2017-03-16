<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService {

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

    public function __construct(ProjectRepository $repository, ProjectValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function create(array $data) {
        //Enviar e-mail
        //Disparar notificação
        //Publicar um tweet
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return response()->json([
                        'error' => TRUE,
                        'message' => $e->getMessageBag()
            ]);
        }
    }

    public function update(array $data, $id) {
        try {
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
