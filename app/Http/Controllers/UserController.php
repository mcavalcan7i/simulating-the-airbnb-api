<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {

    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->user->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->user->rules(), $this->user->feedback());
        
        $createUser = $this->user->create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);
        
        return response()->json($createUser, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $user = $this->user->find($id);

        if ($user) {
            return response()->json($user, 200);            
        } else {
            return response()->json(['msg_error' => "Não existe um usuário associado ao ID informado"]);
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
        
        $user = $this->user->find($id);
        
        if ($user == null) {
            return response()->json(['msg_error' => "ID informado não está associado a nenhum usuário"]);
        } else {

            // Se o tipo de requisição for PATCH
            if ($request->method() === 'PATCH') {
                $regrasPatch = array();

                // Percorrendo todas as regras definidas no Modelo Users
                foreach($user->rules() as $input => $regra) {
                    
                    // Verificando se o input existe na requisição que foi enviada para o backend
                    if (array_key_exists($input, $request->all())) { 
                        // Se exisitir, adicionaremos as regras ao regrasPatch
                        $regrasPatch[$input] = $regra;
                    }
                }

                // Aplicando as regrasPatch
                $request->validate($regrasPatch, $user->feedback());
            
            } else { // Se o tipo da requisição for PUT
                $request->validate($user->rules(), $user->feedback());
            }

            $user->fill($request->all()); 
            $user->save();
            return response()->json($user, 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = $this->user->find($id);

        if ($user) {
            $user->delete();
            return response()->json(['msg_success' => 'Usuário deletado com sucesso']);
        } else {
            return response()->json(['msg_error' => "ID informado não está associado a nenhum usuário"]);
        }
    }
}
