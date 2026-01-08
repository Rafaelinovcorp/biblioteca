<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = Log::with('user');

        // 🔍 Pesquisa livre (alteração / módulo)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('alteracao', 'like', '%' . $request->search . '%')
                  ->orWhere('modulo', 'like', '%' . $request->search . '%');
            });
        }

        // 👤 Filtro por utilizador
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // 🧩 Filtro por módulo
        if ($request->filled('modulo')) {
            $query->where('modulo', $request->modulo);
        }

        // 📅 Filtro por data
        if ($request->filled('data')) {
            $query->whereDate('data', $request->data);
        }

        $logs = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $users = User::orderBy('name')->get();
        $modulos = Log::select('modulo')->distinct()->orderBy('modulo')->pluck('modulo');

        return view('logs.index', compact('logs', 'users', 'modulos'));
    }

    public function show(Log $log)
    {
        $log->load('user');

        return view('logs.show', compact('log'));
    }
}
