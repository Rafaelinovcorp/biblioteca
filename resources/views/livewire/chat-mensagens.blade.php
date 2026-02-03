<div class="flex flex-col h-full">

    <!-- LISTA DE MENSAGENS -->
 <div
    class="flex-1 overflow-y-auto space-y-2 p-4"
    wire:poll.1s
>
    @foreach($mensagens as $mensagem)
        <div>{{ $mensagem->content }}</div>
    @endforeach
</div>

    <!-- INPUT -->
    <div class="p-3 border-t flex gap-2">
        <input
            type="text"
            wire:model.defer="texto"
            wire:keydown.enter="enviar"
            class="input input-bordered w-full"
            placeholder="Escreve uma mensagem..."
        >

        <button wire:click="enviar" class="btn btn-primary">
            Enviar
        </button>
    </div>

</div>
