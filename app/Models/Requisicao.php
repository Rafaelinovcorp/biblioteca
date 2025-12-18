<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Requisicao extends Model
{
    protected $table = 'requisicoes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'numero',
        'user_id',
        'livro_id',
        'foto_cidadao',
        'data_inicio',
        'data_fim_previsto',
        'data_fim_real',
        'dias_decorridos',
        'dias_atraso',
        'penalizacao',
        'estado',
    ];

       protected $attributes = [
        'estado' => 'pendente',
    ];


    protected $casts = [
        'data_inicio' => 'date',
        'data_fim_previsto' => 'date',
        'data_fim_real' => 'date',
    ];

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
