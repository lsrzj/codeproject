<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller {


  /**
   * @var EntityManagerInterface
   */
  private $em;

  /**
   * @var ProjectRepository
   */
  private $repository;

  /**
   * @var ProjectTaskService
   */
  private $service;

  /**
   * ProjectTaskController constructor.
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectTaskService $service
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectTaskService $service) {
    $this->em = $em;
    $this->repository = $repository;
    $this->service = $service;
  }

  /**
   * @param int $projectId
   * @param Request $request
   * @return array
   */
  public function getTasks (int $projectId, Request $request) {
    $project = $this->repository->find($projectId);
    if ($project) {
      if ($this->repository->checkProjectPermissions($project, $request->user())) {
        foreach ($project->getTasks() as $task) {
          $tasks[] = $task;
        }
        if (isset($tasks)) {
          return $tasks;
        } else {
          return [];
        }
      } else {
        return [
          'success' => FALSE,
          'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário ou a um membro do projeto!'
        ];
      }
    } else {
      return [
        'success' => FALSE,
        'result' => 'Projeto não encontrado'
      ];
    }
  }

  /**
   * @param int $projectId
   * @param int $noteId
   * @return array|mixed
   */
  public function showTask(int $projectId, int $noteId) {
    try {
      $DQL = <<<EOD
            SELECT pt
            FROM \CodeProject\Entities\Doctrine\Project p
              INNER JOIN \CodeProject\Entities\Doctrine\ProjectTask pt
            WHERE
                  pt.project = p
              AND pt.id = ?1
              AND p.id = ?2
EOD;
      $projectNotes = $this->em->createQuery($DQL)->setParameter(1, $noteId)
        ->setParameter(2, $projectId)
        ->getResult();
      if ($projectNotes) {
        return $projectNotes;
      } else {
        return [
          'success' => FALSE,
          'result' => 'Tarefa não encontrada!'
        ];
      }

      //return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
    } catch (ModelNotFoundException $e) {
      return [
        'success' => FALSE,
        'result' => 'Tarefa não encontrado!'
      ];
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  /**
   * @param Request $request
   * @return array
   */
  public function deleteTask(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
          $task = $this->em->find(ProjectTask::class, $request['task_id']);
          if ($project->getTasks()->contains($task)) {
            return $this->service->deleteTask($task);
          } else {
            return [
              'success' => FALSE,
              'result' => 'Tarefa não encontrada!'
            ];
          }
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário ou a um membro do projeto!'
          ];
        }
      } else {
        return [
          'success' => FALSE,
          'result' => 'Projeto não econtrado!'
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  /**
   * @param Request $request
   * @return array|ProjectTask
   */
  public function updateTask(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if ($this->repository->checkProjectPermissions($project, $request->user())) {
        $task = $this->em->find(ProjectTask::class, $request['task_id']);
        if ($project->getTasks()->contains($task)) {
          return $this->service->updateTask($task, $request->all());
        } else {
          return [
            'success' => FALSE,
            'result' => 'Tarefa não encontrada!'
          ];
        }
      } else {
        return [
          'success' => FALSE,
          'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário ou a um membro do projeto!'
        ];
      }
    } else {
      return [
        'success' => FALSE,
        'result' => 'Projeto não encontrado!'
      ];
    }
  }

  /**
   * @param Request $request
   * @return array|ProjectTask
   */
  public function addTask(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
          return $this->service->addTask($project, $request->all());
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, pois você não é proprietário ou membro do projeto'
          ];
        }
      } else {
        return [
          'success' => FALSE,
          'result' => 'Projeto não encontrado!'
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }
}