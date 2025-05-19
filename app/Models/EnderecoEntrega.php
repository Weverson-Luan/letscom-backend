<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoEntrega extends Model
{
    use HasFactory;

    protected $table = 'endereco_entrega';

    protected $fillable = [
        'user_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'nome_responsavel',
        'email',
        'setor',
        'telefone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
