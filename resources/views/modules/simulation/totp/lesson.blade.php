<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Analýza a ochranná opatření</span>
                </h2>
            </div>

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

            {{-- Sekce 1: Origin Binding --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-6 py-4 border-l-4 border-rose-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        Strukturální absence "Origin Binding"
                    </h3>
                    <span class="text-[10px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-1 rounded uppercase font-bold">Kritická zranitelnost</span>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium mb-8">
                        <p>
                            Úspěch útoku <strong>Adversary-in-the-Middle (AitM)</strong>, který jste si vyzkoušeli, není chybou vaší implementace. Jedná se o fundamentální vlastnost návrhu protokolu <strong>TOTP</strong>.
                        </p>
                    </div>

                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium">
                        <p>
                            Jak vidíte, funkce přijímá pouze symetrický klíč a čas. <strong>Zcela chybí kryptografická vazba na doménu</strong>. Kód vygenerovaný pro falešnou doménu je matematicky identický s kódem pro legitimní službu.
                        </p>
                    </div>

                    {{-- Alert pro ochranná opatření --}}
                    <div class="mt-8 p-6 bg-rose-500/5 border border-rose-500/20 rounded-2xl flex gap-5 items-start">
                        <div class="p-2 bg-rose-500/10 rounded-lg text-rose-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-rose-500 font-bold uppercase tracking-wider text-xs mb-1">Standardy a ochranná opatření</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                                Dokument <strong>NIST SP 800-63B</strong> řadí TOTP do úrovně AAL2 právě kvůli rizikům phishingu. Plnou ochranu poskytuje až <strong>FIDO2 / WebAuthn</strong>, kde podpis zahrnuje hash <code>rpId</code> (Origin Binding).
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sekce 2: Replay Attack --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-6 py-4 border-l-4 border-amber-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Replay Attack a ochrana časového okna
                    </h3>
                </div>

                <div class="p-8 md:p-10 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-600 dark:text-slate-300 mb-8 leading-relaxed">
                        <p>
                            Aby TOTP kompenzovalo síťovou latenci, implementace běžně validují i přilehlé časové kroky. Tím vzniká validní okno delší než standardních 30 sekund. Bez stavové logiky může útočník i oběť použít **stejný kód opakovaně** (Replay Attack).
                        </p>
                        <p class="font-bold text-indigo-600 dark:text-indigo-400">
                            Nápravné opatření: Backend musí po úspěšném ověření hodnotu pro daný krok $T$ zneplatnit v mezipaměti (např. Redis) po celou dobu jeho platnosti.
                        </p>
                    </div>

                    {{-- IDE Style Code Samples --}}
                    <div x-data="{ selectedLang: '{{ array_key_first($codeSamples) }}' }" class="flex flex-col border border-gray-200 dark:border-slate-700/50 rounded-2xl overflow-hidden shadow-inner">
                        <div class="flex bg-slate-100 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700/50 px-2 pt-2">
                            @foreach($codeSamples as $language => $code)
                                <button @click="selectedLang = '{{ $language }}'"
                                        :class="selectedLang === '{{ $language }}' ? 'bg-white dark:bg-slate-800 text-indigo-600 dark:text-indigo-400 border-gray-200 dark:border-slate-700/50 border-t border-x rounded-t-xl' : 'text-gray-500 dark:text-slate-500 hover:text-indigo-400'"
                                        class="py-3 px-6 text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-200 outline-none -mb-[1px]">
                                    {{ $language }} Ochrana
                                </button>
                            @endforeach
                        </div>

                        <div class="relative bg-slate-50 dark:bg-slate-900/40 min-h-[300px]">
                            @foreach($codeSamples as $language => $code)
                                <div x-show="selectedLang === '{{ $language }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                                    <pre class="m-0"><code class="language-{{ strtolower($language) }} p-8 text-sm leading-relaxed block overflow-x-auto">{{ $code }}</code></pre>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sekce 3: Praktická doporučení --}}
                <div class="p-8 md:p-10 border-t border-gray-100 dark:border-slate-700/50">
                    <h4 class="text-emerald-500 font-black text-sm uppercase tracking-wider mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Důležité upozornění k ochraně
                    </h4>
                    <div class="bg-amber-500/5 dark:bg-amber-500/10 border border-amber-500/20 rounded-2xl p-6 mb-8">
                        <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                            Stavová paměť (cache), kterou jste si v simulaci zapnuli, řeší <strong>pouze Replay Attack</strong>. Útok AitM (phishing) zůstává <strong>zranitelností by design</strong> — kód vygenerovaný na falešné doméně je matematicky platný i na legitimní službě. Jedinou plnou ochranou je přechod na protokol s Origin Binding (FIDO2 / Passkeys).
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-6 shadow-inner">
                            <h5 class="font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tight text-xs mb-4">Co může udělat uživatel</h5>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2">
                                    <span class="text-emerald-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Vždy kontrolovat doménu</strong> v adresním řádku před zadáním TOTP kódu</p>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-emerald-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Používat password manažer</strong> — ten odmítne vyplnit přihlašovací údaje na neznámé doméně (de facto "lidský Origin Binding")</p>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-emerald-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Přejít na FIDO2 / Passkeys</strong> všude, kde je to podporováno (Google, Apple, Microsoft, GitHub aj.)</p>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-6 shadow-inner">
                            <h5 class="font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-tight text-xs mb-4">Co může udělat vývojář</h5>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-2">
                                    <span class="text-indigo-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Minimální validní okno</strong> — nastavit tolerance na 1 krok (30s), ne více</p>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-indigo-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Stavová paměť (Redis cache)</strong> — ukládat použité kódy a zamítat opakované pokusy</p>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-indigo-500 mt-0.5">•</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed"><strong class="text-slate-800 dark:text-slate-200">Rate limiting a lockout</strong> — po N neúspěšných pokusech dočasně zablokovat verifikaci</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Co udělat teď --}}
                <div class="mx-8 md:mx-10 mb-8">
                    <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-6 shadow-inner">
                        <h4 class="text-emerald-500 font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Co udělat teď
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">1</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Zkontrolujte bookmarky</strong> — přistupujte k bance a emailu výhradně přes uložené záložky, nikdy přes odkazy v emailech.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">2</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Nainstalujte password manažer</strong> (Bitwarden, 1Password). Ten za vás zkontroluje doménu a na phishingové stránce nevyplní nic.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">3</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Aktivujte Passkeys</strong> kde je to možné — je to automatický Origin Binding, který eliminuje phishing i replay.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigační patička --}}
                <div class="bg-gray-50 dark:bg-slate-800/60 px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                        Analýza dokončena. Jste připraveni na test?
                    </p>

                    <form action="{{ route('module.totp.complete', ['module' => $module->slug]) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-auto relative inline-flex items-center justify-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-bold text-sm text-white transition-all duration-300 group/btn shadow-xl shadow-indigo-500/20 uppercase tracking-widest">
                            <span>Vstoupit do závěrečného testu</span>
                            <svg class="ml-3 w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Highlight.js --}}
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
