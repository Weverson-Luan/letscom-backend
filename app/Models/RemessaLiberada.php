<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RemessaLiberada extends Model
{
    use HasFactory;

    protected $table = 'remessa_liberada';

    protected $fillable = [
        'remessa_id',
        'user_id_executor',
        'tipo_entrega_id',
        'observacao',
        'data_entrega',
    ];

    protected $casts = [
        'data_entrega' => 'datetime',
    ];

    // Relacionamentos
    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'user_id_executor');
    }

    public function tipoEntrega()
    {
        return $this->belongsTo(TipoEntrega::class, 'tipo_entrega_id');
    }
}
