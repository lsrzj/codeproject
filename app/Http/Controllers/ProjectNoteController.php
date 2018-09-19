<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Doctrine\Project;
use CodeProject\Repositories\ProjectNoteNoteRepository;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectNoteController extends Controller {

    /**
     * @var ProjectNoteRepository
     */
    private $repository;

    /**
     * @var ProjectNoteService
     */
    private $service;

    private $em;

    /**
     * ProjectNoteController constructor.
     *
     * @param EntityManagerInterface $em
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(EntityManagerInterface $em, ProjectNoteRepository $repository, ProjectNoteService $service) {
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
            $project = $this->em->getRepository(Project::class)->find($id);
            if ($project) {
                $notesCollection = $project->getProjectNotes();
                if ($notesCollection->count() != 0) {
                    foreach ($notesCollection as $note) {
                        $notes[] = [
                            'title' => $note->getTitle(),
                            'note' => $note->getNote(),
                            'created_at' => $note->getCreatedAt()->format('Y-m-d H:i:s'),
                            'updated_at' => $note->getUpdatedAt()->format('Y-m-d H:i:s')
                        ];
                    }
                    return $notes;
                } else {
                    return [];
                }
            } else {
                throw new EntityNotFoundException('Projeto não encontrado!');
            }
            //Eloquent
            //return $this->repository->findWhere(['project_id' => $id]);
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
     * @param  integer $noteId
     * @return \Illuminate\Http\Response
     */

    public function show($id, $noteId) {
        try {
            $DQL = <<<EOD
            SELECT pn
            FROM \CodeProject\Entities\Doctrine\Project p
              INNER JOIN \CodeProject\Entities\Doctrine\ProjectNote pn
            WHERE
                  pn.project = p
              AND pn.id = ?1
              AND p.id = ?2
EOD;
            $projectNotes = $this->em->createQuery($DQL)->setParameter(1, $noteId)
                                                        ->setParameter(2, $id)
                                                        ->getResult();
            if ($projectNotes) {
                return $projectNotes;
            } else {
                throw new EntityNotFoundException('Nota não encontrada!');
            }

            //return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
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
            $projectNote = $this->repository->find($id);
            if ($projectNote) {
                $this->em->remove($projectNote);
                $this->em->flush();
            } else {
                throw new EntityNotFoundException('Nota não encontrada!');
            }
            //$this->repository->delete($id);
            $resp['success'] = TRUE;
            $resp['result'] = 'Nota excluída com sucesso!';

        } catch (ModelNotFoundException $e) {
            $resp['success'] = FALSE;
            $resp['result'] = 'Nota não encontrada!';
        } catch (\Exception $ex) {
            $resp['success'] = FALSE;
            $resp['result'] = $ex->getMessage();
        }
        return response()->json($resp, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
