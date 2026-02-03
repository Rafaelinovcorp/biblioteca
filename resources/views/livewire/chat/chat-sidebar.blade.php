<div class="w-72 border-r border-base-300 bg-base-200 p-4 overflow-y-auto space-y-6">

    {{-- 🔹 SALAS --}}
    <div>
        <div class="flex items-center justify-between mb-2">
            <h2 class="font-semibold">Salas</h2>

            @if($isAdmin)
                <a href="{{ route('chat.create-room') }}"
                   class="text-sm text-primary hover:underline">
                    + Criar
                </a>
            @endif
        </div>

        @forelse ($rooms as $room)
            <div
                wire:click="openRoom({{ $room->id }})"
                class="flex items-center gap-3 p-2 rounded cursor-pointer hover:bg-base-300"
            >
                <img
                    src="{{ $room->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($room->name) }}"
                    class="w-8 h-8 rounded-full"
                />

                <div class="flex-1">
                    <div class="text-sm font-medium">{{ $room->name }}</div>
                    <div class="text-xs text-gray-400">
                        {{ $room->users->count() }} utilizadores
                    </div>
                </div>
            </div>
        @empty
            <div class="text-sm text-gray-400">
                Não estás em nenhuma sala
            </div>
        @endforelse
    </div>

    {{-- 🔹 UTILIZADORES (DM) --}}
    <div>
        <h2 class="font-semibold mb-2">Utilizadores</h2>

        @foreach ($users as $user)
            <div
                wire:click="openDirect({{ $user->id }})"
                class="flex items-center gap-3 p-2 rounded cursor-pointer hover:bg-base-300"
            >
                <img
                    src="{{ $user->profile_photo_url }}"
                    class="w-8 h-8 rounded-full"
                />

                <div class="flex-1">
                    <div class="text-sm font-medium">{{ $user->name }}</div>
                    <div class="text-xs text-gray-400">{{ $user->status }}</div>
                </div>
            </div>
        @endforeach
    </div>

</div>
