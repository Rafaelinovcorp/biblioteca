<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use Illuminate\Http\Request;

class EditoraController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $sort   = $request->query('sort', 'nome');
        $dir    = $request->query('dir', 'asc');

        $query = Editora::query();

        if ($search) {
            $query->where('nome', 'like', "%{$search}%");
        }

        if (in_array($sort, ['nome', 'created_at']) && in_array($dir, ['asc', 'desc'])) {
            $query->orderBy($sort, $dir);
        }

        $editoras = $query->paginate(10)->withQueryString();

        return view('editoras.index', compact('editoras', 'search', 'sort', 'dir'));
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
        return view('editoras.confirm-delete', compact('editora'));
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
