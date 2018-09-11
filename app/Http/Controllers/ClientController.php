<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller {

    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var ClientService
     */
    private $service;

    /**
     * ClientController constructor.
     * @param ClientRepository $repository
     * @param ClientService $service
     */
    public function __construct(ClientRepository $repository, ClientService $service) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Doctrine
        return $this->repository->findAll();
        //Eloquent
        //return $this->repository->all();
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
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        return $this->service->update($request->all(), $id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $this->repository->delete($id);
            $resp['success'] = TRUE;
            $resp['result'] = 'Cliente excluído com sucesso!';

        } catch (ModelNotFoundException $e) {
            $resp['success'] = FALSE;
            $resp['result'] = 'Cliente não encontrado!';
        } catch (\Exception $ex) {
            $resp['success'] = FALSE;
            $resp['result'] = $ex->getMessage();
        }
        return response()->json($resp, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
