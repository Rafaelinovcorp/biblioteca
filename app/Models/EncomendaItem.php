<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncomendaItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'encomenda_id',
        'livro_id',
        'preco',
    ];

    public function encomenda()
    {
        return $this->belongsTo(Encomenda::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }
}
