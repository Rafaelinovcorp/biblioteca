<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Editora extends Model
{
    protected $fillable = ['nome', 'logotipo'];

    protected $casts = [
        'nome' => 'encrypted:string',
        'logotipo' => 'encrypted:string',
    ];

    public function livros()
    {
        return $this->hasMany(Livro::class);
    }
}
