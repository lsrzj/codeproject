<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    //Doctrine
    return response()->json($this->repository->findBy(['owner' => $request->user()]));
    //Eloquent
    //return $this->repository->with(['user', 'client'])->all();
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
  public function show($id, Request $request) {
    try {
      if ($this->checkProjectPermissions($id, $request->user())) {
        return $this->repository->find($id);
      } else {
        return [
          'success' => FALSE,
          'result' => 'Não foi possível acessar o projeto, pois você não é o proprietário ou não é membro'
        ];
      }
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
    //return $this->repository->with(['client', 'user'])->find($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  integer $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id) {
    return $this->service->update($request->all(), $id);

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  integer $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    try {
      $project = $this->repository->find($id);
      if ($project) {
        $this->em->remove($project);
        $this->em->flush();
      } else {
        throw new EntityNotFoundException('Projeto não encontrado!');
      }
      //Eloquent
      //$this->repository->delete($id);
      $resp['success'] = TRUE;
      $resp['result'] = 'Projeto excluído com sucesso!';

    } catch (ModelNotFoundException $e) {
      $resp['success'] = FALSE;
      $resp['result'] = 'Projeto não encontrado!';
    } catch (\Exception $ex) {
      $resp['success'] = FALSE;
      $resp['result'] = $ex->getMessage();
    }
    return response()->json($resp, 200, [], JSON_UNESCAPED_UNICODE);
  }

  public function listMembers($id) {
    try {
      $project = $this->repository->find($id);
      if ($project) {
        $membersCollection = $project->getMembers();
        foreach ($membersCollection as $member) {
          $members[] = $member;
        }
      }
      //$members = $this->repository->find($id)->members()->get();
      if (count($members)) {
        return $members;
      } else {
        return [];
      }
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

  public function addMember($id, $memberId) {
    try {
      return $this->service->addMember($id, $memberId);
    } catch (ModelNotFoundException $e) {
      return [
        'success' => FALSE,
        'result' => 'Projeto ou usuário não encontrado!'
      ];
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  public function removeMember($id, $memberId) {
    try {
      return $this->service->removeMember($id, $memberId);
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessage()
      ];
    }
  }

  private function checkProjectOwner ($projectId, User $user) {
    if ($this->repository->isOwner($projectId, $user)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  private function checkProjectMember ($projectId, User $user) {
    return $this->repository->isMember($projectId, $user);
  }

  private function checkProjectPermissions($projectId, User $user) {
    if($this->checkProjectOwner($projectId, $user) ||
       $this->checkProjectMember($projectId,$user)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

}
