<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RemessaPlanilha extends Model
{
    use HasFactory;

    protected $table = 'remessa_planilhas';

    protected $fillable = [
        'remessa_id',
        'user_id',
        'file_path',
        'tipo',
    ];

    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
