<?php
/**
 * Created by PhpStorm.
 * User: leandro
 * Date: 16/08/18
 * Time: 22:06
 */

namespace CodeProject\Services;


use Carbon\Carbon;
use CodeProject\Entities\Doctrine\Client;
use CodeProject\Entities\Doctrine\Project;
use CodeProject\Entities\Doctrine\User;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

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

    public function __construct(EntityManagerInterface $em, ProjectRepository $repository, ProjectValidator $validator)  {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->em = $em;
    }
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
                throw new EntityNotFoundException('Não foi possível encontrar o projeto!');
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
}