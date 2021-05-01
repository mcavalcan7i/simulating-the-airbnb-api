<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecificacoesImovel extends Model
{
    use HasFactory;
    protected $table = "especificacoes_imoveis";
    protected $fillable = ['endereco', 'quantidade_quartos', 'preco_diaria', 'imovel_id'];


    public function rules () {
        return [
            'endereco' => 'required',
            'quantidade_quartos' => 'required',
            'preco_diaria' => 'required',
            'imovel_id' => 'required'
        ];
    }

    public function feedback () {
        return [
            'required' => "O campo :attribute deve ser informado"
        ];
    }
}
