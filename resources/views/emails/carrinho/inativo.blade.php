@component('mail::message')
# Ainda tem livros no carrinho 📚

Notámos que adicionou livros ao seu carrinho mas ainda não concluiu a encomenda.

Se precisar de ajuda, estamos aqui para si.

@component('mail::button', ['url' => route('carrinho.index')])
Voltar ao Carrinho
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
