<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Carrinho extends Model
{
    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CarrinhoItem::class);
    }
     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
