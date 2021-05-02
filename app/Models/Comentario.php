<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';
    protected $fillable = ['users_id', 'imovel_id', 'comentario'];
    
    public function rules () {
        return [
            'users_id' => 'required|exists:users,id', 
            'imovel_id' => 'required|exists:imoveis,id',
            'comentario' => 'required'
        ];
    }

    public function feedback () {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }
}
