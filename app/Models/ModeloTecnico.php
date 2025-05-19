<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeloTecnico extends Model
{
    protected $table = 'modelos_tecnicos';

    protected $fillable = [
        'user_id',
        'produto_id',
        'tecnologia_id',
        'nome_modelo',
        'tipo_entrega',
        'posicionamento',
        'tem_furo',
        'tem_carga_foto',
        'tem_dados_variaveis',
        'campo_chave',
        'foto_frente_path',
        'foto_verso_path',
        'observacoes',
    ];
}

