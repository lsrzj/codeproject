<?php

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectService;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Validators\ProjectTaskValidator;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class ProjectTaskService {

  /**
   * @var EntityManagerInterface
   */
  private $em;

  /**
   * @var ProjectTaskValidator
   */
  private $validator;

  public function __construct(EntityManagerInterface $em, ProjectTaskValidator $validator) {
    $this->em = $em;
    $this->validator = $validator;
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

  /**
   * @param ProjectTask $task
   * @return array
   */
  public function deleteTask(ProjectTask $task) {
    try {
      $this->em->remove($task);
      $this->em->flush();
      return [
        'success' => TRUE,
        'result' => 'Tarefa excluída com sucesso'
      ];
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => "Não foi possível remover a tarefa: {$e->getMessage()}"
      ];
    }
  }

  /**
   * @param ProjectTask $task
   * @param array $data
   * @return array|ProjectTask
   */
  public function updateTask(ProjectTask $task, array $data) {
    try {
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