<?php
namespace App\Http\Controllers;

use App\Models\AlertaLivro;
use Illuminate\Http\Request;

class AlertaLivroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'livro_id' => 'required|exists:livros,id'
        ]);

        AlertaLivro::firstOrCreate([
            'user_id' => auth()->id(),
            'livro_id' => $request->livro_id,
        ]);

        return back()->with('success', 'Serás avisado quando o livro estiver disponível.');
    }
}
