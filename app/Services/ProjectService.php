<?php

namespace CodeProject\Services;


use Carbon\Carbon;
use CodeProject\Entities\Doctrine\Client;
use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectFile;
use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;
use Prettus\Validator\Exceptions\ValidatorException;
use DateTime;

class ProjectService {
  /**
   * @var ProjectRepository
   */
  protected $repository;

  /**
   * @var ProjectValidator
   */
  protected $validator;

  /**
   * @var EntityManagerInterface
   */
  protected $em;

  /**
   * @var Filesystem
   */
  private $filesystem;
  /**
   * @var Storage
   */
  private $storage;

  /**
   * ProjectService constructor.
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectValidator $validator
   * @param Filesystem $filesystem
   * @param Storage $storage
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectValidator $validator) {
    $this->repository = $repository;
    $this->validator = $validator;
    $this->em = $em;
  }

  /**
   * @param array $data
   * @return array|Project
   */
  public function create(array $data) {
    try {
      $this->validator->with($data)->passesOrFail();
      $client = $this->em->find(Client::class, $data['client_id']);
      $owner = $this->em->find(User::class, $data['owner_id']);
      if ($client && $owner) {
        $project = new Project(
          $data['name'],
          $data['description'],
          $data['progress'],
          $data['status'],
          new DateTime($data['due_date']),
          $owner,
          $client
        );
        $this->em->persist($project);
        $this->em->flush();
        return $project;
      } else {
        return [
          'success' => FALSE,
          'result' => 'Cliente ou proprietário do projeto não encontrado!'
        ];
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
        'result' => "Erro ao inserir projeto: {$e->getMessage()}"
      ];
    }
  }

  /**
   * @param array $data
   * @param $id
   * @return array|false|null|object|string
   */
  public function update(array $data, $id) {
    try {
      $this->validator->with($data)->passesOrFail();
      //Doctrine
      $project = $this->repository->find($id);
      if ($project) {
        $project->setName($data['name']);
        $project->setDescription($data['description']);
        $project->setDueDate(new Carbon($data['due_date']));
        $project->setStatus($data['status']);
        $project->setProgress($data['progress']);
        $this->em->merge($project);
        $this->em->flush();
        return $project;
      } else {
        return [
          'success' => FALSE,
          'result' => 'Projeto não encontrado!'
        ];
      }
      //Eloquent
      //return $this->repository->update($data, $id);
    } catch (ValidatorException $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessageBag()
      ];
    } catch (ModelNotFoundException $e) { //Eloquent
      return json_encode([
        'success' => FALSE,
        'result' => 'Projeto não encontrado!'
      ], JSON_UNESCAPED_UNICODE);
    } catch (\Exception $e) {
      return json_encode([
        'success' => FALSE,
        'result' => "Erro ao atualizar: {$e->getMessage()}"
      ], JSON_UNESCAPED_UNICODE);
    }

  }

  /**
   * @param Project $project
   * @param $memberId
   * @return array
   */
  public function addMember(Project $project, $memberId) {
    $user = $this->em->find(User::class, $memberId);
    if ($user) {
      if (!$this->repository->isMember($project, $user)) {
        $project->addMember($user);
        $this->em->persist($project);
        $this->em->flush();
        return $project->getMembers()->toArray();
      } else {
        return [
          'success' => FALSE,
          'result' => 'Membro já faz parte do projeto'
        ];
      }
    } else {
      return [
        'success' => FALSE,
        'result' => 'Projeto ou membro não encontrado!'
      ];
    }
  }

  /**
   * @param Project $project
   * @param $memberId
   * @return array
   */
  public function removeMember(Project $project, $memberId) {
    $user = $this->em->find(User::class, $memberId);
    if ($user) {
      $project->removeMember($user);
      $this->em->persist($project);
      $this->em->flush();
      return $project->getMembers()->toArray();
    } else {
      return [
        'success' => FALSE,
        'result' => 'Membro ou projeto não encontrado!'
      ];
    }
  }

  /**
   * @param Project $project
   * @param $file
   * @param $name
   * @return array
   */
  public function addFile(Project $project, UploadedFile $file, $name) {
    try {
      $extension = $file->getClientOriginalExtension();
      $success = $this->storage->put($name . "." . $extension, $this->filesystem->get($file));
      $fileObj = new ProjectFile($name, $extension, '', $project);
      $this->em->persist($fileObj);
      $this->em->flush();
      if ($success) {
        return [
          'success' => TRUE,
          'result' => 'Arquivo enviado com sucesso!'
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
   * @param int $fileId
   * @return mixed
   * @throws \Exception
   */
  public function deleteFile(int $projectId, int $fileId) {
    $DQL = <<<EOD
      SELECT pf
      FROM \CodeProject\Entities\Doctrine\ProjectFile pf
        INNER JOIN \CodeProject\Entities\Doctrine\Project p
          WITH pf.project = p
      WHERE
            p.id = :projectId
        AND pf.id = :fileId 
EOD;
    $file = $this->em->createQuery($DQL)
      ->setParameter(':projectId', $projectId)
      ->setParameter(':fileId', $fileId)
      ->getSingleResult();
    if ($file) {
      $fileDb = $this->em->find(ProjectFile::class, $fileId);
      $this->em->remove($fileDb);
      $this->em->flush();
      return $this->storage->delete($file->getName() . "." . $file->getExtension());
    } else {
      throw new \Exception('Não foi possível encontrar o arquivo');
    }
  }
}
