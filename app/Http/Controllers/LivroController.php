<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use App\Models\Editora;
use App\Models\Autor;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller {
    public function index() {
        $livros = Livro::with('editora','autores')->paginate(12);
        return view('livros.index', compact('livros'));
    }

    public function create() {
        $editoras = Editora::all();
        $autores = Autor::all();
        return view('livros.create', compact('editoras','autores'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'isbn' => 'nullable|string',
            'nome' => 'required|string',
            'editora_id' => 'required|exists:editoras,id',
            'bibliografia' => 'nullable|string',
            'capa' => 'nullable|image|max:5120',
            'preco' => 'nullable|numeric',
            'pdf' => 'nullable|mimes:pdf|max:20000',
            'autores' => 'nullable|array'
        ]);

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas','public');
        }
        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdfs','public');
        }

        $livro = Livro::create($data);
        if (!empty($data['autores'])) {
            $livro->autores()->sync($data['autores']);
        }

        return redirect()->route('livros.index')->with('success','Livro criado.');
    }

    public function show(Livro $livro) {
        $livro->load('autores','editora','requisicoes');
        return view('livros.show', compact('livro'));
    }

    public function edit(Livro $livro) {
        $editoras = Editora::all();
        $autores = Autor::all();
        return view('livros.edit', compact('livro','editoras','autores'));
    }

    public function update(Request $request, Livro $livro) {
        $data = $request->validate([
            'isbn' => 'nullable|string',
            'nome' => 'required|string',
            'editora_id' => 'required|exists:editoras,id',
            'bibliografia' => 'nullable|string',
            'capa' => 'nullable|image|max:5120',
            'preco' => 'nullable|numeric',
            'pdf' => 'nullable|mimes:pdf|max:20000',
            'autores' => 'nullable|array'
        ]);

        if ($request->hasFile('capa')) {
            $data['capa'] = $request->file('capa')->store('capas','public');
        }
        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('pdfs','public');
        }

        $livro->update($data);
        if (!empty($data['autores'])) {
            $livro->autores()->sync($data['autores']);
        }
        return redirect()->route('livros.show', $livro)->with('success','Livro atualizado.');
    }

    public function destroy(Livro $livro) {
        $livro->delete();
        return redirect()->route('livros.index')->with('success','Livro eliminado.');
    }
}
