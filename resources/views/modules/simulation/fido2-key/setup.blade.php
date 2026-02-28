<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $module->title }} - Registrace: Kování asymetrického páru
            </h2>
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

    <div class="py-8" x-data="fidoSetupSimulation()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50 mb-8 transition-all">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-2">
                            FIDO2 / WebAuthn: Zlatý standard autentizace (AAL3)
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            V tomto modulu opouštíme koncept „přepisování kódů“. FIDO2 využívá asymetrickou kryptografii a podpis <code>clientDataJSON</code>, který obsahuje <code>rpId</code> a <code>origin</code>. Tato architektura matematicky znemožňuje intercepci i phishing, čímž řeší hlavní slabinu protokolu TOTP, kterému chybí vazba na původ (Origin Binding)[cite: 35, 69]. Prvním krokem je registrace: váš hardware (autentizátor) vytvoří unikátní pár klíčů pevně svázaný s doménou <strong>securebank.cz</strong>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-32 h-32 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path></svg>
                    </div>

                    <h3 class="text-emerald-400 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        // AUTHENTICATOR: KEY_GEN_V2
                    </h3>

                    <div class="flex-1 flex flex-col items-center justify-center relative">
                        <div class="relative w-48 h-64 border-2 rounded-[40px] flex items-center justify-center overflow-hidden transition-colors duration-500"
                             :class="isGenerating ? 'border-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.2)]' : (genComplete ? 'border-emerald-400' : 'border-slate-700')">

                            <div class="w-32 h-32 flex flex-col items-center justify-center transition-all duration-700">
                                <svg class="w-20 h-20 mb-2 transition-colors duration-500" :class="isGenerating ? 'text-emerald-400' : (genComplete ? 'text-emerald-500' : 'text-slate-600')" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                                <span class="text-[9px] font-mono font-black uppercase tracking-[0.3em]" :class="genComplete ? 'text-emerald-400' : 'text-slate-500'">Secure Enclave</span>
                            </div>

                            <div x-show="isGenerating" class="absolute inset-x-0 h-1 bg-emerald-400 shadow-[0_0_20px_#34d399] z-30" :style="`top: ${scanProgress}%`"></div>
                        </div>

                        <div class="mt-6 w-full space-y-3 px-2">
                            <div x-show="genComplete" x-transition.duration.500ms class="bg-slate-900 border border-emerald-500/30 p-2 rounded-lg font-mono text-[10px] text-emerald-400 relative overflow-hidden group">
                                <span class="text-emerald-500 font-bold block mb-1">Public Key (K<sub>pub</sub>)</span>
                                <span class="break-all opacity-80">MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE7...</span>
                            </div>
                            <div x-show="genComplete" x-transition.duration.500ms x-transition.delay.200ms class="bg-slate-900 border border-rose-500/30 p-2 rounded-lg font-mono text-[10px] text-rose-400 relative overflow-hidden group">
                                <span class="text-rose-500 font-bold block mb-1">Private Key (K<sub>priv</sub>)</span>
                                <span class="italic opacity-80">•••• •••• •••• •••• •••• •••• ••••</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-40 overflow-y-auto font-mono text-[10px] sm:text-xs shrink-0 mt-4">
                        <div class="text-slate-500 mb-2">// KEYGEN_LOG_STREAM</div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in text-slate-300">
                                <span class="opacity-50 mr-2 text-emerald-400">>></span>
                                <span x-text="log"></span>
                            </div>
                        </template>
                        <div x-show="isGenerating" class="text-emerald-400 animate-pulse mt-2">
                            <span class="opacity-50 mr-2">>></span>
                            Probíhá kování klíčů...
                        </div>
                    </div>

                    <button @click="startSimulation()" :disabled="isGenerating" class="mt-4 w-full bg-slate-800 hover:bg-slate-700 text-emerald-400 disabled:opacity-50 border border-slate-700 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition-colors">
                        <span x-text="genComplete ? 'Restartovat generování' : 'Spustit MakeCredential'"></span>
                    </button>
                </div>

                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative">
                    <div class="absolute top-0 left-0 w-1/3 h-1 bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] rounded-tl-3xl"></div>

                    <h3 class="text-slate-100 font-black text-xl mb-6 tracking-tight">0x01: Koncept "MakeCredential"</h3>

                    <div class="space-y-6 text-sm text-slate-300 flex-1">
                        <p>
                            Při registraci FIDO2 klíče nedochází k předání hesla. Prohlížeč (WebAuthn API) pošle do autentizátoru informaci o službě: <code class="text-emerald-400 bg-emerald-400/10 px-1 rounded">rpId: securebank.cz</code>.
                        </p>

                        <div class="bg-slate-900/60 p-5 rounded-xl border border-slate-700/50 shadow-inner">
                            <h4 class="text-emerald-400 font-bold mb-3 uppercase tracking-widest text-xs">Průběh registrace:</h4>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <span class="bg-emerald-500/20 text-emerald-400 font-mono text-[10px] w-6 h-6 flex items-center justify-center rounded-lg mr-3 mt-1 shrink-0">01</span>
                                    <span><strong>Attestation:</strong> Autentizátor prokáže serveru svou identitu a integritu (např. "Jsem certifikovaný YubiKey").</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-emerald-500/20 text-emerald-400 font-mono text-[10px] w-6 h-6 flex items-center justify-center rounded-lg mr-3 mt-1 shrink-0">02</span>
                                    <span><strong>Key Generation:</strong> Dojde ke kování unikátního páru klíčů. Privátní klíč je nevratně uložen v Secure Enclave.</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="bg-emerald-500/20 text-emerald-400 font-mono text-[10px] w-6 h-6 flex items-center justify-center rounded-lg mr-3 mt-1 shrink-0">03</span>
                                    <span><strong>Origin Binding:</strong> Klíč je navždy spjat s doménou. Pokud se později pokusíte přihlásit na <em>fakebanka.cz</em>, hardware klíč vůbec nenajde.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="p-4 bg-emerald-500/5 border border-emerald-500/20 rounded-xl italic text-xs text-slate-400">
                            FIDO2 eliminuje sdílené tajemství. Pokud útočník ukradne databázi banky, získá pouze veřejné klíče, které jsou mu bez vašeho fyzického hardwaru k ničemu.
                        </div>
                    </div>

                    <div class="mt-8">
                        <form action="{{ route($module->getSimulationAttackRoute(), ['module' => $module->slug]) }}" method="GET">
                            @csrf
                            <button type="submit" :disabled="!genComplete" class="w-full group bg-emerald-600 hover:bg-emerald-500 disabled:bg-slate-800 disabled:text-slate-600 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-[0_0_20px_rgba(16,185,129,0.4)] disabled:shadow-none flex items-center justify-center">
                                Pokračovat k simulaci útoku
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function fidoSetupSimulation() {
            return {
                isGenerating: false,
                genComplete: false,
                scanProgress: 0,
                logs: [],

                startSimulation() {
                    this.isGenerating = true;
                    this.genComplete = false;
                    this.scanProgress = 0;
                    this.logs = ['[API] Volání navigator.credentials.create()...', '[CTAP2] Komunikace s autentizátorem zahájena.'];

                    let interval = setInterval(() => {
                        this.scanProgress += 2; // Stejný progress bar jako u biometrie

                        if (this.scanProgress === 30) {
                            this.logs.push('[HARDWARE] Vyžádáno User Presence (UP)...');
                        }
                        if (this.scanProgress === 60) {
                            this.logs.push('[CRYPTO] Generování EC párů (P-256 curve)...');
                        }
                        if (this.scanProgress === 80) {
                            this.logs.push('[STORAGE] Ukládání klíče pro RP: securebank.cz...');
                        }

                        if (this.scanProgress >= 100) {
                            clearInterval(interval);
                            this.isGenerating = false;
                            this.genComplete = true;
                            this.logs.push('[SUCCESS] Registrace dokončena. Public Key připraven.');

                            this.$nextTick(() => {
                                const logContainer = document.querySelector('.overflow-y-auto');
                                if(logContainer) logContainer.scrollTop = logContainer.scrollHeight;
                            });
                        }
                    }, 50);
                }
            }
        }
    </script>
</x-app-layout>
