<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;


      // 👇 Adicione esta linha
      protected $table = 'produtos';


    protected $fillable = [
        'user_id',
        'nome',
        'tecnologia',
        'valor',
        'valor_creditos',
        'estoque_minimo',
        'estoque_maximo',
        'estoque_atual',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'valor_creditos' => 'decimal:2',
        'estoque_minimo' => 'integer',
        'estoque_maximo' => 'integer',
        'estoque_atual' => 'integer',
    ];
}
