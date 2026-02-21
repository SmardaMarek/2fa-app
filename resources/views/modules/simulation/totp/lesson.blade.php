<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-400 leading-tight">
                {{ $module->title }} - Prevence proti útoku
            </h2>
            <div class="text-sm text-gray-400">
                Krok 3/4
            </div>
        </div>
    </x-slot>

    {{-- Highlight.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg border-l-4 border-red-500 overflow-hidden border border-slate-200">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-red-600 mb-2">1. Útok typu AitM a absence "Origin Binding"</h3>
                    <p class="mb-4 text-sm text-gray-600">
                        Právě jste si vyzkoušeli útok <strong>Adversary-in-the-Middle (AitM)</strong>. TOTP kód z aplikace (např. Google Authenticator) nemá žádnou vazbu na doménu (tzv. <em>Origin Binding</em>). Kód vygenerovaný pro <code class="bg-gray-100 px-1 rounded">mojebanka.cz</code> je matematicky naprosto stejný jako kód zadaný na podvodné stránce <code class="bg-gray-100 px-1 rounded">mojebamka.cz</code>.
                    </p>



                    <div class="bg-red-50 p-4 rounded-md">
                        <p class="text-sm text-red-800 font-semibold">
                            Obrana uživatele:
                        </p>
                        <p class="text-sm text-red-700 mt-1">
                            Jedinou obranou je maximální pozornost uživatele při kontrole URL adresy. Z technologického hlediska tento problém spolehlivě řeší až standard <strong>FIDO2 (Fyzické klíče a Biometrie)</strong>, který kód kryptograficky sváže s konkrétní doménou.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">

                <div class="p-6 border-b border-gray-100 bg-gray-50 border-l-4 border-indigo-500">
                    <h3 class="text-lg font-bold text-indigo-600 mb-2">2. Replay Attack a zneplatnění kódu vývojářem</h3>
                    <p class="text-sm text-gray-600">
                        Během vašeho útoku jste kód zachytili a obratem odeslali na skutečný server. Pokud by se ve stejném časovém okně pokusil přihlásit skutečný uživatel i vy jako útočník, server by mohl <strong>přijmout kód dvakrát</strong>. Tomuto se říká <em>Replay Attack</em>. Podívejte se, jak se této chybě vyhnout v kódu.
                    </p>
                </div>



                {{-- CODE SAMPLES (Ze tvé druhé ukázky) --}}
                @if(empty($codeSamples))
                    <div class="p-6 text-center text-gray-500 italic">
                        Pro tento modul zatím nejsou dostupné ukázky ochranného kódu.
                    </div>
                @else
                    {{-- Alpine.js: Inicializujeme první klíč jako výchozí --}}
                    <div x-data="{ selectedLang: '{{ array_key_first($codeSamples) }}' }">

                        {{-- Lišta s taby --}}
                        <div class="flex bg-gray-800 border-b border-gray-700 px-4 overflow-x-auto">
                            @foreach($codeSamples as $language => $code)
                                <button
                                    @click="selectedLang = '{{ $language }}'"
                                    :class="selectedLang === '{{ $language }}' ? 'text-white border-indigo-400 bg-gray-700' : 'text-gray-400 border-transparent hover:text-gray-200 hover:bg-gray-700/50'"
                                    class="py-3 px-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all duration-200 outline-none"
                                >
                                    {{ $language }}
                                </button>
                            @endforeach
                        </div>

                        <div class="relative bg-[#F8FAFC] min-h-[300px]">

                            {{-- Dynamický popisek souboru --}}
                            <div class="absolute top-0 right-0 bg-gray-700 text-[10px] text-gray-400 px-3 py-1 rounded-bl font-mono z-10">
                                <span x-text="selectedLang + ' snippet'"></span>
                            </div>

                            {{-- Výpis kódů --}}
                            @foreach($codeSamples as $language => $code)
                                {{-- x-show pouze přepíná CSS display, nemůže rozbít obsah --}}
                                <div x-show="selectedLang === '{{ $language }}'" style="display: none;">
                                    {{-- 'language-X' třída zajistí správné obarvení z Highlight.js --}}
                                    <pre class="m-0 bg-[#282c34]"><code class="language-{{ strtolower($language) }} p-6 text-sm leading-relaxed block overflow-x-auto text-gray-300">{{ $code }}</code></pre>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end items-center">
                    <form action="{{ route('module.simulation.complete', $module) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition ease-in-out duration-150 shadow-md">
                            Dokončit simulaci
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    {{-- Highlight.js scripty --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
        });
    </script>
</x-app-layout>
