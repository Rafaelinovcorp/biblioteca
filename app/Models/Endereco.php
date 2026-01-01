<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'rua',
        'codigo_postal',
        'cidade',
        'pais',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
