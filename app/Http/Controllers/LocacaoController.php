<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use Illuminate\Http\Request;

class LocacaoController extends Controller {

    protected $locacao;

    public function __construct (Locacao $locacao) {
        $this->locacao = $locacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json($this->locacao->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate($this->locacao->rules(), $this->locacao->feedback());

        $locacao = $this->locacao->create([
            'cliente_id' => $request->get('cliente_id'),
            'data_inicio_locacao' => $request->get('data_inicio_locacao'),
            'data_saida_previsao' => $request->get('data_saida_previsao'),
            'data_saida_locacao' => $request->get('data_saida_locacao'),
            'imovel_id' => $request->get('imovel_id')
        ]);

        return response()->json($locacao, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $locacao = $this->locacao->find($id);

        if ($locacao) {
            return reseponse()->json($locacao, 200);
        } else {
            return response()->json(['msg_error' => "O ID informado não está associado a nenhuma locação"]);
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
        $locacao = $this->locacao->find($id);
        
        if ($locacao == null) {
            return response()->json(['msg_error' => "ID informado não está associado a informação de nenhuma locacao"]);
        } else {

            // Se o tipo de requisição for PATCH
            if ($request->method() === 'PATCH') {
                $regrasPatch = array();

                // Percorrendo todas as regras definidas no Modelo Users
                foreach($locacao->rules() as $input => $regra) {
                    
                    // Verificando se o input existe na requisição que foi enviada para o backend
                    if (array_key_exists($input, $request->all())) { 
                        // Se exisitir, adicionaremos as regras ao regrasPatch
                        $regrasPatch[$input] = $regra;
                    }
                }

                // Aplicando as regrasPatch
                $request->validate($regrasPatch, $locacao->feedback());
            
            } else { // Se o tipo da requisição for PUT
                $request->validate($locacao->rules(), $locacao->feedback());
            }

            $locacao->fill($request->all()); 
            $locacao->save();
            return response()->json($locacao, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $locacao = $this->locacao->find($id);

        if ($locacao) {
            $locacao->delete();
            return response()->json(['msg_success' => 'locacao deletada com sucesso']);
        } else {
            return response()->json(['msg_error' => 'locacao não deletada. ID não está associado com nenhuma locacao']);
        }
    }
}
