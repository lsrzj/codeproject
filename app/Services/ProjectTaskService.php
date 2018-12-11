<?php

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectService;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
use Doctrine\ORM\NoResultException;

class ProjectTaskService {

  /**
   * @var EntityManagerInterface
   */
  private $em;

  /**
   * @var ProjectTaskValidator
   */
  private $validator;

  /**
   * @var ProjectTaskRepository
   */
  private $repository;


  /**
   * ProjectTaskService constructor.
   * @param EntityManagerInterface $em
   * @param ProjectTaskRepository $repository
   * @param ProjectTaskValidator $validator
   */
  public function __construct(EntityManagerInterface $em, ProjectTaskRepository $repository, ProjectTaskValidator $validator) {
    $this->em = $em;
    $this->validator = $validator;
    $this->repository = $repository;
  }

  /**
   * @param Project $project
   * @param array $data
   * @return array|ProjectTask
   * @throws \Prettus\Validator\Exceptions\ValidatorException
   */
  public function addTask(Project $project, array $data) {
    try {
      $this->validator->with($data)->passesOrFail();
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
    } catch (ValidatorException $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessageBag()
      ];
    }
  }

  public function getTask(int $projectId, int $taskId) {
    try {
      return $this->repository->getTaskFromProject($projectId, $taskId);
    } catch (NoResultException $e) {
      return FALSE;
    }
  }

  /**
   * @param int $projectId
   * @param int $taskId
   * @return bool
   * @throws \Exception
   */
  public function deleteTask(int $projectId, int $taskId) {
      try {
        $task = $this->repository->getTaskFromProject($projectId, $taskId);
        $this->em->remove($task);
        $this->em->flush();
        return TRUE;
      } catch (NoResultException $e) {
        return FALSE;
      }
    }

  /**
   * @param int $projectId
   * @param int $taskId
   * @param array $data
   * @return array
   */
  public function updateTask(int $projectId, int $taskId, array $data) {
    try {
      $task = $this->repository->getTaskFromProject($projectId, $taskId);
      $this->validator->with($data)->passesOrFail();
      $task->setName($data['name']);
      $task->setStartDate(new DateTime($data['start_date']));
      $task->setDueDate(new DateTime($data['due_date']));
      $task->setStatus($data['status']);
      $this->em->persist($task);
      $this->em->flush();
      return $task;
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
}