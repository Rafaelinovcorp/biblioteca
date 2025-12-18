<?php
namespace App\Observers;

use App\Models\Requisicao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisicaoConfirmadaMail;
use App\Mail\RequisicaoNovaAdminMail;
use App\Models\User;

class RequisicaoObserver {
    public function creating(Requisicao $requisicao) {
        DB::transaction(function() use ($requisicao) {
            $last = Requisicao::lockForUpdate()->orderBy('numero','desc')->first();
            $requisicao->numero = $last ? ($last->numero + 1) : 1;
            $requisicao->data_inicio = Carbon::today();
            $requisicao->data_fim_previsto = Carbon::today()->addDays(5);
        });
    }

    public function created(Requisicao $requisicao)
{
    // marcar livro ocupado
    $livro = $requisicao->livro;
    $livro->estado = 'ocupado';
    $livro->save();

    // email para cidadão
    Mail::to($requisicao->user->email)
        ->send(new RequisicaoConfirmadaMail($requisicao));

    // email para admins
    $admins = User::where('role', 'admin')->pluck('email');
    Mail::to($admins)
        ->send(new RequisicaoNovaAdminMail($requisicao));
}

    public function updating(Requisicao $requisicao) {
        if ($requisicao->isDirty('data_fim_real') && $requisicao->data_fim_real) {
            $dias = $requisicao->data_inicio->diffInDays($requisicao->data_fim_real);
            $requisicao->dias_decorridos = $dias;
        }
    }

    public function deleting(Requisicao $requisicao) {
        $livro = $requisicao->livro;
        if ($livro) {
            $other = $livro->requisicoes()->where('estado','!=','entregue')->where('id','!=',$requisicao->id)->exists();
            if (!$other) {
                $livro->estado = 'disponivel';
                $livro->save();
            }
        }
    }
}
