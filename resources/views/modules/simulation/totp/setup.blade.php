<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Praktické nastavení</span>
                </h2>
            </div>

            {{-- Indikátor postupu krokem --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="relative flex h-3 w-3 -mt-0.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 3 / 4
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                {{-- Neonová linka progresu (75%) --}}
                <div class="absolute top-0 left-0 h-1 w-3/4 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>

                <div class="p-8 md:p-12 text-center">

                    {{-- Instrukce 1 --}}
                    <div class="mb-10">
                        <div class="flex justify-center items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-500/30">1</span>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-slate-100 tracking-tight">Naskenujte QR kód</h3>
                        </div>
                        <p class="text-gray-600 dark:text-slate-300 font-medium max-w-md mx-auto leading-relaxed">
                            Otevřete autentizační aplikaci na svém mobilu a naskenujte tento kód pro sdílení tajného klíče (seedu).
                        </p>
                    </div>

                    {{-- QR Kód --}}
                    <div class="relative inline-block p-6 bg-white rounded-3xl border-4 border-slate-100 dark:border-slate-700/50 shadow-inner mb-8 transition-transform hover:scale-105 duration-300">
                        <img src="{!! $qrCodeSvg !!}"
                             alt="QR Kód pro MFA"
                             class="w-48 h-48 mx-auto"
                        />
                        {{-- Ochranný overlay pro "cyber" pocit --}}
                        <div class="absolute inset-0 border border-indigo-500/20 rounded-3xl pointer-events-none"></div>
                    </div>

                    {{-- Secret Key fallback --}}
                    <div class="mb-12 max-w-xs mx-auto text-center">
                        <span class="text-[10px] uppercase tracking-widest text-slate-500 dark:text-slate-400 font-bold mb-2 block">Manuální klíč (Secret)</span>
                        <div class="bg-slate-100 dark:bg-slate-900/50 p-3 rounded-xl border border-gray-200 dark:border-slate-700/50 font-mono text-xs text-indigo-600 dark:text-indigo-400 break-all shadow-inner">
                            {{ $secret }}
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-slate-700/50 mb-10">

                    {{-- Instrukce 2 --}}
                    <div class="mb-8">
                        <div class="flex justify-center items-center gap-3 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-500/30">2</span>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-slate-100 tracking-tight">Ověřte nastavení</h3>
                        </div>
                        <p class="text-gray-500 dark:text-slate-400 text-sm italic">
                            Zadejte šestimístný kód vygenerovaný vaší aplikací.
                        </p>
                    </div>

                    {{-- Ověřovací formulář --}}
                    <form action="{{ route($module->getSimulationVerifySetupRoute(), ['module' => $module->slug]) }}" method="POST" class="max-w-sm mx-auto">
                        @csrf
                        <div class="mb-8 group">
                            <input type="text"
                                   name="code"
                                   placeholder="000 000"
                                   class="text-center text-4xl font-black tracking-[0.5em] w-full py-4 bg-transparent border-b-2 border-gray-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 focus:border-indigo-500 focus:ring-0 transition-colors duration-300 placeholder-gray-300 dark:placeholder-slate-700"
                                   maxlength="6"
                                   required
                                   autocomplete="off">
                        </div>

                        <button type="submit" class="group relative w-full inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-bold text-white transition-all duration-300 shadow-xl shadow-indigo-500/20 group-hover:shadow-indigo-500/40">
                            <span class="flex items-center gap-2 uppercase tracking-widest text-sm">
                                Ověřit a dokončit nastavení
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>

                {{-- Navigační patička --}}
                <div class="bg-gray-50 dark:bg-slate-800/60 px-8 py-4 border-t border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                    <a href="{{ route('module.implementation', ['module' => $module->slug]) }}"
                       class="flex items-center gap-2 text-sm font-bold text-gray-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors group">
                        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Zpět na implementaci
                    </a>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-tighter">
                        Bezpečnostní poznámka: Tento klíč nikdy nesdílejte s neověřenými stranami.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
