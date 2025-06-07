<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'email',
        'senha',
        "ativo",
        'documento',
        'tipo_pessoa',
        "telefone"
    ];

    /**
     * Os atributos que devem ser ocultados para serialização.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
    ];

    /**
     * Obtenha os atributos que devem ser convertidos.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Regras (papel) vinculados a este usuário.
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');

    }

     /**
     * Clientes atendidos por este consultor.
     */
    public function clientes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cliente_consultor', 'consultor_id', 'cliente_id')
                    ->withTimestamps();
    }

    /**
     * Consultores vinculados a este cliente.
     */
    public function consultores(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cliente_consultor', 'cliente_id', 'consultor_id')
                    ->withTimestamps();
    }

    /**
     * Produto vinculado a este cliente.
     */
    public function produtosVinculados(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'produtos_vinculados_usuarios', 'cliente_id', 'produto_id')
                    ->withTimestamps();
    }

    /**
     * Tipo de entrega vinculado a este cliente.
     */
    public function tiposEntrega()
    {
        return $this->belongsToMany(TipoEntrega::class, 'tipo_entrega_user', 'cliente_id', 'tipo_entrega_id')
                    ->withTimestamps();
    }

}
