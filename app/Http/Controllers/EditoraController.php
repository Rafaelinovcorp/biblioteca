<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class EditoraController extends Controller
{
public function index(Request $request)
{
    $query = Editora::query();
    $term = trim($request->query('nome', ''));

    if ($term !== '') {
        $normalized = Str::ascii(mb_strtolower($term));
        $query->where('nome_search', 'like', $normalized . '%');
    }

    $editoras = $query->orderBy('nome')->paginate(10)->withQueryString();
    return view('editoras.index', compact('editoras'));
}

    public function create()
    {
        return view('editoras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'     => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logotipo')) {
            $validated['logotipo'] = $request->file('logotipo')->store('logotipos', 'public');
        }

        Editora::create($validated);

        return redirect()
            ->route('editoras.index')
            ->with('success', 'Editora criada com sucesso.');
    }

    public function edit(Editora $editora)
{
    return view('editoras.edit', compact('editora'));
}


    public function update(Request $request, Editora $editora)
    {
        $validated = $request->validate([
            'nome'     => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logotipo')) {
            $validated['logotipo'] = $request->file('logotipo')->store('logotipos', 'public');
        }

        $editora->update($validated);

        return redirect()
            ->route('editoras.index')
            ->with('success', 'Editora atualizada com sucesso.');
    }

public function destroy(Editora $editora)
{

    if ($editora->livros()->exists()) {
        return redirect()
            ->route('editoras.index')
            ->with('error', 'Não é possível apagar esta editora porque existem livros associados.');
    }

    // Apaga a editora
    $editora->delete();

    return redirect()
        ->route('editoras.index')
        ->with('success', 'Editora apagada com sucesso.');
}



    public function confirmDelete(Editora $editora)
    {
        return view('editoras.confirm-delete', compact('editora')); 
    }
}
