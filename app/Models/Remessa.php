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
        'data_fim_producao', // data que finalizou a produção da remessa
        'data_inicio_producao', // data que iniciou a produção da remessa
        'posicao'
    ];

    protected $casts = [
        'data_fim_producao' => 'datetime',
        'data_inicio_producao' => 'datetime',
    ];

    // 🔗 Relacionamentos
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Reponsável por pegar a remessa para produzir
     */
    public function executor()
    {
        return $this->belongsTo(User::class, 'executor_user_id');
    }

    /**
     * Responsável que fez o pedido da remessa
     */
    public function solicitanteRemessa()
    {
        return $this->belongsTo(User::class, 'solicitante_remessa_user_id');
    }

    /**
     * Qual modelo que foi feito a remessa
     */
    public function modeloTecnico()
    {
        //defina um relacionamento inverso de um para um ou de muitos.
        return $this->belongsTo(ModeloTecnico::class);
    }

    /**
     * Qual tecnologia foi pedida para a produção da remessa
     */
    public function tecnologia()
    {
        //defina um relacionamento inverso de um para um ou de muitos.
        return $this->belongsTo(Tecnologias::class);
    }

    /**
     * Quais items estão relacionado com a remessa
     */
    public function items()
    {
        return $this->hasMany(RemessaItem::class);
    }
}
