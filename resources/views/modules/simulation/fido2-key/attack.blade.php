<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $module->title }} - Simulace: Multivektorový test odolnosti
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
                    Krok 2 / 4
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8" x-data="fidoAttackSimulation()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Teoretický úvod --}}
            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50 mb-8 transition-all">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-2">
                            FIDO2 Sandbox: Threat Modeling
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Nyní se vžijte do role útočníka a pokuste se překonat FIDO2 ochranu oběti. K dispozici máte 3 různé scénáře (vektory útoku).
                        </p>
                        <ul class="text-sm text-slate-300 mt-3 space-y-2 list-none">
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">1</span>
                                Tlačítky v levém panelu si <strong>vyberte vektor útoku</strong> (AitM, Fyzická krádež nebo Hijacking).
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">2</span>
                                Klikněte na červené spouštěcí tlačítko dole a proveďte útok.
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="bg-indigo-500/20 text-indigo-400 font-bold bg-indigo-500/20 rounded-md w-5 h-5 flex items-center justify-center text-xs border border-indigo-500/30">3</span>
                                V pravém kontrolním terminálu <strong>sledujte reakci obranných mechanismů</strong>.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                {{-- LEVÝ SLOUPEC: Útočník a Konfigurace --}}
                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border-t-4 border-rose-500 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-32 h-32 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                    </div>

                    <h3 class="text-rose-500 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10 uppercase">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        Nástroje Útočníka
                    </h3>

                    <div class="flex-1 flex flex-col z-10 space-y-6">

                        {{-- Navigace útoků (Tabs) --}}
                        <div class="flex space-x-2 bg-slate-900 border border-slate-700/50 p-1 rounded-xl">
                            <button @click="attackVector = 'aitm'" :class="attackVector === 'aitm' ? 'bg-rose-600/20 text-rose-400 font-bold border-rose-500/50 shadow-inner' : 'text-slate-500 hover:text-slate-300 border-transparent'" class="flex-1 px-3 py-2 text-[10px] sm:text-xs uppercase tracking-wider rounded-lg transition-all border text-center">
                                AitM Phishing
                            </button>
                            <button @click="attackVector = 'theft'" :class="attackVector === 'theft' ? 'bg-rose-600/20 text-rose-400 font-bold border-rose-500/50 shadow-inner' : 'text-slate-500 hover:text-slate-300 border-transparent'" class="flex-1 px-3 py-2 text-[10px] sm:text-xs uppercase tracking-wider rounded-lg transition-all border text-center">
                                Fyzická Krádež
                            </button>
                            <button @click="attackVector = 'hijack'" :class="attackVector === 'hijack' ? 'bg-rose-600/20 text-rose-400 font-bold border-rose-500/50 shadow-inner' : 'text-slate-500 hover:text-slate-300 border-transparent'" class="flex-1 px-3 py-2 text-[10px] sm:text-xs uppercase tracking-wider rounded-lg transition-all border text-center">
                                Pass-the-Cookie
                            </button>
                        </div>

                        {{-- Konfigurace Oběti (Zobrazujeme jen u fyzické krádeže pro pochopení UV) --}}
                        <div x-show="attackVector === 'theft'" class="bg-indigo-900/20 p-4 rounded-xl border border-indigo-500/30">
                            <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2 flex justify-between">
                                <span>Konfigurace Oběti (User Verification)</span>
                                <span class="bg-indigo-950 px-2 py-0.5 rounded border border-indigo-500/30 text-[9px] text-indigo-300">SANDBOX</span>
                            </label>
                            <p class="text-[10px] text-indigo-300/80 mb-3">Změňte nastavení ukradeného klíče a pozorujte reakci obrany.</p>
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="victimUv = 'required'" :class="victimUv === 'required' ? 'bg-emerald-600/20 border-emerald-500 text-emerald-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-2 rounded-lg border text-xs font-bold transition-all text-center">
                                    UV: Required (PIN)
                                </button>
                                <button @click="victimUv = 'discouraged'" :class="victimUv === 'discouraged' ? 'bg-rose-600/20 border-rose-500 text-rose-400' : 'bg-slate-800 border-slate-700 text-slate-500 hover:bg-slate-700'" class="p-2 rounded-lg border text-xs font-bold transition-all text-center">
                                    UV: Discouraged (Dotyk)
                                </button>
                            </div>
                        </div>

                        {{-- Detaily vektoru 1: AitM --}}
                        <div x-show="attackVector === 'aitm'" class="text-left space-y-4 bg-slate-900/80 p-5 rounded-xl border border-slate-700/50 shadow-inner">
                            <div>
                                <p class="text-rose-400 font-mono text-xs font-bold uppercase tracking-wider mb-2">Proxy Phishing (securebanka.cz)</p>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed">
                                    Zkusíme zachytit a přeposlat kryptografickou výzvu v reálném čase. U TOTP by to fungovalo, webový prohlížeč však zkontroluje "Origin" doménu proti "rpId" dříve, než kontaktuje HW klíč.
                                </p>
                            </div>
                        </div>

                        {{-- Detaily vektoru 2: Krádež --}}
                        <div x-show="attackVector === 'theft'" class="text-left space-y-4 bg-slate-900/80 p-5 rounded-xl border border-slate-700/50 shadow-inner" style="display: none;">
                            <div>
                                <p class="text-rose-400 font-mono text-xs font-bold uppercase tracking-wider mb-2">Hardwarový útok (Ztracený klíč)</p>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed">
                                    Získali jsme fyzický přístup ke klíči (YubiKey). Připojíme ho do vlastního počítače a pokusíme se přihlásit k účtu oběti. Úspěch závisí na tom, zda má klíč nastaven User Verification (PIN).
                                </p>
                            </div>
                        </div>

                        {{-- Detaily vektoru 3: Hijacking --}}
                        <div x-show="attackVector === 'hijack'" class="text-left space-y-4 bg-slate-900/80 p-5 rounded-xl border border-slate-700/50 shadow-inner" style="display: none;">
                            <div>
                                <p class="text-rose-400 font-mono text-xs font-bold uppercase tracking-wider mb-2">Session Hijacking (XSS / Malware)</p>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed">
                                    FIDO2 slouží k prvotnímu přihlášení. Poté server vystaví <code class="text-rose-300">PHPSESSID</code> cookie. Pokud tuto cookie odcizíme přes XSS nebo InfoStealer malware, obejdeme FIDO2 úplně a získáme okamžitý přístup.
                                </p>
                            </div>
                        </div>

                    </div>

                    <button @click="startAttack()" :disabled="isAttacking" class="mt-6 w-full group transition-all transform hover:-translate-y-1 shadow-[0_0_15px_rgba(225,29,72,0.4)] flex items-center justify-center p-0 rounded-2xl overflow-hidden disabled:shadow-none disabled:transform-none">
                        <div class="w-full h-full bg-rose-600 hover:bg-rose-500 text-white font-black uppercase tracking-widest py-4 px-6 flex items-center justify-center" :class="isAttacking ? 'opacity-50' : ''">
                            <span x-show="!isAttacking && attackVector === 'aitm'">[ Odeslat Injektovanou Výzvu ]</span>
                            <span x-show="!isAttacking && attackVector === 'theft'">[ Přiložit Ukradený Klíč ]</span>
                            <span x-show="!isAttacking && attackVector === 'hijack'">[ Vložit Odcizenou Cookie ]</span>
                            
                            <span x-show="isAttacking" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Vykonávám útok...
                            </span>
                        </div>
                    </button>
                </div>

                {{-- PRAVÝ SLOUPEC: Oběť & Server Obrana --}}
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative overflow-hidden transition-all duration-500" :class="attackStatus === 'success' ? 'border-rose-500 shadow-[0_0_20px_rgba(225,29,72,0.15)] ring-1 ring-rose-500/20' : ''">
                    <div class="absolute top-0 left-0 w-1/3 h-1 shadow-[0_0_10px_rgba(16,185,129,0.5)] rounded-tl-3xl transition-colors duration-500" :class="attackStatus === 'success' ? 'bg-rose-500 shadow-[0_0_10px_rgba(225,29,72,0.5)]' : 'bg-emerald-500'"></div>

                    <h3 class="font-bold text-sm uppercase tracking-widest flex items-center mb-6 shrink-0 transition-colors" :class="attackStatus === 'success' ? 'text-rose-400' : 'text-emerald-400'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Systémová Obrana & WebAuthn
                    </h3>

                    <div class="flex-1 flex flex-col items-center justify-start relative w-full mb-6 min-h-[160px]">

                        {{-- Vizuální signalizace výsledku --}}
                        <div class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-500 z-20">
                            
                            {{-- Idle stav --}}
                            <div x-show="attackStatus === 'idle' && !isAttacking" class="text-slate-500 flex flex-col items-center animate-fade-in opacity-50">
                                <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-mono text-xs uppercase tracking-widest">Čekám na spuštění vektoru...</span>
                            </div>

                            {{-- Útok probíhá --}}
                            <div x-show="isAttacking" class="bg-slate-900/80 backdrop-blur-sm p-6 rounded-2xl border border-slate-700 animate-pulse text-center">
                                <svg class="w-10 h-10 text-indigo-400 mx-auto mb-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                <p class="text-xs font-bold text-slate-200 tracking-wider">Vyhodnocování API požadavků...</p>
                            </div>

                            {{-- Blokováno (Defended) --}}
                            <div x-show="attackStatus === 'blocked'" style="display: none;" class="animate-fade-in bg-emerald-900/40 border border-emerald-500/50 rounded-2xl p-6 w-full text-center shadow-[0_0_30px_rgba(16,185,129,0.15)] flex flex-col items-center">
                                <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <span class="text-emerald-500 font-black text-2xl tracking-widest uppercase">ATTACK BLOCKED</span>
                                <p class="text-xs text-emerald-400 mt-2 font-bold" x-text="attackVector === 'aitm' ? 'Origin Binding Check: Doména nesouhlasí s rpId.' : 'User Verification Fail: PIN nebyl zadán.'"></p>
                            </div>

                            {{-- Hacknuto (Breached) --}}
                            <div x-show="attackStatus === 'success'" style="display: none;" class="animate-fade-in bg-rose-900/40 border border-rose-500/50 rounded-2xl p-6 w-full text-center shadow-[0_0_30px_rgba(225,29,72,0.15)] flex flex-col items-center">
                                <div class="w-12 h-12 bg-rose-500/20 text-rose-400 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <span class="text-rose-500 font-black text-2xl tracking-widest uppercase">SYSTEM COMPROMISED</span>
                                <p class="text-xs text-rose-400 mt-2 font-bold" x-text="attackVector === 'hijack' ? 'Session Cookie ukradena. FIDO2 obejito.' : 'Klíč chránil jen dotykem (UV disabled). Zneužito.'"></p>
                            </div>

                        </div>
                    </div>

                    {{-- Terminál obránce --}}
                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-56 overflow-y-auto flex flex-col font-mono text-[10px] sm:text-xs shrink-0 relative transition-colors duration-500" :class="attackStatus === 'success' ? 'border-rose-500/30 bg-rose-950/20' : ''">
                        <div class="text-slate-500 mb-2 flex justify-between">
                            <span>// SECURITY_LOGS</span>
                            <span x-show="attackStatus === 'blocked'" style="display: none;" class="text-emerald-400 font-bold">STATUS: PROTECTED</span>
                            <span x-show="attackStatus === 'success'" style="display: none;" class="text-rose-400 font-bold">STATUS: BREACHED</span>
                        </div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in leading-relaxed" :class="{
                                'text-slate-300': log.type === 'info',
                                'text-emerald-400 font-bold': log.type === 'success',
                                'text-rose-400 font-bold': log.type === 'error',
                                'text-amber-400': log.type === 'warn'
                            }">
                                <span class="opacity-50 mr-2">>></span>
                                <span x-text="log.msg"></span>
                            </div>
                        </template>
                    </div>

                </div>

            </div>

            {{-- Tlačítko pro pokračování na lekci (Aktivuje se vždy, útok neomezuje progress u sandboxů) --}}
            <div class="mt-8 flex justify-end" x-show="attackStatus !== 'idle' && !isAttacking" style="display: none;" x-transition>
                <form action="{{  route($module->getSimulationLessonsRoute(), ['module' => $module->slug]) }}" method="GET">
                    @csrf
                    <button type="submit" class="group bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-[0_0_20px_rgba(99,102,241,0.4)] flex items-center">
                        Přejít na analýzu zranitelností
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function fidoAttackSimulation() {
            // Zkusíme načíst konfiguraci z URL (ze setup screenu)
            const urlParams = new URLSearchParams(window.location.search);
            const initialUv = urlParams.get('config_uv') || 'required';

            return {
                isAttacking: false,
                attackStatus: 'idle', // 'idle', 'blocked', 'success'
                attackVector: 'aitm', // 'aitm', 'theft', 'hijack'
                victimUv: initialUv,
                logs: [],

                init() {
                    this.$watch('attackVector', () => { this.reset(); });
                    this.$watch('victimUv', () => { this.reset(); });
                },

                reset() {
                    this.isAttacking = false;
                    this.attackStatus = 'idle';
                    this.logs = [];
                },

                startAttack() {
                    this.isAttacking = true;
                    this.attackStatus = 'checking';
                    this.logs = [];
                    
                    if (this.attackVector === 'aitm') {
                        this.logs.push({ type: 'warn', msg: '[PROXY] Přeposílám bankovní Challenge na "securebanka.cz"...' });
                        setTimeout(() => this.logs.push({ type: 'info', msg: '[BROWSER_API] Volání navigator.credentials.get() zachyceno.' }), 800);
                        setTimeout(() => this.logs.push({ type: 'info', msg: '[CORE_SEC] Verifikace původu (Origin Binding check)...' }), 1500);
                        setTimeout(() => this.logs.push({ type: 'error', msg: `[FATAL] Mismatch! Validní rpId="securebank.cz" NESOUHLASÍ s URL="securebanka.cz"` }), 2400);
                        setTimeout(() => {
                            this.attackStatus = 'blocked';
                            this.isAttacking = false;
                            this.logs.push({ type: 'success', msg: '[DEFENSE] DOMException odmítnuta. HW klíč nebyl vůbec aktivován.' });
                            this.scrollLogs();
                        }, 3400);
                    } 
                    else if (this.attackVector === 'theft') {
                        this.logs.push({ type: 'warn', msg: '[THEFT] Získal jsem fyzický klíč (YubiKey) a připojuji k PC.' });
                        setTimeout(() => this.logs.push({ type: 'info', msg: `[HARDWARE] Prověřuji nastavení User Verification na klíči...` }), 800);
                        
                        setTimeout(() => {
                            if (this.victimUv === 'required') {
                                this.logs.push({ type: 'info', msg: '[HARDWARE] UV=required: Vyžaduji interní PIN klíče (CTAP2_ERR_PIN_REQUIRED).' });
                                setTimeout(() => {
                                    this.logs.push({ type: 'error', msg: '[ATTACKER] Neznám PIN! Nemohu provést podpis.' });
                                    this.attackStatus = 'blocked';
                                    this.isAttacking = false;
                                    this.scrollLogs();
                                }, 1000);
                            } else {
                                this.logs.push({ type: 'warn', msg: '[HARDWARE] UV=discouraged: Ochrana PINem vypnuta.' });
                                setTimeout(() => {
                                    this.logs.push({ type: 'success', msg: '[ATTACKER] Pouze dotyk prstem. Podpis úspěšně vygenerován!' });
                                    this.attackStatus = 'success';
                                    this.isAttacking = false;
                                    this.scrollLogs();
                                }, 1000);
                            }
                        }, 1800);
                    }
                    else if (this.attackVector === 'hijack') {
                        this.logs.push({ type: 'info', msg: '[SYSTEM] Původní uživatel se úspěšně přihlásil přes FIDO2.' });
                        setTimeout(() => this.logs.push({ type: 'info', msg: '[SYSTEM] Vydán autentizační token: PHPSESSID=x7a99f...' }), 1000);
                        setTimeout(() => this.logs.push({ type: 'error', msg: '[MALWARE] Proveden InfoStealer útok. Session Cookie byla odeslána na C2 server!' }), 2200);
                        setTimeout(() => this.logs.push({ type: 'warn', msg: '[ATTACKER] Vkládám odcizenou cookie do svého prohlížeče (Pass-the-Cookie).' }), 3200);
                        setTimeout(() => {
                            this.attackStatus = 'success';
                            this.isAttacking = false;
                            this.logs.push({ type: 'error', msg: '[BREACH] Server vidí validní session. Autorizace udělena. FIDO2 je u konce své působnosti.' });
                            this.scrollLogs();
                        }, 4500);
                    }
                },

                scrollLogs() {
                    this.$nextTick(() => {
                        const logContainer = document.querySelector('.overflow-y-auto');
                        if(logContainer) logContainer.scrollTop = logContainer.scrollHeight;
                    });
                }
            }
        }
    </script>
</x-app-layout>
