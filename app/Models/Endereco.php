<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'enderecos';

    protected $fillable = [
        'user_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'ativo',
        'tipo_endereco',
        'nome_responsavel',
        'email',
        'setor',
        'telefone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
