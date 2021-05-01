<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    use HasFactory;
    protected $table = "imoveis";
    protected $fillable = ['cidade', 'tipo_imovel', 'avaliacao', 'proprietario'];

    public function rules() {
        return [
            'cidade' => 'required',
            'tipo_imovel' => 'required',
            'id_proprietario' => 'required'
        ];
    }


    public function feedback () {
        return [
            'required' => "O campo :attribute é obrigatório"
        ];
    }
}
