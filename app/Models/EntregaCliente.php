<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntregaCliente extends Model
{
    use HasFactory;

    protected $table = 'entregas_cliente';

    protected $fillable = [
        'remessa_id',
        'responsavel_recebimento',
        'imagem_protocolo',
        'data_entrega',
    ];

    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }
}
