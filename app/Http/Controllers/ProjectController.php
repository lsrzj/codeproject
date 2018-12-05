<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
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
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectService $service
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
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
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
        if ($this->repository->checkProjectOwner($id, $request->user())) {
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
   * @param  Request $request
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request) {
    try {
      $project = $this->repository->find($request['id']);
      if ($project) {
        if ($this->repository->checkProjectOwner($project, $request->user())) {
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
        if ($this->repository->checkProjectPermissions($project, $request->user())) {
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
   * @param Request $request
   * @return array
   */
  public function addMember(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectOwner($project, $request->user())) {
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
   * @param Request $request
   * @return array
   */
  public function removeMember(Request $request) {
    try {
      $project = $this->repository->find($request['project_id']);
      if ($project) {
        if ($this->repository->checkProjectOwner($project, $request->user())) {
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
   * @return array
   */
  public function addFile(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if($this->repository->checkProjectPermissions($project, $request->user())) {
        return $this->service->addFile($project, $request->file('file'), $request['name']);
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
