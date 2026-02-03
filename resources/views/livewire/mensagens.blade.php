<div wire:poll.2s class="space-y-2">
    @foreach($mensagens as $mensagem)
        <div class="p-2 bg-base-200 rounded">
            {{ $mensagem->texto }}
        </div>
    @endforeach
</div>
