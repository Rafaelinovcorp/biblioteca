@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 text-center">
    <h1 class="text-3xl font-bold mb-4">✅ Pagamento efetuado!</h1>

    <p class="mb-6">
        A sua encomenda foi paga com sucesso.
    </p>

    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        Voltar ao início
    </a>
</div>
@endsection
