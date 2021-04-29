<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::apiResource('/usuarios', 'App\Http\Controllers\UserController');

// Rotas de Uso
Route::prefix('/services')->middleware('jwt-authenticate')->group(function () {
    
    // Rotas com prefixos /service  -> Necessário estar autenticado para acessar essas rotas
    Route::apiResource('/imovel', 'App\Http\Controllers\ImovelController');
    Route::apiResource('/locacao', 'App\Http\Controllers\LocacaoController');
    Route::apiResource('/comentarios', 'App\Http\Controllers\ComentarioController');
    Route::apiResource('/especificacaoimovel', 'App\Http\Controllers\EspecificacoesImovelController');


});

// Rotas relacionadas a autenticação
Route::middleware('jwt-authenticate')->group(function () {
    
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('/me', 'App\Http\Controllers\AuthController@me');

});