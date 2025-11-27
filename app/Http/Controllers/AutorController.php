<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AutorController extends Controller
{
    /**
     * Lista todos os autores.
     */
    public function index()
    {
        // se quiseres, podes trocar por paginate()
        $autores = Autor::orderBy('nome')->get();

        return view('autores.index', compact('autores'));
    }

    /**
     * Mostra o formulário de criação.
     */
    public function create()
    {
        return view('autores.create');
    }

    /**
     * Guarda um novo autor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

            $fotoPath = null;

            
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('autores', 'public');
            }

        Autor::create([
            'nome' => $request->nome,
            'foto' => $fotoPath,
        ]);

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor criado com sucesso!');
    }

    /**
     * Mostra um autor específico.
     */
    public function show(Autor $autor)
    {
        return view('autores.show', compact('autor'));
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(Autor $autor)
    {
        return view('autores.edit', compact('autor'));
    }

    /**
     * Atualiza um autor.
     */
   public function update(Request $request, Autor $autor)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $autor->nome = $request->nome;

    // Se foi enviada uma nova foto
    if ($request->hasFile('foto')) {
        // Apagar foto antiga (se existir)
        if ($autor->foto) {
            Storage::disk('public')->delete($autor->foto);
        }

        // Guardar nova foto
        $path = $request->file('foto')->store('autores', 'public');
        $autor->foto = $path;
    }

    $autor->save();

    return redirect()
        ->route('autores.index')
        ->with('success', 'Autor atualizado com sucesso!');
}

    /**
     * Apaga um autor.
     */
    public function destroy(Autor $autor)
    {
        $autor->delete();

        return redirect()
            ->route('autores.index')
            ->with('success', 'Autor apagado com sucesso!');
    }

    public function confirmDelete(Autor $autor)
    {
        return view('autores.confirm-delete', compact('autor'));
    }
}
