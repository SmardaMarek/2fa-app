<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Analýza a mitigace</span>
                </h2>
            </div>

            {{-- Standardizovaný indikátor postupu --}}
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

    {{-- Highlight.js CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stavová hláška --}}
            @if(session('status'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 p-5 rounded-2xl flex items-center gap-4 animate-fade-in">
                    <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-emerald-800 dark:text-emerald-400 font-bold text-sm tracking-wide uppercase">{{ session('status') }}</span>
                </div>
            @endif

            {{-- SEKCE 1: ANALÝZA ZRANITELNOSTÍ (Presentation Attack) --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-rose-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Analýza selhání senzoru (Optika)
                    </h3>
                    <span class="text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-1 rounded uppercase font-bold">Spoofing Vulnerability</span>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium mb-10">
                        <p>
                            Simulace potvrdila, že biometrie založená výhradně na <strong>2D optické komparaci</strong> neposkytuje dostatečnou úroveň jistoty (AAL) pro zabezpečení citlivých systémů. Systém nezklamala kryptografie, ale neschopnost hardwaru odlišit živou tkáň od kopie.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bod 1 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technická chyba 0x01</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Absence Z-osy (Hloubky)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Standardní RGB kamera analyzuje pouze plošné vektory (X, Y). Pokud je vzdálenost očí na ukradené fotografii proporcionálně shodná s realitou, biometrický algoritmus vygeneruje platný hash a přístup povolí.
                            </p>
                        </div>

                        {{-- Bod 2 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Architektonický požadavek</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Liveness Detection (PAD)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Moderní systémy musí implementovat mechanismus <strong>PAD (Presentation Attack Detection)</strong>. K tomu slouží hardwarové komponenty jako <em>Time-of-Flight (ToF)</em> senzory nebo infračervené projektory, které mapují 3D povrch.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEKCE 2: ANALÝZA ZRANITELNOSTÍ (MasterPrint Attack) --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-rose-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        Analýza selhání senzoru (Geometrie)
                    </h3>
                    <span class="text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-1 rounded uppercase font-bold">MasterPrint Exploit</span>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium mb-10">
                        <p>
                            Druhý sandbox demonstroval, že u kapacitních a ultrazvukových senzorů otisků prstů na mobilních zařízeních nevychází hlavní hrozba z podvržení materiálu, ale z <strong>fyzikálních omezení samotného senzoru</strong> a z nich plynoucí kompromitace matematické pravděpodobnosti.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bod 1 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technická zranitelnost</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Částečné šablony (Partial Templates)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Vzhledem k malé ploše mobilního senzoru nedochází k uložení celého otisku, ale k extrakci desítek <strong>dílčích šablon</strong> během registrační fáze. Při odemykání pak systému stačí kryptografická shoda pouze s jedinou z těchto mnoha šablon.
                            </p>
                        </div>

                        {{-- Bod 2 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Statistický útok</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">MasterPrint Injekce</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Algoritmicky vygenerovaný <strong>MasterPrint</strong> obsahuje shluk nejběžnějších papilárních linií a markantů lidské populace. Matematicky tak dramaticky zvyšuje hodnotu FAR (False Accept Rate), protože se snadno "trefí" do některé z mnoha uložených částečných šablon.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEKCE 3: PREVENCE A IMPLEMENTACE (FIDO2 & LocalAuth) --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-indigo-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Moderní architektura: User Verification
                    </h3>
                </div>

                <div class="p-8 md:p-10 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-600 dark:text-slate-300 mb-8 leading-relaxed">
                        <p>
                            V éře <strong>FIDO2 / WebAuthn</strong> se již biometrická data (ani jejich hashe) neposílají po síti na server k ověření. Biometrie slouží výhradně jako lokální ověření uživatele (<span class="font-mono text-indigo-400">User Verification - UV</span>).
                        </p>
                        <p>
                            Jak to funguje? Úspěšné přiložení prstu pouze <strong>"odemkne" lokální úložiště (Secure Enclave)</strong>, kde je uložen asymetrický privátní klíč. Teprve tento klíč podepíše challenge ze serveru.
                        </p>
                    </div>

                    {{-- IDE Style Code Samples (Dynamicky z kontroleru) --}}
                    @if(!empty($codeSamples))
                        <div x-data="{ selectedLang: '{{ array_key_first($codeSamples) }}' }" class="flex flex-col border border-gray-200 dark:border-slate-700/50 rounded-2xl overflow-hidden shadow-inner mt-8">
                            <div class="flex bg-slate-100 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700/50 px-2 pt-2">
                                @foreach($codeSamples as $language => $code)
                                    <button @click="selectedLang = '{{ $language }}'"
                                            :class="selectedLang === '{{ $language }}' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 border-gray-200 dark:border-slate-700/50 border-t border-x rounded-t-xl' : 'text-gray-500 dark:text-slate-500 hover:text-indigo-400'"
                                            class="py-3 px-6 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-200 outline-none -mb-[1px]">
                                        {{ $language }}
                                    </button>
                                @endforeach
                            </div>

                            <div class="relative bg-slate-50 dark:bg-slate-900/40 min-h-[200px]">
                                @foreach($codeSamples as $language => $code)
                                    <div x-show="selectedLang === '{{ $language }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                                        @php
                                            // Jednoduchá detekce jazyka pro highlight.js na základě klíče
                                            $hljsLang = str_contains(strtolower($language), 'javascript') ? 'javascript' : (str_contains(strtolower($language), 'swift') ? 'swift' : 'plaintext');
                                        @endphp
                                        <pre class="m-0"><code class="language-{{ $hljsLang }} p-8 text-sm leading-relaxed block overflow-x-auto bg-transparent">{{ $code }}</code></pre>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Patička s odesláním --}}
                <div class="bg-gray-50/80 dark:bg-slate-800/60 px-8 py-8 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-6 mt-auto">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                        Analýza dokončena. Jste připraveni na test?
                    </p>

                    <form action="{{ route('module.biometrics.complete', ['module' => $module->slug]) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-auto relative inline-flex items-center justify-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-indigo-500/20 active:scale-95 group/btn">
                            <span class="relative z-10 flex items-center gap-2">
                                Vstoupit do závěrečného testu
                                <svg class="w-5 h-5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Highlight.js Initialization --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((block) => { hljs.highlightElement(block); });
        });
        window.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                document.querySelectorAll('pre code').forEach((block) => { hljs.highlightElement(block); });
            });
        });
    </script>
</x-app-layout>