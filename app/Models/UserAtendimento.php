<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAtendimento extends Model
{
    use HasFactory;

    protected $table = 'users_atendimentos';

    protected $fillable = [
        'user_id',
        'nome',
        'email',
        'documento',
        'telefone',
    ];

    // Relacionamento com usuário (cliente)
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
