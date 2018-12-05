<?php

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Validators\ProjectNoteValidator;
use Doctrine\ORM\EntityManagerInterface;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectNoteService {

  /**
   * @var EntityManagerInterface
   */
  private $em;
  /**
   * @var ProjectNoteValidator
   */
  private $validator;

  /**
   * ProjectNoteService constructor.
   * @param EntityManagerInterface $em
   * @param ProjectNoteValidator $validator
   */
  public function __construct(EntityManagerInterface $em, ProjectNoteValidator $validator) {
    $this->em = $em;
    $this->validator = $validator;
  }

  /**
   * @param Project $project
   * @param array $data
   * @return array|ProjectNote
   */
  public function addNote(Project $project, array $data) {
    try {
      $this->validator->with($data)->passesOrFail();
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
      $this->validator->with($data)->passesOrFail();
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
}