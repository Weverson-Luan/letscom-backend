<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEntrega extends Model
{
    use HasFactory;

    protected $table = 'tipos_entrega';

    protected $fillable = [
        'user_id',
        'user_cliente',
        'endereco_entrega_id',
        'tipo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function endereco()
    {
        return $this->belongsTo(EnderecoEntrega::class, 'endereco_entrega_id');
    }
}
