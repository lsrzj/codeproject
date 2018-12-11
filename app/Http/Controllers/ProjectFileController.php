<?php

namespace CodeProject\Http\Controllers;


use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectFileService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;


class ProjectFileController extends Controller {
  /**
   * @var EntityManagerInterface
   */
  private $em;
  /**
   * @var ProjectRepository
   */
  private $repository;
  /**
   * @var ProjectFileService
   */
  private $service;

  /**
   * ProjectFileController constructor.
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectFileService $service
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectFileService $service) {

    $this->em = $em;
    $this->repository = $repository;
    $this->service = $service;
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

  public function deleteFile(Request $request) {
    $project = $this->repository->find($request['project_id']);
    if ($project) {
      if($this->repository->checkProjectPermissions($project, $request->user())) {
        if ($this->service->deleteFile($project->getId(), $request['file_id'])){
          return [
            'success' => TRUE,
            'result' => 'Arquivo apagado com sucesso'
          ];
        } else {
          return [
            'success' => FALSE,
            'result' => 'Não foi possível apagar o arquivo'
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