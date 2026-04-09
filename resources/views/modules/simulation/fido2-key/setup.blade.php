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
                            FIDO2 vás ochrání před phishingem, ale <strong>špatné nastavení klíče může vést k průšvihu při jeho fyzické ztrátě</strong>. Vaším úkolem v této laboratoři je "vykovat" si asymetrický pár klíčů.
                        </p>
                        <ul class="text-sm text-slate-300 mt-3 space-y-2 list-none">
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">1</span>
                                V <strong>API Dashboardu</strong> níže si zkuste přepínat typy klíčů a nutnost zadání PINu (User Verification).
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">2</span>
                                Sledujte, jak vaše volby mění komunikační <strong>JSON payload</strong>.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">3</span>
                                Klikněte na <strong>"Spustit MakeCredential API"</strong> a v pravém terminálu sledujte, co dělá Secure Enclave.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                {{-- LEVÝ SLOUPEC: Konfigurace a Data --}}
                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-32 h-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path></svg>
                    </div>

                    <h3 class="text-indigo-400 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10 uppercase">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        API Dashboard
                    </h3>

                    <div class="space-y-6 flex-1 z-10">
                        {{-- Typ Authentizátoru --}}
                        <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700/50">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">1. Typ autentizátoru (Attachment)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="config.attachment = 'cross-platform'" :class="config.attachment === 'cross-platform' ? 'bg-indigo-600/20 border-indigo-500 text-indigo-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-3 rounded-lg border text-xs font-bold transition-all flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Cross-Platform (USB)
                                </button>
                                <button @click="config.attachment = 'platform'" :class="config.attachment === 'platform' ? 'bg-indigo-600/20 border-indigo-500 text-indigo-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-3 rounded-lg border text-xs font-bold transition-all flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    Platform (TouchID/Hello)
                                </button>
                            </div>
                        </div>

                        {{-- User Verification --}}
                        <div class="bg-slate-900/80 p-4 rounded-xl border border-slate-700/50">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">2. User Verification (PIN/Biometrie na klíči)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="config.uv = 'required'" :class="config.uv === 'required' ? 'bg-emerald-600/20 border-emerald-500 text-emerald-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-3 rounded-lg border text-xs font-bold transition-all flex flex-col items-center text-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    Required<br><span class="text-[10px] opacity-70 font-normal">Chrání při krádeži</span>
                                </button>
                                <button @click="config.uv = 'discouraged'" :class="config.uv === 'discouraged' ? 'bg-rose-600/20 border-rose-500 text-rose-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-3 rounded-lg border text-xs font-bold transition-all flex flex-col items-center text-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                                    Discouraged<br><span class="text-[10px] opacity-70 font-normal">Rychlé, bez PINu</span>
                                </button>
                            </div>
                        </div>

                        {{-- Kod --}}
                        <div class="bg-slate-900 border border-slate-700/50 p-4 rounded-xl shadow-inner font-mono text-[10px] text-slate-300 relative overflow-hidden">
                            <div class="absolute right-3 top-3 text-[9px] bg-slate-800 text-indigo-400 px-2 py-0.5 rounded font-bold border border-indigo-500/30">navigator.credentials.create()</div>
                            <div class="text-slate-500 mb-2">// Vygenerovaný payload pro autentizátor</div>
                            <p><span class="text-indigo-400">const</span> publicKey = {</p>
                            <p class="pl-4">challenge: <span class="text-amber-300">Uint8Array(32)</span>,</p>
                            <p class="pl-4">rp: { name: <span class="text-amber-300">"SecureBank"</span>, id: <span class="text-emerald-400">"securebank.cz"</span> },</p>
                            <p class="pl-4">authenticatorSelection: {</p>
                            <p class="pl-8">authenticatorAttachment: <span class="text-amber-300">"<span x-text="config.attachment"></span>"</span>,</p>
                            <p class="pl-8">userVerification: <span :class="config.uv === 'required' ? 'text-emerald-400 font-bold' : 'text-rose-400 font-bold'">"<span x-text="config.uv"></span>"</span></p>
                            <p class="pl-4">}</p>
                            <p>};</p>
                        </div>
                    </div>
                </div>


                {{-- PRAVÝ SLOUPEC: Simulace Generování --}}
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative">
                    <div class="absolute top-0 left-0 w-1/3 h-1 bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] rounded-tl-3xl"></div>

                    <h3 class="text-emerald-400 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10 uppercase">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                        // HARDWARE_ENCLAVE
                    </h3>

                    <div class="flex-1 flex flex-col items-center justify-center relative min-h-[300px]">
                        <div class="relative w-48 h-64 border-2 rounded-[40px] flex items-center justify-center overflow-hidden transition-colors duration-500"
                             :class="isGenerating ? 'border-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.2)]' : (genComplete ? 'border-emerald-400' : 'border-slate-700')">

                            <div class="absolute inset-0 bg-slate-900/50 flex flex-col items-center justify-center transition-all duration-700">
                                <svg x-show="config.attachment === 'cross-platform'" class="w-16 h-16 mb-4 transition-colors duration-500" :class="isGenerating ? 'text-emerald-400' : (genComplete ? 'text-emerald-500' : 'text-slate-600')" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                                <svg x-show="config.attachment === 'platform'" class="w-16 h-16 mb-4 transition-colors duration-500" :class="isGenerating ? 'text-emerald-400' : (genComplete ? 'text-emerald-500' : 'text-slate-600')" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>

                                <span class="text-[9px] font-mono font-black uppercase tracking-[0.3em]" :class="genComplete ? 'text-emerald-400' : 'text-slate-500'">Secure Enclave</span>
                                
                                <div x-show="genComplete && config.uv === 'required'" class="mt-4 bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded text-[10px] font-bold border border-emerald-500/30">
                                    PIN PROCTECTED
                                </div>
                                <div x-show="genComplete && config.uv === 'discouraged'" class="mt-4 bg-rose-500/20 text-rose-400 px-3 py-1 rounded text-[10px] font-bold border border-rose-500/30">
                                    LACKS UV PROTECTION
                                </div>
                            </div>

                            <div x-show="isGenerating" class="absolute inset-x-0 h-1 bg-emerald-400 shadow-[0_0_20px_#34d399] z-30" :style="`top: ${scanProgress}%`"></div>
                        </div>

                    </div>

                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-56 overflow-y-auto flex flex-col font-mono text-[10px] sm:text-xs shrink-0 mt-4">
                        <div class="text-slate-500 mb-2">// KEYGEN_LOG_STREAM</div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in text-slate-300">
                                <span class="opacity-50 mr-2" :class="log.type === 'warn' ? 'text-amber-400' : 'text-emerald-400'">>></span>
                                <span x-text="log.msg" :class="log.type === 'warn' ? 'text-amber-400' : ''"></span>
                            </div>
                        </template>
                        <div x-show="isGenerating" class="text-emerald-400 animate-pulse mt-2">
                            <span class="opacity-50 mr-2">>></span>
                            Čekání na interakci uživatele...
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col gap-3">
                        <button x-show="!genComplete" @click="startSimulation()" :disabled="isGenerating" class="w-full bg-slate-800 hover:bg-slate-700 text-emerald-400 disabled:opacity-50 border border-slate-700 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest transition-colors flex justify-center items-center">
                            <span x-text="isGenerating ? 'Generování...' : 'Spustit MakeCredential API'"></span>
                        </button>

                        <form x-show="genComplete" action="{{ route($module->getSimulationAttackRoute(), ['module' => $module->slug]) }}" method="GET" class="w-full">
                            @csrf
                            <input type="hidden" name="config_uv" :value="config.uv">
                            <button type="submit" class="w-full group bg-emerald-600 hover:bg-emerald-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-[0_0_20px_rgba(16,185,129,0.4)] flex items-center justify-center">
                                Otestovat odolnost
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
                config: {
                    attachment: 'cross-platform',
                    uv: 'required'
                },

                // Reset when config changes
                init() {
                    this.$watch('config.attachment', () => { this.resetGen(); });
                    this.$watch('config.uv', () => { this.resetGen(); });
                },

                resetGen() {
                    this.genComplete = false;
                    this.logs = [];
                },

                startSimulation() {
                    this.isGenerating = true;
                    this.genComplete = false;
                    this.scanProgress = 0;
                    this.logs = [{type: 'info', msg: `[API] navigator.credentials.create({ attachment: "${this.config.attachment}", uv: "${this.config.uv}" })`}];

                    let interval = setInterval(() => {
                        this.scanProgress += 2;

                        if (this.scanProgress === 20) {
                            this.logs.push({type: 'info', msg: '[CTAP2] Zahájena komunikace s autentizátorem...'});
                        }
                        if (this.scanProgress === 40) {
                            if (this.config.uv === 'required') {
                                this.logs.push({type: 'info', msg: '[HARDWARE] Vyžádáno OVĚŘENÍ uživatele (zadání PIN/Biometrie)...'});
                            } else {
                                this.logs.push({type: 'warn', msg: '[HARDWARE] Vyžádána pouze PŘÍTOMNOST uživatele (dotyk).'});
                            }
                        }
                        if (this.scanProgress === 70) {
                            this.logs.push({type: 'info', msg: '[CRYPTO] Generování asymetrického EC páru...'});
                        }

                        if (this.scanProgress >= 100) {
                            clearInterval(interval);
                            this.isGenerating = false;
                            this.genComplete = true;
                            
                            if (this.config.uv === 'required') {
                                this.logs.push({type: 'success', msg: '[SUCCESS] Pár vytvořen. Klíč je silně vázán na PIN.'});
                            } else {
                                this.logs.push({type: 'warn', msg: '[SUCCESS] Pár vytvořen. Kdokoliv se dotkne klíče, přihlásí se.'});
                            }

                            this.$nextTick(() => {
                                const logContainer = document.querySelector('.overflow-y-auto');
                                if(logContainer) logContainer.scrollTop = logContainer.scrollHeight;
                            });
                        }
                    }, 40);
                }
            }
        }
    </script>
</x-app-layout>
