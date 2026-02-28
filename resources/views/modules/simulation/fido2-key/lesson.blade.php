<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Analýza neprostupnosti</span>
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

            {{-- SEKCE 1: ANALÝZA ÚSPĚŠNÉ OBRANY (Kryptografické Veto) --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-emerald-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Anatomie úspěšné obrany: Origin Binding
                    </h3>
                    <span class="text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-1 rounded uppercase font-bold">Phishing Resistant</span>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium mb-10">
                        <p>
                            V předchozí simulaci jste viděli, že Phishing a AitM útoky proti FIDO2 jsou technicky nerealizovatelné. Zatímco u SMS nebo TOTP nese plnou zodpovědnost za ověření pravosti stránky zmatený uživatel, u standardu WebAuthn přebírá roli nekompromisního strážce <strong>webový prohlížeč</strong>.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Bod 1 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-emerald-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-emerald-500/10 text-emerald-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Mechanismus 0x01</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Browser jako Trust Anchor</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Kdykoliv stránka zavolá API <code>navigator.credentials.get()</code>, prohlížeč automaticky sváže tento požadavek s aktuální URL adresou (tzv. <strong>Origin</strong>) zobrazenou v adresním řádku. Uživatel tento parametr nemůže nijak podvrhnout.
                            </p>
                        </div>

                        {{-- Bod 2 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-emerald-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-emerald-500/10 text-emerald-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Mechanismus 0x02</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Kryptografické Veto</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Pokud se požadované <code>rpId</code> (identifikátor služby, pro kterou byl klíč vytvořen) neshoduje s aktuální doménou webu (Origin), prohlížeč odmítne komunikovat s CTAP2 zařízením. Útočník tak nedostane šanci vylákat z klíče podpis.
                            </p>
                        </div>

                        {{-- Bod bod 3 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-emerald-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-emerald-500/10 text-emerald-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Mechanismus 0x03</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Sign Counter (Ochrana Replay)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Každá operace na hardwarovém klíči inkrementuje vnitřní počítadlo. I kdyby útočník nějakým zázrakem zachytil platný podpis, banka jej při druhém použití odmítne (kvůli identické výzvě a použitému počítadlu).
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEKCE 2: STRUKTURA PODPISU A MATEMATIKA --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-indigo-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Matematika za oponou: Asymetrická kryptografie
                    </h3>
                </div>

                <div class="p-8 md:p-10 border-b border-gray-100 dark:border-slate-700/50">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-600 dark:text-slate-300 mb-8 leading-relaxed">
                        <p>
                            FIDO2 / WebAuthn nestojí na porovnávání řetězců jako hesla, ale na digitálním podpisu. Během ověření provede autentizátor asymetrickou operaci, při které svým <strong>privátním klíčem ($K_{priv}$)</strong> podepíše hash z klientských dat.
                        </p>
                    </div>

                    {{-- Matematická rovnice --}}
                    <div class="my-8 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-2xl overflow-hidden shadow-inner">
                        <div class="bg-indigo-600/10 px-4 py-2 border-b border-indigo-500/20 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest font-mono">Generování kryptografického důkazu (Assertion)</span>
                        </div>
                        <div class="p-8 text-center">
                            <div class="font-mono text-xl md:text-2xl text-indigo-700 dark:text-indigo-300 leading-relaxed tracking-tight overflow-x-auto">
                                $$Signature = Sign(K_{priv}, Hash(authData \parallel Hash(clientDataJSON)))$$
                            </div>
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-mono text-slate-500 dark:text-slate-400 border-t border-indigo-500/10 pt-6 text-left">
                                <div class="flex items-center gap-2"><span class="font-black text-indigo-500">clientDataJSON:</span> Obsahuje aktuální Challenge a Origin (URL) </div>
                                <div class="flex items-center gap-2"><span class="font-black text-indigo-500">authData:</span> Obsahuje rpId a Sign Counter </div>
                            </div>
                        </div>
                    </div>

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

                            <div class="relative bg-slate-50 dark:bg-slate-900/40 min-h-[300px]">
                                @foreach($codeSamples as $language => $code)
                                    <div x-show="selectedLang === '{{ $language }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" style="display: none;">
                                        @php
                                            $hljsLang = str_contains(strtolower($language), 'json') ? 'json' : (str_contains(strtolower($language), 'php') ? 'php' : 'javascript');
                                        @endphp
                                        <pre class="m-0"><code class="language-{{ $hljsLang }} p-8 text-sm leading-relaxed block overflow-x-auto bg-transparent">{{ $code }}</code></pre>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Patička s odesláním do kvízu --}}
                <div class="bg-gray-50/80 dark:bg-slate-800/60 px-8 py-8 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-6 mt-auto">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                        Absolutní bezpečnost dosažena. Jste připraveni na závěrečný test?
                    </p>

                    <form action="{{ route('module.fido2.complete', ['module' => $module->slug]) }}" method="POST" class="w-full md:w-auto">
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
