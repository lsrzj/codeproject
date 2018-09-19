<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 16/08/18
 * Time: 22:06
 */

namespace CodeProject\Services;


use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\ProjectNote;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService {
    /**
     * @var ProjectNoteRepository
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em, ProjectNoteRepository $repository, ProjectNoteValidator $validator) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->em = $em;
    }

    public function create(array $data) {
        try {
            $this->validator->with($data)->passesOrFail();
            $project = $this->em->find(Project::class, $data['project_id']);
            if ($project) {
                $projectNote = new ProjectNote(
                    $data['title'],
                    $data['note'],
                    $project
                );
                $this->em->persist($projectNote);
                $this->em->flush();
                return $projectNote;
            } else {
                throw new EntityNotFoundException('Projeto não encontrado');
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
                'result' => $e->getMessage()
            ];
        }
    }

    public function update(array $data, $id) {
        try {
            $this->validator->with($data)->passesOrFail();
            $projectNote = $this->repository->find($id);
            if ($projectNote) {
                $projectNote->setTitle($data['title']);
                $projectNote->setNote($data['note']);
                $this->em->merge($projectNote);
                $this->em->flush();
                return $projectNote;
            } else {
                throw new EntityNotFoundException('Nota não encontrada!');
            }
            //Eloquent
            //return $this->repository->update($data, $id);
        } catch (ValidatorException $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessageBag()
            ];
        } catch (ModelNotFoundException $e) {
            return json_encode([
                'success' => FALSE,
                'result' => 'Nota não encontrada!'
            ], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            return [
                'success' => FALSE,
                'result' => $e->getMessage()
            ];
        }

    }
}