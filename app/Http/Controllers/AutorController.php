<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AutorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $autores = Autor::withCount('livros')->paginate(10);

        return view('autores.index', compact('autores'));
    }

    public function create()
    {
        return view('autores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'bibliografia' => 'nullable|string',
            'foto' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('autores', 'public');
        }

        $autor = Autor::create($data);

        LogService::criar(
            'Autores',
            'Criou o autor: ' . $autor->nome,
            $autor->id
        );

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor criado com sucesso.');
    }

    public function show(Autor $autor)
    {
        $autor->load('livros');

        return view('autores.show', compact('autor'));
    }

    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    public function update(Request $request, Autor $autor)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'bibliografia' => 'nullable|string',
            'foto' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('foto')) {
            if ($autor->foto) {
                Storage::disk('public')->delete($autor->foto);
            }

            $data['foto'] = $request->file('foto')->store('autores', 'public');
        }

        $autor->update($data);

        LogService::criar(
            'Autores',
            'Atualizou o autor: ' . $autor->nome,
            $autor->id
        );

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor atualizado com sucesso.');
    }

    public function destroy(Autor $autor)
    {
        if ($autor->foto) {
            Storage::disk('public')->delete($autor->foto);
        }

        $autor->delete();

        LogService::criar(
            'Autores',
            'Eliminou o autor: ' . $autor->nome,
            $autor->id
        );

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor eliminado com sucesso.');
    }
}
