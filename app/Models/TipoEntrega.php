<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TipoEntrega extends Model
{
    use HasFactory;

    protected $table = 'tipos_entrega';

    protected $fillable = [
        'tipo',
        'ativo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id')
            ->withTimestamps();
    }


    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'tipo_entrega_user', 'tipo_entrega_id', 'cliente_id')
            ->withTimestamps();
    }
};
