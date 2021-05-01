<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {

    // Metodo responsável logar o usuário no 'sistema'
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

    // Metodo responsável por realizar logout do usuário no sistema
    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => "Logout realizado com sucesso"], 200);
    }

    // Metodo responsável por realizar um refresh no token do usuário, de modo que sua autenticação não expire com o tempo
    public function refresh() {
        $token = auth('api')->refresh(); // Necessário o client esteja com um token válido
        return response()->json(["novo_token" => $token], 200);
    }

    // Metodo responsável por realizar o envio de informações a respeito do usuário
    public function me() {
        return response()->json(auth()->user());
    }

}
