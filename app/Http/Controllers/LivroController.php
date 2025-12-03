<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Editora;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    /**
     * Gera um filename seguro a partir do título.
     * Usa slug + timestamp para evitar colisões.
     */
    protected function pdfFilenameFromTitle(string $title, string $extension = 'pdf'): string
    {
        $slug = Str::slug(substr($title, 0, 200));
        return $slug . '-' . time() . '.' . $extension;
    }

    public function index(Request $request)
    {
        $query = Livro::with(['autores', 'editora']);

        if ($request->filled('nome')) {
            $nome = trim($request->input('nome'));

            // normaliza igual ao que usamos para o campo nome_search
            $nomeNormalized = Str::ascii(mb_strtolower($nome));

            // pesquisa por prefixo no campo indexado 'nome_search'
            $query->where('nome_search', 'like', $nomeNormalized . '%');
        }

        if ($request->filled('autor_id')) {
            $autorId = $request->input('autor_id');

            $query->whereHas('autores', function ($q) use ($autorId) {
                $q->where('autores.id', $autorId);
            });
        }

        if ($request->filled('editora_id')) {
            $query->where('editora_id', $request->input('editora_id'));
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->input('preco_min'));
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->input('preco_max'));
        }

        $precoOrder = $request->query('preco_order');
        if (in_array($precoOrder, ['asc', 'desc'])) {
            $query->orderBy('preco', $precoOrder);
        } else {
            $query->orderBy('nome');
        }

        $livros = $query->paginate(10)->withQueryString();

        $autores  = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        return view('livros.index', compact('livros', 'autores', 'editoras', 'precoOrder'));
    }

    public function create()
    {
        $autores  = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        return view('livros.create', compact('autores', 'editoras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'       => 'required|string|max:255',
            'isbn'       => 'required|string|max:255|unique:livros,isbn',
            'ano'        => 'nullable|integer',
            'preco'      => 'nullable|numeric',
            'editora_id' => 'required|exists:editoras,id',

            // vários autores via pivot
            'autores'   => 'required|array',
            'autores.*' => 'exists:autores,id',

            // PDF opcional
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ]);

        // cria o livro
        $livro = Livro::create([
            'nome'       => $validated['nome'],
            'isbn'       => $validated['isbn'],
            'ano'        => $validated['ano'] ?? null,
            'preco'      => $validated['preco'] ?? null,
            'editora_id' => $validated['editora_id'],
        ]);

        // associa autores
        $livro->autores()->attach($validated['autores']);

        // guarda PDF se enviado
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = $this->pdfFilenameFromTitle($livro->nome, $extension);

            // guarda em storage/app/public/livros
            $path = $file->storeAs('livros', $filename, 'public');

            $livro->pdf_path = $path;
            $livro->save();
        }

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro criado com sucesso!');
    }

    public function show(Livro $livro)
    {
        $livro->load(['autores', 'editora']);

        return view('livros.show', compact('livro'));
    }

    public function edit(Livro $livro)
    {
        $autores  = Autor::orderBy('nome')->get();
        $editoras = Editora::orderBy('nome')->get();

        $livro->load('autores');

        return view('livros.edit', compact('livro', 'autores', 'editoras'));
    }

    public function update(Request $request, Livro $livro)
    {
        $validated = $request->validate([
            'nome'       => 'required|string|max:255',
            'isbn'       => 'required|string|max:255|unique:livros,isbn,' . $livro->id,
            'ano'        => 'nullable|integer',
            'preco'      => 'nullable|numeric',
            'editora_id' => 'required|exists:editoras,id',

            'autores'   => 'required|array',
            'autores.*' => 'exists:autores,id',

            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $oldNome = $livro->nome;
        $livro->update([
            'nome'       => $validated['nome'],
            'isbn'       => $validated['isbn'],
            'ano'        => $validated['ano'] ?? null,
            'preco'      => $validated['preco'] ?? null,
            'editora_id' => $validated['editora_id'],
        ]);

        $livro->autores()->sync($validated['autores']);

        if ($request->hasFile('pdf')) {
            if (!empty($livro->pdf_path) && Storage::disk('public')->exists($livro->pdf_path)) {
                Storage::disk('public')->delete($livro->pdf_path);
            }

            $file = $request->file('pdf');
            $extension = $file->getClientOriginalExtension();
            $filename = $this->pdfFilenameFromTitle($livro->nome, $extension);
            $path = $file->storeAs('livros', $filename, 'public');

            $livro->pdf_path = $path;
            $livro->save();
        } else {
            if ($oldNome !== $livro->nome && !empty($livro->pdf_path) && Storage::disk('public')->exists($livro->pdf_path)) {
                $oldPath = $livro->pdf_path;
                $extension = pathinfo($oldPath, PATHINFO_EXTENSION) ?: 'pdf';
                $newFilename = $this->pdfFilenameFromTitle($livro->nome, $extension);
                $newPath = 'livros/' . $newFilename;

                Storage::disk('public')->move($oldPath, $newPath);

                $livro->pdf_path = $newPath;
                $livro->save();
            }
        }

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Livro $livro)
    {
        if (!empty($livro->pdf_path) && Storage::disk('public')->exists($livro->pdf_path)) {
            Storage::disk('public')->delete($livro->pdf_path);
        }

        $livro->autores()->detach();
        $livro->delete();

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro apagado com sucesso!');
    }

    public function download(Livro $livro)
    {
        if (empty($livro->pdf_path) || !Storage::disk('public')->exists($livro->pdf_path)) {
            abort(404, 'Ficheiro não encontrado.');
        }

        $extension = pathinfo($livro->pdf_path, PATHINFO_EXTENSION) ?: 'pdf';
        $downloadName = Str::slug($livro->nome) . '.' . $extension;

        return Storage::disk('public')->download($livro->pdf_path, $downloadName);
    }
}
