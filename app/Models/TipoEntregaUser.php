<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEntregaUser extends Model
{
    use HasFactory;

    protected $table = 'tipo_entrega_user';

    protected $fillable = [
        'cliente_id',
        'user_executor_id',
        'tipo_entrega_id',
        'observacao'
    ];

    // 🔗 Relacionamentos

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'user_executor_id');
    }

    public function tipoEntrega()
    {
        return $this->belongsTo(TipoEntrega::class, 'tipo_entrega_id');
    }
}
