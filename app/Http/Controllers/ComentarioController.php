<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller {

    protected $comentario;

    public function __construct (Comentario $comentario) {
        $this->comentario = $comentario;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json($this->comentario->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->comentario->rules(), $this->comentario->feedback());

        $comentario = $this->comentario->create([
            'users_id' => $request->get('users_id'),
            'imovel_id' => $request->get('imovel_id'),
            'comentario' => $request->get('comentario')
        ]);

        return response()->json($comentario, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $comentario = $this->comentario->find($id);

        if ($comentario) {
            return response()->json($comentario);
        } else {
            return response()->json(['msg_error' => 'O ID informado não está associado a nenhum comentário']);
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
        $comentario = $this->comentario->find($id);
        
        if ($comentario == null) {
            return response()->json(['msg_error' => "ID informado não está associado a informação de nenhum imovel"]);
        } else {

            // Se o tipo de requisição for PATCH
            if ($request->method() === 'PATCH') {
                $regrasPatch = array();

                // Percorrendo todas as regras definidas no Modelo Users
                foreach($comentario->rules() as $input => $regra) {
                    
                    // Verificando se o input existe na requisição que foi enviada para o backend
                    if (array_key_exists($input, $request->all())) { 
                        // Se exisitir, adicionaremos as regras ao regrasPatch
                        $regrasPatch[$input] = $regra;
                    }
                }

                // Aplicando as regrasPatch
                $request->validate($regrasPatch, $comentario->feedback());
            
            } else { // Se o tipo da requisição for PUT
                $request->validate($ei->rules(), $comentario->feedback());
            }

            $comentario->fill($request->all()); 
            $comentario->save();
            return response()->json($comentario, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $comentario = $this->comentario->find($id);

        if ($comentario) {
            $comentario->delete();
            return response()->json(['msg_success' => 'Comentário deletado com sucesso']);
        } else {
            return response()->json(['msg_error' => 'Comentário não deletado. ID não está associado com nenhum comentário']);
        }

    }
}
