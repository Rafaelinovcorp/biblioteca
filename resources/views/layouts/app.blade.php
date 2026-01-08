<!doctype html>
<html lang="pt" >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-200">

    <div class="bg-base-300 shadow">
        <div class="navbar max-w-7xl mx-auto px-6">

            <!-- ESQUERDA -->
            <div class="navbar-start">
                <span class="text-lg font-bold">📚 Biblioteca</span>
            </div>

            <!-- CENTRO (MENU HORIZONTAL) -->
            <div class="navbar-center">
                @include('navigation-menu')
            </div>

            <!-- DIREITA -->
            <div class="navbar-end">
                {{-- espaço reservado --}}
            </div>

        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-6">
        @yield('content')
    </main>

    @livewireScripts
</body>
</html>
