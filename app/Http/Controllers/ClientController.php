<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Client;
use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use Exception;

class ClientController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        try {
            return Client::create($request->all());
        } catch (Exception $e) {
            return response()->json([
                        'success' => FALSE,
                        'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try {
            return Client::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                        'success' => FALSE,
                        'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try {
            $client = Client::findOrFail($id);
            $input = $request->all();
            $client->fill($input)->save();
            return $client;
        } catch (Exception $e) {
            return response()->json([
                        'success' => FALSE,
                        'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try {
            Client::findOrFail($id)->delete();
            return response()->json([
                        'success' => TRUE,
                        'message' => 'Resource deleted successfuly'
            ]);
        } catch (Exception $e) {
            return response()->json([
                        'success' => FALSE,
                        'message' => $e->getMessage()
            ]);
        }
    }

}
