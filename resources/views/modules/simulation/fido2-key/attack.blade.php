<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $module->title }} - Simulace: Selhání AitM útoku
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

            {{-- Teoretický úvod v Indigo stylu --}}
            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50 mb-8 transition-all">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-2">
                            Adversary-in-the-Middle (AitM) vs. Origin Binding
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed mb-4">
                            V minulé simulaci TOTP byl útočník schopen zachytit kód na podvržené doméně a ihned jej použít. Zde si vyzkoušíme identický scénář proti FIDO2. Útočník vytvořil phishingovou stránku <strong>securebanka.cz</strong> (všimněte si překlepu) a přes transparentní proxy (AitM) se snaží donutit prohlížeč oběti k podepsání přihlašovací výzvy (Challenge) vygenerované pro legitimní banku.
                        </p>
                        <div class="p-3 bg-indigo-950/50 rounded-lg border border-indigo-500/20 text-xs text-indigo-200">
                            <strong>Pozorujte rozdíl:</strong> U TOTP jste vy jako uživatel neviděli, na jakou doménu posíláte data. Zde roli hlídače přebírá samotný prohlížeč, který porovná doménu v adresním řádku s tou, pro kterou byl registrován fyzický klíč.
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                {{-- LEVÝ SLOUPEC: Útočník (Phishingová proxy) --}}
                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border-t-4 border-rose-500 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                        <svg class="w-32 h-32 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                    </div>

                    <h3 class="text-rose-500 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        // AITM_PROXY: ACTIVE
                    </h3>

                    <div class="flex-1 flex flex-col justify-start items-center z-10 space-y-6">

                        {{-- Detaily útoku (Lepší popis vektorů) --}}
                        <div class="text-left space-y-5 bg-slate-900/80 p-5 rounded-xl border border-slate-700/50 w-full shadow-inner mt-4">
                            <div>
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-4 h-4 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <p class="text-rose-400 font-mono text-xs font-bold uppercase tracking-wider">Cílová doména útočníka</p>
                                </div>
                                <div class="font-mono text-lg text-slate-300 bg-slate-950 p-3 rounded-lg text-center border border-rose-500/30 shadow-inner mt-2">
                                    https://www.<span class="text-rose-500 font-bold underline">securebanka</span>.cz
                                </div>
                            </div>

                            <div class="w-full h-px bg-slate-800"></div>

                            <div>
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-4 h-4 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                    <p class="text-slate-300 font-mono text-xs font-bold uppercase tracking-wider">Modus Operandi (AitM)</p>
                                </div>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed pl-6">
                                    Proxy server obdržel od reálné banky aktuální kryptografickou výzvu (Challenge). Nyní tuto výzvu přeposílá do phishingového rozhraní zobrazeného oběti. Očekáváme, že se oběť pokusí přihlásit (dotykem klíče) a my tím získáme validní podpis pro reálnou banku.
                                </p>
                            </div>
                        </div>

                        {{-- Přenosový payload --}}
                        <div class="w-full bg-slate-900/80 p-4 rounded-xl border border-slate-700/50 shadow-inner font-mono text-[10px] text-slate-300 relative">
                            <div class="absolute right-3 top-3 text-[8px] bg-rose-500/20 text-rose-400 px-1.5 py-0.5 rounded uppercase font-bold tracking-widest">Injected API Call</div>
                            <div class="text-slate-500 mb-3">// PAYLOAD_TO_VICTIM_BROWSER</div>
                            <p><span class="text-indigo-400">const</span> options = {</p>
                            <p class="pl-4">challenge: <span class="text-amber-300">"a7c8f93...b21"</span>,</p>
                            <p class="pl-4">rpId: <span class="text-rose-400 font-bold">"securebank.cz"</span> <span class="text-slate-500">// Vydáváme se za pravou banku</span></p>
                            <p>};</p>
                        </div>

                    </div>

                    <button @click="startAttack()" :disabled="isAttacking" class="mt-6 w-full bg-rose-600 hover:bg-rose-500 disabled:bg-slate-800 disabled:text-slate-600 text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all transform hover:-translate-y-1 shadow-[0_0_15px_rgba(225,29,72,0.4)] disabled:shadow-none disabled:transform-none flex items-center justify-center group">
                        <span x-show="!isAttacking">[ Vnutit výzvu oběti (Inject Challenge) ]</span>
                        <span x-show="isAttacking" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Čekám na uživatelův podpis...
                        </span>
                    </button>
                </div>

                {{-- PRAVÝ SLOUPEC: Oběť (Prohlížeč & Autentizátor) --}}
                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1/3 h-1 bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)] rounded-tl-3xl"></div>

                    <h3 class="text-emerald-400 font-bold text-sm uppercase tracking-widest flex items-center mb-6 shrink-0">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        WebAuthn API: Origin Check
                    </h3>

                    <div class="flex-1 flex flex-col items-center justify-start relative w-full">

                        {{-- Realistická ukázka Phishingového prohlížeče --}}
                        <div class="w-full rounded-xl overflow-hidden shadow-[0_10px_30px_rgba(0,0,0,0.5)] border border-slate-700 mb-6 flex flex-col transition-all duration-500"
                             :class="attackStatus === 'blocked' ? 'grayscale opacity-60' : ''">

                            {{-- Falešný adresní řádek --}}
                            <div class="bg-slate-900 px-4 py-3 border-b border-slate-800 flex items-center justify-center relative">
                                <div class="absolute left-4 flex space-x-1.5">
                                    <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                </div>
                                <div class="bg-slate-950 px-4 py-1.5 rounded-lg flex items-center w-2/3 max-w-sm justify-center font-mono text-xs border border-rose-500/30">
                                    <svg class="w-3.5 h-3.5 text-slate-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                    <span class="text-slate-400">https://</span><span class="text-rose-400 font-bold">securebanka</span><span class="text-slate-400">.cz</span>
                                </div>
                            </div>

                            {{-- Falešné UI banky --}}
                            <div class="bg-white p-6 flex flex-col items-center justify-center relative min-h-[160px]">
                                {{-- Fake logo --}}
                                <div class="text-slate-800 font-black text-xl mb-4 flex items-center tracking-tighter">
                                    <div class="w-6 h-6 bg-indigo-600 rounded mr-2 flex items-center justify-center text-white text-xs">SB</div>
                                    SecureBank
                                </div>
                                <div class="text-center w-full">
                                    <p class="text-sm text-slate-500 font-medium mb-4">Přihlaste se pomocí bezpečnostního klíče</p>

                                    {{-- Animace dialogu OS --}}
                                    <div x-show="isAttacking && attackStatus === 'checking'" class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-20">
                                        <div class="bg-slate-800 rounded-xl p-4 shadow-2xl border border-slate-700 animate-bounce text-center">
                                            <svg class="w-8 h-8 text-indigo-400 mx-auto mb-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                            <p class="text-xs font-bold text-slate-200">Vyvolávám OS dialog...</p>
                                        </div>
                                    </div>

                                    <button class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-bold opacity-80 cursor-not-allowed w-full max-w-xs">
                                        Autentizovat klíčem
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Analýza parametrů (Kryptografické veto) - Vysvětlení --}}
                        <div class="w-full bg-slate-900/60 p-4 rounded-xl border border-slate-700/50 mb-6 shadow-inner flex items-center shrink-0">
                            <div class="bg-emerald-500/20 p-2 rounded-lg text-emerald-400 mr-3 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <p class="text-emerald-400 font-mono text-xs font-bold uppercase tracking-wider mb-1">Bezpečnostní kontrola prohlížeče</p>
                                <p class="text-slate-400 font-mono text-[10px] leading-relaxed">
                                    Před předáním požadavku do HW klíče prohlížeč automaticky validuje, zda hodnota <span class="text-amber-400">rpId</span> (požadovaná doména z payloadu) odpovídá skutečné doméně v adresním řádku. Uživatel tuto kontrolu nemůže nijak obejít.
                                </p>
                            </div>
                        </div>

                        {{-- Finální verdikt velkým písmem --}}
                        <div class="text-center h-20 shrink-0 flex items-center justify-center w-full">
                            <template x-if="attackStatus === 'blocked'">
                                <div class="animate-fade-in bg-emerald-900/40 border border-emerald-500/50 rounded-2xl p-4 w-full">
                                    <span class="text-emerald-500 font-black text-2xl tracking-widest uppercase">ATTACK BLOCKED</span>
                                    <p class="text-xs text-emerald-400 mt-1 font-bold">Z důvodu neshody rpId vs Origin prohlížeč odmítl komunikovat s HW klíčem.</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Terminál obránce --}}
                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-44 overflow-y-auto font-mono text-[10px] sm:text-xs mt-auto shrink-0 relative">
                        <div class="text-slate-500 mb-2 flex justify-between">
                            <span>// BROWSER_CONSOLE_LOGS</span>
                            <span x-show="attackStatus === 'blocked'" class="text-emerald-400 font-bold">STATUS: REJECTED</span>
                        </div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in leading-relaxed" :class="{
                                'text-slate-300': log.type === 'info',
                                'text-emerald-400': log.type === 'success',
                                'text-rose-400 font-bold': log.type === 'error',
                                'text-amber-400': log.type === 'warn'
                            }">
                                <span class="opacity-50 mr-2">>></span>
                                <span x-text="log.msg"></span>
                            </div>
                        </template>
                        <div x-show="isAttacking && attackStatus === 'checking'" class="text-indigo-400 animate-pulse mt-2">
                            <span class="opacity-50 mr-2">>></span>
                            Evaluating navigator.credentials.get() request...
                        </div>
                    </div>

                </div>

            </div>

            {{-- Tlačítko pro pokračování na lekci --}}
            <div class="mt-8 flex justify-end" x-show="attackStatus === 'blocked'" x-transition>
                <form action="{{  route($module->getSimulationLessonsRoute(), ['module' => $module->slug]) }}" method="GET">
                    @csrf
                    <button type="submit" class="group bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-105 shadow-[0_0_20px_rgba(99,102,241,0.4)] flex items-center">
                        Přejít na analýzu obrany
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function fidoAttackSimulation() {
            return {
                isAttacking: false,
                attackStatus: 'idle', // idle, checking, blocked
                logs: [],

                startAttack() {
                    this.isAttacking = true;
                    this.attackStatus = 'checking';
                    this.logs = [{ type: 'warn', msg: '[AITM] Přeposílám injektovanou výzvu (Challenge) oběti...' }];

                    setTimeout(() => {
                        this.logs.push({ type: 'info', msg: '[BROWSER_API] Detekováno volání navigator.credentials.get().' });
                    }, 800);

                    setTimeout(() => {
                        this.logs.push({ type: 'info', msg: '[CORE_SEC] Zahajuji verifikaci původu (Origin Binding check)...' });
                    }, 1500);

                    setTimeout(() => {
                        this.logs.push({ type: 'error', msg: `[FATAL] Mismatch! Požadované rpId: "securebank.cz" != Doména: "securebanka.cz"` });
                    }, 2400);

                    setTimeout(() => {
                        this.attackStatus = 'blocked';
                        this.isAttacking = false;
                        this.logs.push({ type: 'success', msg: '[SECURE] DOMException: The relying party ID is not a valid domain for this origin.' });
                        this.logs.push({ type: 'success', msg: '[SECURE] Fyzický HW klíč (CTAP2) nebyl vůbec kontaktován. Signatura odmítnuta.' });

                        this.$nextTick(() => {
                            const logContainer = document.querySelector('.overflow-y-auto');
                            if(logContainer) logContainer.scrollTop = logContainer.scrollHeight;
                        });
                    }, 3400);
                }
            }
        }
    </script>
</x-app-layout>
