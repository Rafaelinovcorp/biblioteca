<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    public function gerar(Request $request)
    {
        // por agora só para não dar erro
        return back()->with('success', 'Relatório gerado.');
    }
}
