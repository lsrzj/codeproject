<?php

namespace CodeProject\Services;


use Carbon\Carbon;
use CodeProject\Entities\Doctrine\Client;
use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Entities\Doctrine\ProjectTask;
use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectNoteValidator;
use CodeProject\Validators\ProjectTaskValidator;
use CodeProject\Validators\ProjectValidator;
use Doctrine\ORM\EntityManagerInterface;
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
   * @var ProjectNoteValidator
   */
  private $noteValidator;
  /**
   * @var ProjectTaskValidator
   */
  private $taskValidator;

  /**
   * ProjectService constructor.
   * @param EntityManagerInterface $em
   * @param ProjectRepository $repository
   * @param ProjectValidator $validator
   * @param ProjectNoteValidator $noteValidator
   * @param ProjectTaskValidator $taskValidator
   */
  public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectValidator $validator,
                              ProjectNoteValidator $noteValidator, ProjectTaskValidator $taskValidator) {
    $this->repository = $repository;
    $this->validator = $validator;
    $this->em = $em;
    $this->noteValidator = $noteValidator;
    $this->taskValidator = $taskValidator;
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
   * @param array $data
   * @return array|ProjectNote
   */
  public function addNote(Project $project, array $data) {
    try {
      $this->noteValidator->with($data)->passesOrFail();
      $note = new ProjectNote($data['title'], $data['note'], $project);
      $this->em->persist($note);
      $this->em->flush();
      return $note;
    } catch (ValidatorException $e) {
      return [
        'success' => FALSE,
        'result' => $e->getMessageBag()
      ];
    }
  }

  /**
   * @param ProjectNote $note
   * @return array
   */
  public function deleteNote(ProjectNote $note) {
    try {
      $this->em->remove($note);
      $this->em->flush();
      return [
        'success' => TRUE,
        'result' => 'Nota excluída com sucesso'
      ];
    } catch (\Exception $e) {
      return [
        'success' => FALSE,
        'result' => "Não foi possível remover a nota: {$e->getMessage()}"
      ];
    }
  }

  /**
   * @param ProjectNote $note
   * @param array $data
   * @return array|ProjectNote
   */
  public function updateNote(ProjectNote $note, array $data) {
    try {
      $this->noteValidator->with($data)->passesOrFail();
      $note->setTitle($data['title']);
      $note->setNote($data['note']);
      $this->em->persist($note);
      $this->em->flush();
      return $note;
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

  /**
   * @param Project $project
   * @param array $data
   * @return array|ProjectTask
   */
  public function addTask(Project $project, array $data) {
    try {
      $this->taskValidator->with($data)->passesOrFail();
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
      $this->taskValidator->with($data)->passesOrFail();
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
