<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSolicitanteRemessa extends Model
{
    use HasFactory;

    protected $table = 'users_solicitantes_remessas';

    protected $fillable = [
        'remessa_id',
        'cliente_id',
        'nome',
        'documento',
        'telefone',
    ];

    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
