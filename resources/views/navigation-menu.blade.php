<nav class="menu menu-horizontal bg-base-200 rounded-box text-sm gap-1">

    <!-- GERAL -->
    <li>
        <a href="{{ route('dashboard') }}">
            📊 Dashboard
        </a>
    </li>

    <!-- CATÁLOGO (todos os users autenticados) -->
    <li tabindex="0">
        <a>
            📚 Catálogo
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                 viewBox="0 0 24 24">
                <path d="M7 10l5 5 5-5z"/>
            </svg>
        </a>
        <ul class="bg-base-100 rounded-box shadow">
            <li><a href="{{ route('livros.index') }}">📚 Livros</a></li>
            <li><a href="{{ route('requisicoes.index') }}">📄 Requisições</a></li>
        </ul>
    </li>

    {{-- APENAS ADMIN --}}
    @if(auth()->check() && auth()->user()->role === 'admin')

        <!-- GESTÃO -->
        <li tabindex="0">
            <a>
                ⚙️ Gestão
                <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                     viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5z"/>
                </svg>
            </a>
            <ul class="bg-base-100 rounded-box shadow">
                <li><a href="{{ route('autores.index') }}">✍️ Autores</a></li>
                <li><a href="{{ route('editoras.index') }}">🏢 Editoras</a></li>
            </ul>
        </li>

        <!-- UTILIZADORES -->
        <li>
            <a href="{{ route('users.index') }}">👤 Utilizadores</a>
        </li>

        <!-- INTEGRAÇÕES -->
        <li>
            <a href="{{ route('google-books.index') }}">🌐 Google Books API</a>
        </li>

    @endif


    @auth
    <li tabindex="0" class="ml-auto">
        <a>
            👤 Conta
            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                 viewBox="0 0 24 24">
                <path d="M7 10l5 5 5-5z"/>
            </svg>
        </a>
        <ul class="bg-base-100 rounded-box shadow">
            <li>
                <a href="{{ route('profile.show') }}">
                    ⚙️ Definições
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left">
                        🚪 Logout
                    </button>
                </form>
            </li>
        </ul>
    </li>
@endauth


</nav>
