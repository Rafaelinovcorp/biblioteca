<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    protected $fillable = [
        'data',
        'hora',
        'user_id',
        'modulo',
        'objeto_id',
        'alteracao',
        'ip',
        'browser',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
