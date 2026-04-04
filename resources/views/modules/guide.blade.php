<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Nastavte si to doma</span>
                </h2>
            </div>

            {{-- Badge Bonus --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="p-1.5 bg-amber-500/10 rounded-lg">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <span class="text-sm font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">
                    Bonus
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Intro box --}}
            <div class="mb-8 relative overflow-hidden bg-amber-500/5 dark:bg-amber-500/10 border-l-4 border-amber-500 rounded-r-2xl p-6 backdrop-blur-md shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-amber-500 rounded-lg text-white shrink-0 mt-1">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div class="text-gray-700 dark:text-slate-300 text-sm leading-relaxed font-medium">
                        <h3 class="text-base font-bold text-amber-900 dark:text-amber-300 uppercase tracking-wider mb-1">
                            Praktický průvodce pro vaše zařízení
                        </h3>
                        <p>
                            Gratulujeme k dokončení modulu! Tento bonusový průvodce vám krok za krokem ukáže, jak si nastavit tuto technologii na vlastním telefonu nebo počítači. Žádné programování — stačí klikat.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Hlavní karta s průvodcem --}}
            <div class="relative bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                {{-- Neonová linka --}}
                <div class="absolute top-0 left-0 h-1 w-full bg-amber-500 shadow-[0_0_10px_rgba(245,158,11,0.5)]"></div>

                <div class="p-8 md:p-12">
                    @if(View::exists($contentView))
                        @include($contentView)
                    @else
                        <div class="p-5 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 rounded-xl flex gap-4 items-start">
                            <svg class="w-6 h-6 text-amber-500 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h3 class="text-amber-800 dark:text-amber-400 font-bold mb-1">Průvodce se připravuje</h3>
                                <p class="text-amber-700 dark:text-amber-500/80 text-sm">
                                    Obsah pro modul <strong class="text-amber-900 dark:text-amber-300">{{ $module->slug }}</strong> bude brzy k dispozici.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Patička --}}
                <div class="bg-gray-50 dark:bg-slate-800/60 px-8 py-6 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center mt-auto gap-4">
                    <p class="text-gray-500 dark:text-slate-400 text-sm text-center md:text-left">
                        Zabezpečte svůj digitální život ještě dnes.
                    </p>

                    <a href="{{ route('dashboard') }}" class="w-full md:w-auto relative inline-flex items-center justify-center px-6 py-3 bg-slate-600 hover:bg-slate-700 dark:bg-slate-700 dark:hover:bg-slate-600 border border-transparent rounded-xl font-bold text-sm text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 shadow-lg">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Zpět na dashboard
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
