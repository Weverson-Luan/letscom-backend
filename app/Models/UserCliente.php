<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCliente extends Model
{
    use HasFactory;

    protected $table = 'users_cliente';

    protected $fillable = [
        'user_id',
        'email',
        'nome',
        'documento',
        'ativo',
    ];

    // Relacionamento com o usuário (opcional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
