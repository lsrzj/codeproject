<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller {

    private $repository;

    public function __construct(ClientRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource
     *
     * @param ClientRepositoryEloquent $repository
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        return $this->repository->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \CodeProject\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return $this->repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \CodeProject\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            $client = $this->reposritory->find($id);
            $input = $request->all();
            if ($client) {
                $updated = $client->fill($input)->save();
                if ($updated) {
                    $resp['success'] = TRUE;
                    $resp['result'] = $client;
                } else {
                    $resp['success'] = FALSE;
                    $resp['result'] = 'Nao foi possivel atualizar';
                }
             } else {
                 $resp['success'] = FALSE;
                 $resp['result'] = 'Cliente nao encontrado!';
             }
        } catch (\Exception $ex) {
            $resp['success'] = FALSE;
            $resp['result'] = $ex->getMessage();
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \CodeProject\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            $client = $this->repository->find($id);
            if ($client) {
                $deleted = $client->delete();
                if ($deleted) {
                    $resp['success'] = TRUE;
                    $resp['result'] = $client;
                } else {
                    $resp['success'] = FALSE;
                    $resp['result'] = 'Nao foi possivel excluir';
                }
             } else {
                 $resp['success'] = FALSE;
                 $resp['result'] = 'Cliente nao encontrado!';
             }
        } catch (\Exception $ex) {
            $resp['success'] = FALSE;
            $resp['result'] = $ex->getMessage();
        }
        return response()->json($resp);
    }

}
