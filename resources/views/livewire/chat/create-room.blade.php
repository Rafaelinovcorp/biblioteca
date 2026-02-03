<div class="p-4 space-y-4 max-w-md">

    <h2 class="font-bold text-lg">Criar Sala</h2>

    {{-- Nome da sala --}}
    <input
        type="text"
        wire:model.defer="name"
        placeholder="Nome da sala"
        class="input input-bordered w-full"
    >

    @error('name')
        <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror

    {{-- Utilizadores --}}
    <div class="space-y-1 max-h-48 overflow-y-auto">
        @foreach($allUsers as $user)
            <label class="flex items-center gap-2 text-sm">
                <input
                    type="checkbox"
                    wire:model="users"
                    value="{{ $user->id }}"
                    class="checkbox checkbox-sm"
                >
                {{ $user->name }}
            </label>
        @endforeach
    </div>

    @error('users')
        <p class="text-sm text-red-500">{{ $message }}</p>
    @enderror

    <button wire:click="create" class="btn btn-primary w-full">
        Criar Sala
    </button>

</div>
