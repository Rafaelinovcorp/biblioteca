@component('mail::message')
# 📚 Livro disponível para requisição

Olá,

O livro que pediste para acompanhar já se encontra **disponível** na biblioteca.

**Livro:** {{ $livro->titulo ?? $livro->nome }}  
@if($livro->categoria)
**Categoria:** {{ $livro->categoria->nome }}
@endif

Já podes efetuar a requisição através da plataforma.

@component('mail::button', ['url' => route('livros.show', $livro)])
Ver livro
@endcomponent

Obrigado pelo uso do nosso serviço.  
@endcomponent