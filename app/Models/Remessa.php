<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remessa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'total_creditos',
        'status',
        'data_remessa'
    ];

    protected $casts = [
        'total_creditos' => 'decimal:2',
        'data_remessa' => 'datetime'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(RemessaItem::class);
    }
} 