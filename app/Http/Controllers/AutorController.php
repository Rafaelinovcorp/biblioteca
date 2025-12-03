<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;



class AutorController extends Controller
{
    /**
     * Lista todos os autores.
     */
public function index(Request $request)
{
    $query = Autor::query();
    $nome = trim($request->query('nome', ''));

    if ($nome !== '') {
        $nomeNormalized = \Illuminate\Support\Str::ascii(mb_strtolower($nome));
        $query->where('nome_search', 'like', $nomeNormalized . '%');
    }

    $autores = $query->orderBy('nome')->paginate(10)->withQueryString();
    return view('autores.index', compact('autores'));
}


    /**
     * Mostra formulário de criação.
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
     * Mostra detalhes de um autor.
     */
    public function show(Autor $autor)
    {
        // IMPORTANTE: enviar 'autor' (singular)
        return view('autores.show', compact('autor'));
    }

    /**
     * Mostra formulário de edição.
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

        if ($request->hasFile('foto')) {
            // apaga foto antiga se existir
            if ($autor->foto) {
                Storage::disk('public')->delete($autor->foto);
            }

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

    if ($autor->livros()->exists()) {
        return redirect()
            ->route('autores.index')
            ->with('error', 'Não é possível apagar esta autor porque existem livros associados.');
    }

 
    $autor->delete();

    return redirect()
        ->route('autores.index')
        ->with('success', 'autor apagada com sucesso.');
}


    /**
     * Página de confirmação de delete.
     */
    public function confirmDelete(Autor $autor)
    {
        return view('autores.confirm-delete', compact('autor'));
    }

}
