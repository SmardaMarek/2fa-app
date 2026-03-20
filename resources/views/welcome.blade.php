<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'MFA Výuka') }} - Interaktivní kurz vícefaktorového ověřování</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="antialiased bg-gray-950 text-gray-100 min-h-screen flex flex-col font-['Figtree'] selection:bg-indigo-500 selection:text-white">

<header class="w-full bg-gray-900 border-b border-gray-800 py-4 px-6 sm:px-8 lg:px-12 flex justify-between items-center shadow-sm">
    <div class="flex items-center">
        <a href="/">
            <x-application-logo variant="middle" class="w-20 h-20 fill-current text-gray-500" />
        </a>
        <span class="ml-3 font-bold text-xl tracking-tight">MFA app</span>
    </div>

    @if (Route::has('login'))
        <nav class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-300 hover:text-indigo-400 transition">
                    Přejít na Dashboard →
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-400 hover:text-gray-200 hidden sm:block">
                    Přihlásit se
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-md hover:bg-indigo-500 transition shadow">
                        Registrovat se
                    </a>
                @endif
            @endauth
        </nav>
    @endif
</header>

<main class="flex-grow flex items-center justify-center relative overflow-hidden">

    <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-900/20 blur-3xl rounded-full -mr-24 -mt-24"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-900/20 blur-3xl rounded-full -ml-24 -mb-24"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 relative z-10">

        <div class="text-center max-w-3xl mx-auto">
            <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-4 py-1 text-sm font-medium text-indigo-400 ring-1 ring-indigo-500/20 mb-6">
                Interaktivní výuka kyberbezpečnosti
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 leading-tight">
                Pochopte principy<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">
                    Vícefaktorové ověřování
                </span>
            </h1>

            <p class="text-lg text-gray-400 mb-10 max-w-2xl mx-auto">
                Od SMS kódů až po biometrii. Naučte se teoretické základy, prozkoumejte reálné implementace v kódu
                a vyzkoušejte si útoky Man-in-the-Middle v bezpečném simulátoru.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-8 py-3.5 text-base font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-900/40">
                        Pokračovat ve výuce →
                    </a>
                @else
                    <a href="{{ route('register') }}"
                       class="px-8 py-3.5 text-base font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-900/40">
                        Registrovat se
                    </a>

                    <a href="{{ route('login') }}"
                       class="px-8 py-3.5 text-base font-semibold text-gray-200 bg-gray-800 border border-gray-700 rounded-lg hover:bg-gray-700 transition">
                        Přihlásit se
                    </a>
                @endauth
            </div>
        </div>

        <div class="mt-20 grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-indigo-500/40 transition">
                <h3 class="text-lg font-bold mb-2">Teorie & Principy</h3>
                <p class="text-gray-400 text-sm">
                    Jak jednotlivé metody MFA fungují, jejich výhody, slabiny a typické chyby.
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-indigo-500/40 transition">
                <h3 class="text-lg font-bold mb-2">Ukázky kódu</h3>
                <p class="text-gray-400 text-sm">
                    Reálné implementace zabezpečení i zranitelností v PHP, Pythonu a JavaScriptu.
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl hover:border-red-500/40 transition">
                <h3 class="text-lg font-bold mb-2">Simulace útoků</h3>
                <p class="text-gray-400 text-sm">
                    Zachytávejte kódy, obcházejte ochranu a pochopte, proč některé MFA selhávají.
                </p>
            </div>
        </div>

    </div>
</main>

<footer class="border-t border-gray-800 py-8 text-center text-sm text-gray-500">
    © {{ date('Y') }} Marek Šmarda — vytvořeno v rámci dimplové práce
</footer>

</body>
</html>
