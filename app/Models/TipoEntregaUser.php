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
          'tipo_entrega_id',
    ];



}
