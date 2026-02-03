<div class="flex flex-col h-full">

    {{-- Header --}}
    <div class="p-4 border-b border-base-300 font-semibold">
        Conversa #{{ $conversation->id }}
    </div>

    {{-- Messages --}}
    <div class="flex-1 p-4 space-y-3 overflow-y-auto">
        @foreach ($messages as $msg)
            <div class="flex gap-3">
                <img src="{{ $msg->user->profile_photo_url }}"
                     class="w-7 h-7 rounded-full" />

                <div>
                    <div class="text-sm font-medium">
                        {{ $msg->user->name }}
                        <span class="text-xs text-gray-400">
                            {{ $msg->created_at->format('H:i') }}
                        </span>
                    </div>
                    <div class="text-sm">
                        {{ $msg->content }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Input --}}
    <div class="p-4 border-t border-base-300">
        <form wire:submit.prevent="send" class="flex gap-2">
            <input
                wire:model="message"
                type="text"
                placeholder="Escreve uma mensagem…"
                class="input input-bordered w-full"
            />
            <button class="btn btn-primary">Enviar</button>
        </form>
    </div>

</div>
