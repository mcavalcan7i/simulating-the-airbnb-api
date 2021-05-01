<?php

namespace App\Http\Controllers;

use App\Models\EspecificacoesImovel;
use Illuminate\Http\Request;

class EspecificacoesImovelController extends Controller {

    protected $especificacoesImovel;

    public function __construct (EspecificacoesImovel $especificacoesImovel) {
        $this->especificacoesImovel = $especificacoesImovel;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response()->json($this->especificacoesImovel->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $request->validate($this->especificacoesImovel->rules(), $this->especificacoesImovel->feedback());

        $ei = $this->especificacoesImovel->create([
            'endereco' => $request->get('endereco'),
            'quantidade_quartos' => $request->get('quantidade_quartos'),
            'preco_diaria' => $request->get('preco_diaria'),
            'imovel_id' => $request->get('imovel_id')
        ]);

        return response()->json($ei, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $ei = $this->especificacoesImovel->find($id);

        if ($ei) {
            return response()->json($ei, 200);
        } else {
            return response()->json(['msg_error' => 'O ID informado não está associado a informação de nenhum imovel']);
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
        $ei = $this->especificacoesImovel->find($id);
        
        if ($ei == null) {
            return response()->json(['msg_error' => "ID informado não está associado a informação de nenhum imovel"]);
        } else {

            // Se o tipo de requisição for PATCH
            if ($request->method() === 'PATCH') {
                $regrasPatch = array();

                // Percorrendo todas as regras definidas no Modelo Users
                foreach($ei->rules() as $input => $regra) {
                    
                    // Verificando se o input existe na requisição que foi enviada para o backend
                    if (array_key_exists($input, $request->all())) { 
                        // Se exisitir, adicionaremos as regras ao regrasPatch
                        $regrasPatch[$input] = $regra;
                    }
                }

                // Aplicando as regrasPatch
                $request->validate($regrasPatch, $ei->feedback());
            
            } else { // Se o tipo da requisição for PUT
                $request->validate($ei->rules(), $ei->feedback());
            }

            $ei->fill($request->all()); 
            $ei->save();
            return response()->json($ei, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $ei = $this->especificacoesImovel->find($id);

        if ($ei) {
            $ei->delete();
            return response()->json(['msg_success' => 'Especificações deletadas com sucesso']);
        } else {
            return response()->json(['msg_success' => 'Nenhuma especificação associada ao ID informado']);
        }

    }
}
