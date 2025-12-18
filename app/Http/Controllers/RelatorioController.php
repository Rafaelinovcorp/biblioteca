@can('admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Relatórios
        </h2>
    </x-slot>

    <div class="p-6 max-w-xl space-y-4">
        <form method="POST"
              action="{{ route('relatorios.gerar') }}"
              class="space-y-4">

            @csrf

            <div>
                <label class="label">Data de início</label>
                <input type="date"
                       name="inicio"
                       class="input input-bordered w-full"
                       required>
            </div>

            <div>
                <label class="label">Data de fim</label>
                <input type="date"
                       name="fim"
                       class="input input-bordered w-full"
                       required>
            </div>

            <button class="btn btn-primary w-full">
                Gerar PDF
            </button>
        </form>
    </div>
</x-app-layout>
@endcan
