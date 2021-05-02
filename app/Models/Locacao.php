<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locacao extends Model {
    use HasFactory;
    protected $table = "locacoes";
    protected $fillable = ['cliente_id', 'data_inicio_locacao', 'data_saida_previsao', 'data_saida_locacao', 'imovel_id'];

    public function rules () {
        return [
            "cliente_id" => "required|exists:users,id",
            "data_inicio_locacao" => "required",
            "data_saida_previsao" => "required",
            "imovel_id" => "required|exists:imoveis,id",
        ];
    }

    public function feedback () {
        return [
            "required" => "O campo :attribute precisa ser informado",
        ];
    }
}
