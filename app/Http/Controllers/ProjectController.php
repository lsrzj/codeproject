<?php

namespace CodeProject\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Doctrine
        return response()->json($this->repository->findAll());
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
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->repository->find($id);
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

}
