<nav>
    <ul class="menu menu-horizontal bg-base-200 rounded-box text-sm gap-1">

        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('dashboard') }}">📊 Dashboard</a>
        </li>

        <!-- CATÁLOGO -->
        <li class="dropdown dropdown-hover">
            <label class="cursor-pointer">
                📚 Catálogo
                <svg class="inline-block ml-1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                     viewBox="0 0 24 24">
                    <path d="M7 10l5 5 5-5z"/>
                </svg>
            </label>

            <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-44">
                <li><a href="{{ route('livros.index') }}">📚 Livros</a></li>
                <li><a href="{{ route('requisicoes.index') }}">📄 Requisições</a></li>
                <li>
    <a href="{{ route('carrinho.index') }}">
        🛒 Carrinho
    </a>
</li>
 <a href="{{ route('livros.meus') }}"
       class="{{ request()->routeIs('livros.meus') ? 'active' : '' }}">
        📚 Os meus livros
    </a>
            </ul>
        </li>

        @if(auth()->check() && auth()->user()->role === 'admin')

            <!-- GESTÃO -->
            <li class="dropdown dropdown-hover">
                <label class="cursor-pointer">
                    ⚙️ Gestão
                    <svg class="inline-block ml-1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                         viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5z"/>
                    </svg>
                </label>

                <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-44">
                    <li><a href="{{ route('autores.index') }}">✍️ Autores</a></li>
                    <li><a href="{{ route('editoras.index') }}">🏢 Editoras</a></li>
                    <li>
        <a href="{{ route('reviews.pendentes') }}">
            📝 Reviews Pendentes
        </a>
    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('users.index') }}">👤 Utilizadores</a>
            </li>

            <li>
                <a href="{{ route('google-books.index') }}">🌐 Google Books API</a>
            </li>

        @endif

        @auth
            <!-- CONTA -->
            <li class="dropdown dropdown-hover ml-auto">
                <label class="cursor-pointer">
                    👤 Conta
                    <svg class="inline-block ml-1" xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                         viewBox="0 0 24 24">
                        <path d="M7 10l5 5 5-5z"/>
                    </svg>
                </label>

                <ul class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-44">
                    <li><a href="{{ route('profile.show') }}">⚙️ Definições</a></li>
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

    </ul>
</nav>
