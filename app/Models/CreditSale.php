<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditSale extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'vendas_creditos';

    protected $fillable = [
        'user_id', // <-- esse é o campo correto
        'valor',
        'quantidade_creditos',
        'tipo_transacao',
        'status',
        'data_venda',
        'observacao',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'quantidade_creditos' => 'decimal:2',
        'data_venda' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
