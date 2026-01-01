<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Carrinho;
use Illuminate\Support\Facades\Mail;
use App\Mail\CarrinhoInativoMail;


class CarrinhoInativoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:carrinho-inativo-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

public function handle()
{
   Carrinho::where('updated_at', '<=', now()->subMInute())
    ->whereHas('items') // tem itens no carrinho
    ->with('user')
    ->each(function ($carrinho) {
        if ($carrinho->user && $carrinho->user->email) {
            Mail::to($carrinho->user->email)
                ->send(new CarrinhoInativoMail($carrinho));
        }
    });
}

}
