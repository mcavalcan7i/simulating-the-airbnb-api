<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {

    // Rota responsável logar o usuário no 'sistema'
    public function login(Request $request) {
        // Autenticação (email e senha)
        $credentials = $request->all(['email', 'password']);
        
        // Indicando o metodo de autenticação e realizando a tentativa de autenticação através do email e senha
        // Caso a validação dê certo, a variavel token receberá o token de autenticação, caso não receberá false
        $token = auth('api')->attempt($credentials);

        if ($token) { // Usuário autenticado com sucesso
            return response()->json(['token' => $token], 200);
        } else { // Erro na autenticação
            return response()->json(['msg_error' => 'Usuário ou senha Invalido'], 403);
        }

        // Retornar um json web token
    }

    public function logout() {
        return "logout";
    }

    public function refresh() {
        return "refresh";
    }

    public function me() {
        return "me";
    }

}
