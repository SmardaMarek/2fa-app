<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Teorie</span>
                </h2>
            </div>

            {{-- Indikátor postupu krokem ve stylu dashboard widgetu --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="relative flex h-3 w-3 -mt-0.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 1 / 4
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Karta s obsahem - Glassmorphism efekt v dark mode --}}
            <div class="relative bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                {{-- Horní dekorativní neonová linka (odpovídá 25% postupu) --}}
                <div class="absolute top-0 left-0 h-1 w-1/4 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>

                <div class="p-8 md:p-12">
                    @if(View::exists($contentView))
                        <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-600 dark:text-slate-300">
                            @include($contentView)
                        </div>
                    @else
                        {{-- Varování o chybějícím obsahu --}}
                        <div class="p-5 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl flex gap-4 items-start">
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

                {{-- Patička karty s CTA --}}
                <div class="bg-gray-50 dark:bg-slate-800/60 px-8 py-6 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center mt-auto gap-4">
                    <p class="text-gray-500 dark:text-slate-400 text-sm text-center md:text-left">
                        Po prostudování teorie si ukážeme reálný kód.
                    </p>

                    <form action="{{ route('module.theory.complete', $module) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-auto relative inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-xl font-bold text-sm text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 group/btn overflow-hidden shadow-lg shadow-indigo-500/30 dark:shadow-indigo-500/20">
                            <span class="relative z-10 flex items-center gap-2">
                                Rozumím, přejít k ukázce kódu
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
