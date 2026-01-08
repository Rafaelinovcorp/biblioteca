<?php

namespace App\Http\Controllers;

use App\Models\Editora;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditoraController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $editoras = Editora::withCount('livros')
            ->orderBy('nome')
            ->paginate(10);

        return view('editoras.index', compact('editoras'));
    }

    public function create()
    {
        return view('editoras.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logotipo')) {
            $data['logotipo'] = $request->file('logotipo')->store('editoras', 'public');
        }

        $editora = Editora::create($data);

        LogService::criar(
            'Editoras',
            'Criou a editora: ' . $editora->nome,
            $editora->id
        );

        return redirect()
            ->route('editoras.index')
            ->with('success', 'Editora criada com sucesso.');
    }

    public function show(Editora $editora)
    {
        $editora->load('livros');

        return view('editoras.show', compact('editora'));
    }

    public function edit(Editora $editora)
    {
        return view('editoras.edit', compact('editora'));
    }

    public function update(Request $request, Editora $editora)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'logotipo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('logotipo')) {
            if ($editora->logotipo) {
                Storage::disk('public')->delete($editora->logotipo);
            }

            $data['logotipo'] = $request->file('logotipo')->store('editoras', 'public');
        }

        $editora->update($data);

        LogService::criar(
            'Editoras',
            'Atualizou a editora: ' . $editora->nome,
            $editora->id
        );

        return redirect()
            ->route('editoras.index')
            ->with('success', 'Editora atualizada com sucesso.');
    }

    public function destroy(Editora $editora)
    {
        if ($editora->logotipo) {
            Storage::disk('public')->delete($editora->logotipo);
        }

        $editora->delete();

        LogService::criar(
            'Editoras',
            'Eliminou a editora: ' . $editora->nome,
            $editora->id
        );

        return redirect()
            ->route('editoras.index')
            ->with('success', 'Editora eliminada com sucesso.');
    }
}
