<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remessa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'remessas';

    protected $fillable = [
        'cliente_id',
        'user_id_executor',
        'user_id_solicitante_remessa',
        'modelo_tecnico_id',
        'tecnologia_id',
        'total_solicitacoes',
        'situacao',
        'status',
        'observacao',
        'data_remessa',
        'data_inicio_producao',
        'posicao'
    ];

    protected $casts = [
        'data_remessa' => 'datetime',
        'data_inicio_producao' => 'datetime',
    ];

    // 🔗 Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_user_id');
    }

    public function solicitanteRemessa()
    {
        return $this->belongsTo(UsersSolicitanteRemessa::class, 'solicitante_remessa_user_id');
    }


    public function modeloTecnico()
    {
        //defina um relacionamento inverso de um para um ou de muitos.
        return $this->belongsTo(ModeloTecnico::class);
    }

    public function tecnologia()
    {
        //defina um relacionamento inverso de um para um ou de muitos.
        return $this->belongsTo(Tecnologias::class);
    }

    public function items()
    {
        return $this->hasMany(RemessaItem::class);
    }
}
