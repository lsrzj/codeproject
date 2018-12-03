<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Validators\ProjectNoteValidator;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller {

  /**
   * @var ProjectRepository
   */
  private $repository;

  /**
   * @var ProjectService
   */
  private $service;

  /**
   * @var EntityManagerInterface
   */
  private $em;


  /**
   * ProjectController constructor.
   *
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectService $service
   * @param ProjectNoteValidator $noteValidator
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectService $service) {
    $this->repository = $repository;
    $this->service = $service;
    $this->em = $em;
  }

  /**
   * Display a listing of the resource
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request) {
    return response()->json($this->repository->findBy(['owner' => $request->user()]));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    return $this->service->create($request->all());
  }

  /**
   * Display the specified resource.
   *
   * @param  integer $id
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function show(int $id, Request $request) {
    try {
      $project = $this->repository->find($id);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
          return $project;
        } else {
          return [
            'success' => FALSE,
            'result' => 'Não foi possível acessar o projeto, pois você não é o proprietário ou não é membro'
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

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  integer $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, int $id) {
    try {
      $project = $this->repository->find($id);
      if ($project) {
        if ($this->checkProjectOwner($id, $request->user())) {
          return $this->service->update($request->all(), $id);
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário do projeto!'
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

  /**
   * Remove the specified resource from storage.
   *
   * @param  integer $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request) {
    try {
      $project = $this->repository->find($request['id']);
      if ($project) {
        if ($this->checkProjectOwner($project, $request->user())) {
          $this->em->remove($project);
          $this->em->flush();
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário do projeto!'
          ];
        }
      } else {
        return [
          'success' => FALSE,
          'result' => 'Projeto não encontrado!'
        ];
      }
      $resp['success'] = TRUE;
      $resp['result'] = 'Projeto excluído com sucesso!';

    } catch (\Exception $ex) {
      $resp['success'] = FALSE;
      $resp['result'] = $ex->getMessage();
    }
    return response()->json($resp, 200, [], JSON_UNESCAPED_UNICODE);
  }

  /**
   * @param int $id
   * @param Request $request
   * @return array
   */
  public function listMembers(int $id, Request $request) {
    try {
      $project = $this->repository->find($id);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
          return $project->getMembers()->toArray();
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, você não é membro ou proprietário do projeto'
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

  /**
   * @param int $id
   * @param int $memberId
   * @param Request $request
   * @return array
   */
  public function addMember(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectOwner($project, $request->user())) {
          return $this->service->addMember($project, $request['member_id']);
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário do projeto!'
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

  /**
   * @param int $projectId
   * @param int $memberId
   * @param Request $request
   * @return array
   */
  public function removeMember(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectOwner($project, $request->user())) {
          return $this->service->removeMember($project, $request['member_id']);
        } else {
          return [
            'success' => FALSE,
            'result' => 'Você não tem permissão para executar esta ação, requisite ao proprietário do projeto'
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

  /**
   * @param Request $request
   * @return ProjectNote
   */
  public function addNote(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
          return $this->service->addNote($project, $request->all());
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

  /**
   * @param int $projectId
   * @param Request $request
   * @return array
   */
  public function getNotes (int $projectId, Request $request) {
    $project = $this->repository->find($projectId);
    if ($project) {
      if ($this->checkProjectPermissions($project, $request->user())) {
        foreach ($project->getNotes() as $note) {
          $notes[] = $note;
        }
        return $notes;
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

  public function showNote(int $projectId, int $noteId) {
    try {
      $DQL = <<<EOD
            SELECT pn
            FROM \CodeProject\Entities\Doctrine\Project p
              INNER JOIN \CodeProject\Entities\Doctrine\ProjectNote pn
            WHERE
                  pn.project = p
              AND pn.id = ?1
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
          'result' => 'Nota não encontrada!'
        ];
      }

      //return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
    } catch (ModelNotFoundException $e) {
      return [
        'success' => FALSE,
        'result' => 'Projeto não encontrado!'
      ];
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  /**
   * @param $projectId
   * @param $noteId
   * @param Request $request
   * @return array
   */
  public function deleteNote(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
          $note = $this->em->find(ProjectNote::class, $request['note_id']);
          if ($project->getNotes()->contains($note)) {
            return $this->service->deleteNote($note);
          } else {
            return [
              'success' => FALSE,
              'result' => 'Nota não encontrada!'
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

  public function updateNote(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if ($this->checkProjectPermissions($project, $request->user())) {
        $note = $this->em->find(ProjectNote::class, $request['note_id']);
        if ($project->getNotes()->contains($note)) {
          return $this->service->updateNote($note, $request->all());
        } else {
          return [
            'success' => FALSE,
            'result' => 'Nota não encontrada!'
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
   * @param int $projectId
   * @param Request $request
   * @return array
   */
  public function getTasks (int $projectId, Request $request) {
    $project = $this->repository->find($projectId);
    if ($project) {
      if ($this->checkProjectPermissions($project, $request->user())) {
        foreach ($project->getTasks() as $task) {
          $tasks[] = $task;
        }
        return $tasks;
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

  public function addTask(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
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

  /**
   * @param $projectId
   * @param $taskId
   * @param Request $request
   * @return array
   */
  public function deleteTask(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->checkProjectPermissions($project, $request->user())) {
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

  public function updateTask(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if ($this->checkProjectPermissions($project, $request->user())) {
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
   * @param Project $project
   * @param User $user
   * @return bool
   */
  private function checkProjectOwner(Project $project, User $user) {
    if ($this->repository->isOwner($project, $user)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * @param Project $project
   * @param User $user
   * @return bool
   */
  private function checkProjectMember(Project $project, User $user): bool {
    return $this->repository->isMember($project, $user);
  }

  /**
   * @param Project $project
   * @param User $user
   * @return bool
   */
  private function checkProjectPermissions(Project $project, User $user): bool {
    if ($this->checkProjectOwner($project, $user) ||
      $this->checkProjectMember($project, $user)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

}
