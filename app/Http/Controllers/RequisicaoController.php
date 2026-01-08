<?php

namespace App\Http\Controllers;

use App\Models\Requisicao;
use App\Models\Livro;
use App\Models\AlertaLivro;
use App\Mail\LivroDisponivelMail;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RequisicaoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $requisicoes = Requisicao::with(['livro', 'user'])
                ->latest()
                ->paginate(20);
        } else {
            $requisicoes = Requisicao::where('user_id', $user->id)
                ->with('livro')
                ->latest()
                ->paginate(20);
        }

        return view('requisicoes.index', compact('requisicoes'));
    }

    public function create()
    {
        $livros = Livro::where('estado', 'disponivel')->get();

        return view('requisicoes.create', compact('livros'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'livro_id' => 'required|exists:livros,id',
        ]);

        $livro = Livro::findOrFail($request->livro_id);

        if ($livro->estado !== 'disponivel') {
            return back()->withErrors([
                'livro_id' => 'Este livro não está disponível.',
            ]);
        }

        if (
            $user->requisicoes()
                ->whereIn('estado', ['pendente', 'confirmado', 'devolucao_pedida'])
                ->count() >= 3
        ) {
            return back()->withErrors([
                'limite' => 'Já tens 3 livros requisitados em simultâneo.',
            ]);
        }

        $requisicao = Requisicao::create([
            'user_id' => $user->id,
            'livro_id' => $livro->id,
            'estado' => 'pendente',
            'data_inicio' => now(),
            'data_fim_previsto' => now()->addDays(5),
        ]);

        $livro->update(['estado' => 'ocupado']);

        AlertaLivro::where('livro_id', $livro->id)
            ->update(['notificado' => false]);

        LogService::criar(
            'Requisições',
            'Criou requisição do livro: ' . $livro->nome,
            $requisicao->id
        );

        return redirect()
            ->route('requisicoes.index')
            ->with('success', 'Requisição criada com sucesso.');
    }

    public function show(Requisicao $requisicao)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $requisicao->user_id !== $user->id) {
            abort(403);
        }

        $requisicao->load(['livro', 'user', 'review']);

        return view('requisicoes.show', compact('requisicao'));
    }

    // =========================
    // ADMIN
    // =========================

    public function confirmar(Requisicao $requisicao)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($requisicao->estado !== 'pendente') {
            return back()->withErrors('Só é possível confirmar requisições pendentes.');
        }

        $requisicao->update(['estado' => 'confirmado']);

        LogService::criar(
            'Requisições',
            'Confirmou requisição',
            $requisicao->id
        );

        return back()->with('success', 'Requisição confirmada.');
    }

    public function negar(Requisicao $requisicao)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($requisicao->estado !== 'pendente') {
            return back()->withErrors('Só é possível negar requisições pendentes.');
        }

        $requisicao->update(['estado' => 'cancelado']);
        $requisicao->livro->update(['estado' => 'disponivel']);

        $this->notificarLivroDisponivel($requisicao->livro);

        LogService::criar(
            'Requisições',
            'Negou requisição',
            $requisicao->id
        );

        return back()->with('success', 'Requisição negada.');
    }

    public function aceitarDevolucao(Requisicao $requisicao)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($requisicao->estado !== 'devolucao_pedida') {
            return back()->withErrors('Não existe pedido de devolução.');
        }

        $agora = now();

        $diasDecorridos = $requisicao->data_inicio->diffInDays($agora);
        $diasAtraso = max(
            0,
            $requisicao->data_fim_previsto->diffInDays($agora, false)
        );

        $requisicao->update([
            'estado' => 'entregue',
            'data_fim_real' => $agora,
            'dias_decorridos' => $diasDecorridos,
            'dias_atraso' => $diasAtraso,
            'penalizacao' => $diasAtraso * 1,
        ]);

        $requisicao->livro->update(['estado' => 'disponivel']);

        $this->notificarLivroDisponivel($requisicao->livro);

        LogService::criar(
            'Requisições',
            'Aceitou devolução da requisição',
            $requisicao->id
        );

        return back()->with('success', 'Devolução aceite com sucesso.');
    }

    // =========================
    // CIDADÃO
    // =========================

    public function pedirDevolucao(Requisicao $requisicao)
    {
        $user = Auth::user();

        abort_if($requisicao->user_id !== $user->id, 403);

        if ($requisicao->estado !== 'confirmado') {
            return back()->withErrors('Só podes pedir devolução de requisições confirmadas.');
        }

        $requisicao->update(['estado' => 'devolucao_pedida']);

        LogService::criar(
            'Requisições',
            'Pediu devolução da requisição',
            $requisicao->id
        );

        return back()->with('success', 'Pedido de devolução enviado.');
    }

    public function cancelar(Requisicao $requisicao)
    {
        $user = Auth::user();

        abort_if($requisicao->user_id !== $user->id, 403);

        if ($requisicao->estado !== 'pendente') {
            return back()->withErrors('Só podes cancelar requisições pendentes.');
        }

        $requisicao->update(['estado' => 'cancelado']);
        $requisicao->livro->update(['estado' => 'disponivel']);

        $this->notificarLivroDisponivel($requisicao->livro);

        LogService::criar(
            'Requisições',
            'Cancelou a própria requisição',
            $requisicao->id
        );

        return back()->with('success', 'Requisição cancelada.');
    }

    // =========================
    // DOWNLOAD
    // =========================

    public function download(Requisicao $requisicao)
    {
        $user = Auth::user();

        abort_if($requisicao->user_id !== $user->id, 403);

        if (!in_array($requisicao->estado, ['confirmado', 'devolucao_pedida'])) {
            abort(403, 'Download não disponível neste estado.');
        }

        $livro = $requisicao->livro;

        if (!$livro->pdf_path || !Storage::exists($livro->pdf_path)) {
            abort(404, 'PDF não encontrado.');
        }

        return Storage::download(
            $livro->pdf_path,
            Str::slug($livro->nome) . '.pdf'
        );
    }

    // =========================
    // ALERTAS
    // =========================

    private function notificarLivroDisponivel(Livro $livro): void
    {
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
}
