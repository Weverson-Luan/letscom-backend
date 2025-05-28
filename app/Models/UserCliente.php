<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserCliente extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users_cliente';

    protected $fillable = [
        'cliente_id',
        'email',
        'nome',
        'senha',
        'documento',
        'ativo',
    ];

    protected $hidden = ['senha'];

    /**
     * Retorna a senha para autenticação.
     * Laravel espera por padrão o campo "password", então sobrescrevemos.
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    /**
     * Relacionamento com a empresa (cliente principal)
     */
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
