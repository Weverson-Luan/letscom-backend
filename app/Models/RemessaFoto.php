<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemessaFoto extends Model
{
    protected $fillable = [
        'remessa_id',
        'cliente_id',
        'file_path',
    ];
}
