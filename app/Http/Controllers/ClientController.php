<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller {

    /**
     * @var ClientRepository
     */
    private $repository;

    public function __construct(ClientRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
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
            $client = $this->repository->find($id);
            if ($client) {
                $input = $request->all();
                $updated = $client->fill($input)->save();
                if ($updated) {
                    $resp['success'] = TRUE;
                    $resp['result'] = $client;
                } else {
                    $resp['success'] = FALSE;
                    $resp['result'] = 'Cliente não pôde ser atualizado';
                }
            } else {
                $resp['success'] = FALSE;
                $resp['result'] = 'Cliente não encontrado';
            }
        } catch (\Exception $e) {
            $resp['success'] = FALSE;
            $resp['result'] = $e->getMessage();
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id Id do usuário a ser apagado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $repository->find($id);
        try {
            $client = $this->repository->find($id);
            if ($client) {
                $client->delete();
                $resp['success'] = TRUE;
                $resp['result'] = 'Apagado com sucesso';
            } else {
                $resp['success'] = FALSE;
                $resp['result'] = 'Cliente não encontrado';
            }
        } catch (\Exception $e) {
            $resp['success'] = FALSE;
            $resp['result'] = $e->getMessage();
        }
        return response()->json($resp);
    }

}
