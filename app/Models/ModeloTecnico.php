<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloTecnico extends Model
{
    protected $table = 'modelos_tecnicos';

    protected $fillable = [
        'cliente_id',
        'produto_id',
        'tecnologia_id',
        'tipo_entrega_id',
        'nome_modelo',
        "tipo_furo",
        'posicionamento',
        'tem_furo',
        'tem_carga_foto',
        'tem_dados_variaveis',
        'campo_chave',
        'foto_frente_path',
        'foto_verso_path',
        'observacoes',
    ];


    public function cliente()
    {
        // relacionamento com o cliente o modelo tecnico pertence a um cliente
        return $this->belongsTo(\App\Models\User::class, 'cliente_id');
    }
    public function produto()
    {
        // relacionamento com o produto o modelo tecnico pertence a um produto
        return $this->belongsTo(\App\Models\Product::class, 'produto_id');
    }
    public function tecnologia()
    {
        // relacionamento com a tecnologia o modelo tecnico pertence a uma tecnologia
        return $this->belongsTo(\App\Models\Tecnologias::class, 'tecnologia_id');
    }
    public function camposVariaveis()
    {
        // relacionamento com os campos variaveis o modelo tecnico tem muitos campos variaveis
        return $this->hasMany(\App\Models\ModelosTecnicosCamposVariaveis::class, 'modelo_tecnico_id');
    }

    public function tipoEntrega()
    {
        // relacionamento com modelo para que um modelo possar ter um tipo entrega
        return $this->hasOne(\App\Models\TipoEntrega::class, 'tipo_entrega_id');
    }
}
