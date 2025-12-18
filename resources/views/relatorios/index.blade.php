<x-app-layout>
    <x-slot name="header">Relatórios</x-slot>

    <div class="p-6 max-w-xl">
        <form method="POST" action="{{ route('relatorios.gerar') }}" class="space-y-4">
            @csrf
            <input type="date" name="inicio" class="input input-bordered w-full" required>
            <input type="date" name="fim" class="input input-bordered w-full" required>
            <button class="btn btn-primary">Gerar PDF</button>
        </form>
    </div>
</x-app-layout>
