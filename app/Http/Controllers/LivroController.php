<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;
use App\Models\Categoria;
use App\Models\AlertaLivro;
use App\Mail\LivroDisponivelMail;
use App\Services\LivrosRelacionadosService;
use App\Services\LogService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    public function index(Request $request)
    {
        $query = Livro::query()
            ->with(['editora', 'categoria']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('editora')) {
            $query->where('editora_id', $request->editora);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('preco_min')) {
            $query->where('preco', '>=', $request->preco_min);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        $sort = $request->get('sort', 'nome');
        $direction = $request->get('direction', 'asc');

        if (in_array($sort, ['nome', 'preco'])) {
            $query->orderBy($sort, $direction);
        }

        $livros = $query->paginate(10)->withQueryString();

        $editoras = Editora::orderBy('nome')->get();
        $categorias = Categoria::orderBy('nome')->get();

        return view('livros.index', compact('livros', 'editoras', 'categorias'));
    }

    public function create()
    {
        $editoras = Editora::all();
        $autores = Autor::all();
        $categorias = Categoria::orderBy('nome')->get();

        return view('livros.create', compact('editoras', 'autores', 'categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'isbn' => 'nullable|string|max:50',
            'nome' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'categoria_id' => 'required|exists:categorias,id',
            'bibliografia' => 'nullable|string',
            'capa' => 'nullable|image|max:5120',
            'preco' => 'required|numeric|min:0',
            'pdf' => 'nullable|mimes:pdf|max:20000',
            'autores' => 'nullable|array',
            'autores.*' => 'exists:autores,id',
        ]);

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas', 'public');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdfs', 'public');
        }

        $livro = Livro::create($data);

        if (!empty($data['autores'])) {
            $livro->autores()->sync($data['autores']);
        }

        LogService::criar(
            'Livros',
            'Criou o livro: ' . $livro->nome,
            $livro->id
        );

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro criado.');
    }

    public function show(Livro $livro)
    {
        $livro->load([
            'autores',
            'editora',
            'categoria',
            'requisicoes',
            'reviews.user'
        ]);

        $relacionados = LivrosRelacionadosService::get($livro);

        $alertaJaExiste = false;

        if (auth()->check()) {
            $alertaJaExiste = AlertaLivro::where('user_id', auth()->id())
                ->where('livro_id', $livro->id)
                ->exists();
        }

        return view('livros.show', compact(
            'livro',
            'relacionados',
            'alertaJaExiste'
        ));
    }

    public function edit(Livro $livro)
    {
        $editoras = Editora::all();
        $autores = Autor::all();
        $categorias = Categoria::orderBy('nome')->get();

        return view('livros.edit', compact('livro', 'editoras', 'autores', 'categorias'));
    }

    public function update(Request $request, Livro $livro)
    {
        $estadoAnterior = $livro->estado;

        $data = $request->validate([
            'isbn' => 'nullable|string|max:50',
            'nome' => 'required|string|max:255',
            'editora_id' => 'required|exists:editoras,id',
            'categoria_id' => 'required|exists:categorias,id',
            'bibliografia' => 'nullable|string',
            'capa' => 'nullable|image|max:5120',
            'preco' => 'required|numeric|min:0',
            'estado' => 'required|in:disponivel,requisitado',
            'pdf' => 'nullable|mimes:pdf|max:20000',
            'autores' => 'nullable|array',
            'autores.*' => 'exists:autores,id',
        ]);

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas', 'public');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdfs', 'public');
        }

        $livro->update($data);

        if (array_key_exists('autores', $data)) {
            $livro->autores()->sync($data['autores'] ?? []);
        }

        LogService::criar(
            'Livros',
            'Atualizou o livro: ' . $livro->nome,
            $livro->id
        );

        if ($estadoAnterior === 'requisitado' && $livro->estado === 'disponivel') {

            LogService::criar(
                'Livros',
                'Livro voltou a estar disponível',
                $livro->id
            );

            $alertas = AlertaLivro::where('livro_id', $livro->id)
                ->where('notificado', false)
                ->with('user')
                ->get();

            foreach ($alertas as $alerta) {
                Mail::to($alerta->user->email)
                    ->send(new LivroDisponivelMail($livro));

                $alerta->update(['notificado' => true]);
            }
        }

        return redirect()
            ->route('livros.show', $livro)
            ->with('success', 'Livro atualizado.');
    }

    public function destroy(Livro $livro)
    {
        $livro->delete();

        LogService::criar(
            'Livros',
            'Eliminou o livro: ' . $livro->nome,
            $livro->id
        );

        return redirect()
            ->route('livros.index')
            ->with('success', 'Livro eliminado.');
    }
}
