<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelController extends Controller {

    protected $imovel;

    public function __construct (Imovel $imovel) {
        $this->imovel = $imovel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json($this->imovel->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate($this->imovel->rules(), $this->imovel->feedback());
        
        $imovel = $this->imovel->create([
            'cidade' => $request->get('cidade'),
            'avaliacao' => 0,
            'tipo_imovel' => $request->get('tipo_imovel'),
            'proprietario' => $request->get('id_proprietario')
        ]);

        return response()->json($imovel, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)  {
        $imovel = $this->imovel->find($id);

        if ($imovel) {
            return response()->json($imovel, 200);
        } else {
            return response()->json(['msg_error' => "Nenhum imovel associado a esse ID"]);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id) {
        $imovel = $this->imovel->find($id);
        
        if ($imovel == null) {
            return response()->json(['msg_error' => "ID informado não está associado a nenhum imovel"]);
        } else {

            // Se o tipo de requisição for PATCH
            if ($request->method() === 'PATCH') {
                $regrasPatch = array();

                // Percorrendo todas as regras definidas no Modelo Users
                foreach($imovel->rules() as $input => $regra) {
                    
                    // Verificando se o input existe na requisição que foi enviada para o backend
                    if (array_key_exists($input, $request->all())) { 
                        // Se exisitir, adicionaremos as regras ao regrasPatch
                        $regrasPatch[$input] = $regra;
                    }
                }

                // Aplicando as regrasPatch
                $request->validate($regrasPatch, $imovel->feedback());
            
            } else { // Se o tipo da requisição for PUT
                $request->validate($imovel->rules(), $imovel->feedback());
            }

            $imovel->fill($request->all()); 
            $imovel->save();
            return response()->json($imovel, 200);
        }
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $imovel = $this->imovel->find($id);

        if ($imovel) {
            $imovel->delete();
            return response()->json(['msg_success' => "Imovel removido com sucesso"]);
        } else {
            return response()->json(['msg_error' => "ID informado não está associado a nenhum imovel"]);
        }
    }
}
