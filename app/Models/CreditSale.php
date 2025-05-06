<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'valor',
        'quantidade_creditos',
        'status',
        'data_venda'
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