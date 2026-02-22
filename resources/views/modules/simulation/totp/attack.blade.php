<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Experiment</span>
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
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Cíl experimentu - Glassmorphism Info Box --}}
            <div class="mb-8 relative overflow-hidden bg-indigo-500/5 dark:bg-indigo-500/10 border-l-4 border-indigo-500 rounded-r-2xl p-6 backdrop-blur-sm shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-indigo-500 rounded-lg text-white shadow-lg shadow-indigo-500/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-[0.2em] mb-2">
                            Cíl experimentu: Phishing a Replay útoky
                        </h3>
                        <div class="text-gray-700 dark:text-slate-200 text-sm leading-relaxed space-y-3 font-medium">
                            <p>
                                V tomto scénáři testujeme dvě fundamentální slabiny TOTP protokolu. Zaprvé ověříme <strong>absenci vazby na původ (Origin Binding)</strong>. Zkuste zadat validní kód na simulované podvržené doméně. Kód totiž není vázán na konkrétní web, ale pouze na časové okno.
                            </p>
                            <p>
                                Zadruhé demonstrujeme hrozbu <strong>útoku přehráním (Replay Attack)</strong>. Pokud útočník získá váš kód z podvodné stránky, pokusí se jej okamžitě použít na legitimním serveru.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                {{-- Simulovaný falešný web (Browser Mockup) --}}
                <div class="bg-white dark:bg-slate-800/60 dark:backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border-2 border-rose-500/30 flex flex-col group transition-all duration-300 hover:border-rose-500/50">
                    <div class="bg-slate-100 dark:bg-slate-900/80 border-b border-gray-200 dark:border-slate-700 px-4 py-3 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-rose-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                        </div>
                        <div class="flex-1 bg-white dark:bg-slate-800 rounded-lg px-3 py-1.5 text-[10px] text-rose-500 font-mono text-center border border-rose-500/20 shadow-inner flex items-center justify-center gap-2">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                            https://g00gle-login-secure.com
                        </div>
                    </div>

                    <div class="p-8 flex-grow flex flex-col justify-center">
                        <div class="text-center mb-8">
                            <div class="w-16 h-16 bg-rose-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-rose-500/20">
                                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 3v8h8a10.003 10.003 0 00-9.571-9.571l-.09.054a10.003 10.003 0 00-2.04 3.44l-.054.09A10.003 10.003 0 003 12h8v8a10.003 10.003 0 009.571-9.571l.09-.054a10.003 10.003 0 002.04-3.44l.054-.09z" /></svg>
                            </div>
                            <h3 class="text-xl font-black text-gray-800 dark:text-slate-100">Přihlášení k účtu</h3>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Simulace phishingového útoku</p>
                        </div>

                        <form action="{{ route('module.totp.verify_attack', ['module' => $module->slug]) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest mb-2">Váš TOTP kód</label>
                                <input type="text"
                                       name="code"
                                       class="block w-full rounded-xl border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 text-indigo-600 dark:text-indigo-400 shadow-sm focus:border-rose-500 focus:ring-rose-500/20 text-center text-3xl font-black tracking-[0.3em] py-4 placeholder-gray-300 dark:placeholder-slate-700"
                                       placeholder="000 000"
                                       maxlength="6"
                                       required>
                            </div>
                            <button type="submit" class="w-full bg-rose-600 hover:bg-rose-500 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg shadow-rose-500/20 hover:shadow-rose-500/40 uppercase tracking-widest text-xs">
                                Odeslat na falešný server
                            </button>
                        </form>
                    </div>
                </div>

                {{-- System Analyzer (Terminal Look) --}}
                <div class="bg-slate-950/90 backdrop-blur-md overflow-hidden shadow-2xl rounded-2xl border border-slate-800 p-8 flex flex-col group h-full">
                    <div class="mb-6 border-b border-slate-800 pb-4 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-xs font-black text-slate-100 tracking-[0.2em] uppercase">> SYSTEM ANALYZER</span>
                        </div>
                        <span class="text-[10px] text-rose-500 font-bold border border-rose-500/30 px-2 py-0.5 rounded-md bg-rose-500/5 animate-pulse uppercase tracking-tighter">
                            Vulnerability Scan Active
                        </span>
                    </div>

                    <div class="space-y-4 font-mono text-xs flex-grow mb-8 overflow-y-auto max-h-[200px] scrollbar-hide">
                        <p class="text-emerald-500/80">> Waiting for user input on port 443...</p>
                        <p class="text-slate-500">> Monitoring traffic for Origin Binding mismatch...</p>
                        <p class="text-slate-500">> Session ID: {{ bin2hex(random_bytes(8)) }}</p>
                        <p class="text-amber-500/70">> Alert: Potential Man-in-the-Middle detected.</p>
                    </div>

                    <div class="space-y-6">
                        {{-- Zamyšlení 1 --}}
                        <div class="bg-slate-900/80 p-5 rounded-2xl border-l-4 border-amber-500 shadow-inner group/card hover:bg-slate-900 transition-colors">
                            <p class="text-amber-400 font-black text-[10px] uppercase tracking-widest mb-2 flex items-center gap-2">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" /></svg>
                                Zamyšlení: Origin Binding
                            </p>
                            <p class="text-slate-200 text-xs leading-relaxed font-medium">
                                Ví vaše autentizační aplikace, na jakou stránku se díváte? Ne. Zabrání vám zadat kód na <code class="text-rose-400 bg-rose-500/10 px-1 rounded font-bold">g00gle.com</code>? Také ne.
                            </p>
                        </div>

                        {{-- Zamyšlení 2 --}}
                        <div class="bg-slate-900/80 p-5 rounded-2xl border-l-4 border-rose-500 shadow-inner group/card hover:bg-slate-900 transition-colors">
                            <p class="text-rose-400 font-black text-[10px] uppercase tracking-widest mb-2 flex items-center gap-2">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" /></svg>
                                Analýza: Replay Attack
                            </p>
                            <p class="text-slate-200 text-xs leading-relaxed font-medium">
                                TOTP kód platí 30s. Útočníkovi stačí sekundy na jeho přeposlání. Bez validace mezipaměti na straně serveru je kód v daném okně znovu použitelný.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-center">
                <a href="{{ route('module.implementation', ['module' => $module->slug]) }}" class="text-xs font-black uppercase tracking-[0.2em] text-slate-500 hover:text-indigo-400 transition-colors duration-200">
                    ← Zpět na ukázky kódu
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
