<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\Project;
use CodeProject\Repositories\ProjectTaskNoteRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller {

    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ProjectTaskController constructor.
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(EntityManagerInterface $em, ProjectTaskRepository $repository, ProjectTaskService $service) {
        $this->repository = $repository;
        $this->service = $service;
        $this->em = $em;
    }

    /**
     * Display a listing of the resource
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        try {
            //Doctrine
            $project = $this->em->find(Project::class, $id);
            if ($project) {
                $tasksCollection = $project->getTasks();
                if ($tasksCollection->count() != 0) {
                    foreach ($tasksCollection as $task) {
                        $tasks[] = $task;
                    }
                    return $tasks;
                } else {
                    return [];
                }
            } else {
                throw new EntityNotFoundException('Não foi possível encontrar o projeto especificado!');
            }
            //Eloquent
            //return $this->repository->findWhere(['project_id' => $id]);
        } catch (\Exception $e) {
            return json_encode([
                'success' => FALSE,
                'result' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  integer $id
     * @param  integer $taskId
     * @return \Illuminate\Http\Response
     */

    public function show($id, $taskId) {
        $DQL = <<<EOD
        SELECT pt
        FROM \CodeProject\Entities\Doctrine\Project p
          INNER JOIN \CodeProject\Entities\Doctrine\ProjectTask pt
        WHERE
              pt.project = p
          AND p.id = ?1
          AND pt.id = ?2       
EOD;
        $task = $this->em->createQuery($DQL)
                         ->setParameter(1, $id)
                         ->setParameter(2, $taskId)
                         ->getResult();
        if ($task) {
            return $task;
        } else {
            return [];
        }
        //return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->service->update($request->all(), $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $task = $this->repository->find($id);
            if ($task) {
                $this->em->remove($task);
                $this->em->flush();
            } else {
                throw new EntityNotFoundException('Não foi possível encontrar a tarefa!');
            }
            //Eloquent
            //$this->repository->delete($id);
            $resp['success'] = TRUE;
            $resp['result'] = 'Tarefa excluída com sucesso!';

        } catch (ModelNotFoundException $e) {
            $resp['success'] = FALSE;
            $resp['result'] = 'Tarefa não encontrada!';
        } catch (\Exception $ex) {
            $resp['success'] = FALSE;
            $resp['result'] = $ex->getMessage();
        }
        return response()->json($resp, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
