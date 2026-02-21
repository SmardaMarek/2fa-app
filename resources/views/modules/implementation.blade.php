<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-400 leading-tight">
                {{ $module->title }} - Implementace
            </h2>
            <div class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                Krok 2/4
            </div>
        </div>
    </x-slot>

    {{-- Highlight.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">

                <div class="p-6 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-medium text-gray-900">Jak to funguje pod kapotou?</h3>
                    @if(View::exists($contentView))
                        @include($contentView)
                    @else
                        <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">
                            ⚠️ Úvodní text pro modul zatím nebyl vytvořen.
                        </div>
                    @endif
                </div>

                {{-- Pokud nejsou žádné ukázky, zobrazíme info --}}
                @if(empty($codeSamples))
                    <div class="p-6 text-center text-gray-500 italic">
                        Pro tento modul zatím nejsou dostupné ukázky kódu.
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
                                    {{-- 'language-X' třída zajistí správné obarvení --}}
                                    <pre class="m-0"><code class="language-{{ $language }} p-6 text-sm leading-relaxed block overflow-x-auto">{{ $code }}</code></pre>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('module.theory', ['module' => $module->slug]) }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Zpět na teorii
                    </a>

                    <a href="{{ route($module->getSimulationSetupRoute(), ['module' => $module->slug]) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition ease-in-out duration-150 shadow-md">
                        Vyzkoušet v simulátoru
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
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
