<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cpf_cnpj',
        'tipo_pessoa    ',
        'endereco',
        'cep',
        'bairro',
        'cidade',
        'estado',
        'numero',
        'complemento',
    ];
}
