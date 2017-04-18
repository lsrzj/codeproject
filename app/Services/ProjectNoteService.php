<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService {

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

    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator) {
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
