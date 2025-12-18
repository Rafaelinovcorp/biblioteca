<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-200">

    <div class="bg-base-300 shadow">
        <div class="navbar max-w-7xl mx-auto px-6">
            <div class="flex-1">
                <span class="text-lg font-bold">📚 Biblioteca</span>
            </div>
            <div class="flex-none">
                @include('navigation-menu')
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-6 py-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
