<?php

namespace App\Services;

use App\Models\Log;

class LogService
{
    public static function criar(
        string $modulo,
        string $alteracao,
        ?int $objetoId = null
    ): void {
        Log::create([
            'data'      => now()->toDateString(),
            'hora'      => now()->toTimeString(),
            'user_id'   => auth()->id(),
            'modulo'    => $modulo,
            'objeto_id' => $objetoId,
            'alteracao' => $alteracao,
            'ip'        => request()->ip(),
            'browser'   => request()->userAgent(),
        ]);
    }
}
