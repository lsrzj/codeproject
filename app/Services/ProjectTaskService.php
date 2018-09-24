<?php

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use DoctrineExtensions\Query\Mysql\Date;
use Prettus\Validator\Exceptions\ValidatorException;
use DateTime;

class ProjectTaskService {
    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em, ProjectTaskRepository $repository, ProjectTaskValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->em = $em;
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();
            $project = $this->em->find(Project::class, $data['project_id']);
            if ($project) {
                $task = new ProjectTask(
                    $data['name'],
                    new DateTime($data['start_date']),
                    new DateTime($data['due_date']),
                    $data['status'],
                    $project
                );
                $this->em->persist($task);
                $this->em->flush();
                return $task;
            } else {
                throw new EntityNotFoundException('Não foi possível encontrar o projeto!');
            }
            //return $this->repository->create($data);
        } catch (ValidatorException $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessage()
            ];
        }
    }

    public function update(array $data, $id) {
        try {
            $this->validator->with($data)->passesOrFail();
            $task = $this->repository->find($id);
            if ($task) {
                $task->setName($data['name']);
                $task->setStartDate(new DateTime($data['start_date']));
                $task->setDueDate(new DateTime($data['due_date']));
                $task->setStatus($data['status']);
                $this->em->merge($task);
                $this->em->flush();
                return $task;
            } else {
                throw new EntityNotFoundException('Não foi possível encontrar a tarefa!');
            }
            //Eloquent
            //return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessageBag()
            ];
        } catch (ModelNotFoundException $e) {
            return json_encode([
                'success' => FALSE,
                'result' => 'Tarefa não encontrada!'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return json_encode([
                'success' => FALSE,
                'result' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }

    }
}