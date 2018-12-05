<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 05/12/18
 * Time: 18:18
 */

namespace CodeProject\Http\Controllers;


use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectNoteService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class ProjectNoteController {
  /**
   * @var EntityManagerInterface
   */
  private $em;
  /**
   * @var ProjectRepository
   */
  private $repository;
  /**
   * @var ProjectNoteService
   */
  private $service;


  /**
   * ProjectNoteController constructor.
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectNoteService $service
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectNoteService $service) {
    $this->em = $em;
    $this->repository = $repository;
    $this->service = $service;
  }

  /**
   * @param Request $request
   * @return ProjectNote
   */
  public function addNote(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
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
  public function getNotes(int $projectId, Request $request) {
    $project = $this->repository->find($projectId);
    if ($project) {
      if ($this->repository->checkProjectPermissions($project, $request->user())) {
        foreach ($project->getNotes() as $note) {
          $notes[] = $note;
        }
        if (isset($notes)) {
          return $notes;
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
   * @param Request $request
   * @return array
   */
  public function deleteNote(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
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

  /**
   * @param Request $request
   * @return array
   */
  public function updateNote(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if ($this->repository->checkProjectPermissions($project, $request->user())) {
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
}