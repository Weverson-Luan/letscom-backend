<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemessaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'remessa_id',
        'product_id',
        'quantidade',
        'valor_creditos_unitario',
        'valor_creditos_total'
    ];

    protected $casts = [
        'valor_creditos_unitario' => 'decimal:2',
        'valor_creditos_total' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }
} 