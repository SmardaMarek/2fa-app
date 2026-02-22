<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Implementace</span>
                </h2>
            </div>

            {{-- Indikátor postupu krokem --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500"></span>
                    <span class="relative flex h-3 w-3 -mt-0.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 2 / 4
                </span>
            </div>
        </div>
    </x-slot>

    {{-- Highlight.js CSS - Atom One Dark --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                {{-- Neonová linka progresu (50%) --}}
                <div class="absolute top-0 left-0 h-1 w-1/2 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>

                {{-- Úvodní text k implementaci --}}
                <div class="p-8 border-b border-gray-100 dark:border-slate-700/50 bg-gray-100/80 dark:bg-slate-800/20">
                    <div class="flex items-center gap-3 mb-6 text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                        <h3 class="text-lg font-bold uppercase tracking-tight tracking-wider">Jak to funguje pod kapotou?</h3>
                    </div>

                    {{-- Sjednoceno na nejvyšší čitelnost: text-gray-800 pro light a slate-200 pro dark --}}
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-800 dark:text-slate-200 leading-relaxed font-medium">
                        @if(View::exists($contentView))
                            @include($contentView)
                        @else
                            {{-- Varování o chybějícím obsahu --}}
                            <div class="p-5 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl flex gap-4 items-start not-prose">
                                <svg class="w-6 h-6 text-amber-500 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <h3 class="text-amber-800 dark:text-amber-400 font-bold mb-1">Chybí výukový obsah</h3>
                                    <p class="text-amber-700 dark:text-amber-500/80 text-sm mb-3">
                                        Obsah pro modul <strong class="text-amber-900 dark:text-amber-300">{{ $module->slug }}</strong> zatím nebyl vytvořen.
                                    </p>
                                    <code class="block bg-amber-100 dark:bg-slate-900/50 text-amber-800 dark:text-amber-200/70 px-3 py-2 rounded-lg font-mono text-xs border border-amber-200 dark:border-amber-500/10">
                                        resources/views/modules/content/{{ $module->slug }}.blade.php
                                    </code>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Sekce s kódem --}}
                @if(empty($codeSamples))
                    <div class="p-12 text-center">
                        <svg class="w-12 h-12 text-slate-500 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        <p class="text-slate-500 italic">Pro tento modul zatím nejsou dostupné ukázky kódu.</p>
                    </div>
                @else
                    <div x-data="{ selectedLang: '{{ array_key_first($codeSamples) }}' }" class="flex flex-col">

                        {{-- IDE Tab Bar --}}
                        <div class="flex bg-slate-100 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700/50 px-2 pt-2">
                            @foreach($codeSamples as $language => $code)
                                <button
                                    @click="selectedLang = '{{ $language }}'"
                                    :class="selectedLang === '{{ $language }}'
                                        ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 border-gray-200 dark:border-slate-700/50 border-t border-x rounded-t-lg'
                                        : 'text-gray-500 dark:text-slate-500 hover:text-gray-700 dark:hover:text-slate-300 border-transparent'"
                                    class="py-2.5 px-5 text-xs font-bold uppercase tracking-widest transition-all duration-200 outline-none -mb-[1px]"
                                >
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full" :class="selectedLang === '{{ $language }}' ? 'bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]' : 'bg-slate-400 dark:bg-slate-700'"></span>
                                        {{ $language }}
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        {{-- Code Area --}}
                        <div class="relative bg-slate-50 dark:bg-slate-900/40 min-h-[300px]">
                            {{-- Badge jazyka --}}
                            <div class="absolute top-4 right-4 bg-slate-200 dark:bg-slate-800 text-[10px] text-slate-500 dark:text-slate-400 px-3 py-1 rounded-full font-mono z-10 border border-gray-300 dark:border-slate-700">
                                <span x-text="selectedLang"></span>
                            </div>

                            @foreach($codeSamples as $language => $code)
                                <div x-show="selectedLang === '{{ $language }}'"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     style="display: none;">
                                    <pre class="m-0"><code class="language-{{ $language }} p-8 text-sm leading-relaxed block overflow-x-auto bg-transparent">{{ $code }}</code></pre>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Navigační patička --}}
                <div class="bg-gray-50 dark:bg-slate-800/60 px-8 py-6 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <a href="{{ route('module.theory', ['module' => $module->slug]) }}"
                       class="flex items-center gap-2 text-sm font-bold text-gray-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Zpět na teorii
                    </a>

                    <a href="{{ route($module->getSimulationSetupRoute(), ['module' => $module->slug]) }}"
                       class="relative w-full md:w-auto inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-xl font-bold text-sm text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 group/btn overflow-hidden shadow-lg shadow-indigo-500/30 dark:shadow-indigo-500/20">
                        <span class="relative z-10 flex items-center gap-2 text-xs uppercase tracking-widest">
                            Vyzkoušet v simulátoru
                            <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
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

        // Restart highlightu při přepnutí tabu v Alpine.js
        window.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                document.querySelectorAll('pre code').forEach((block) => {
                    hljs.highlightElement(block);
                });
            });
        });
    </script>
</x-app-layout>
