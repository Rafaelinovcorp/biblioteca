<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Requisicao;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequisicaoConfirmadaMail;

class SendRequisicaoReminders extends Command
{
    protected $signature = 'requisicoes:reminders';
    protected $description = 'Enviar lembrete de entrega de livros';

    public function handle()
    {
        $requisicoes = Requisicao::whereDate(
            'data_fim_previsto',
            now()->addDay()->toDateString()
        )->whereIn('estado', ['pendente','confirmado'])->get();

        foreach ($requisicoes as $req) {
            Mail::to($req->user->email)
                ->send(new RequisicaoConfirmadaMail($req));
        }

        return Command::SUCCESS;
    }
}
