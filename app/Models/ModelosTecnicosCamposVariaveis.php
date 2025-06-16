<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelosTecnicosCamposVariaveis extends Model
{
    use HasFactory;

    protected $table = 'modelos_tecnicos_campos_variaveis';

    protected $fillable = [
        'modelo_tecnico_id',
        'nome',
        'obrigatorio',
        'ordem'
    ];

    /**
     * Relacionamento com ModeloTecnico
     */
    public function modelo_tecnico()
    {
        return $this->belongsTo(ModeloTecnico::class, 'modelo_tecnico_id');
    }
}
