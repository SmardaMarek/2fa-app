<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Experiment: AitM & Replay Attack</span>
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

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300" x-data="totpSandbox()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-3">
                            Průvodce experimentem: Odhalení slabin TOTP
                        </h3>
                        <div class="text-sm text-slate-300 space-y-5 leading-relaxed">
                            <p>
                                Cílem této simulace je v praxi předvést, proč je samotný 6místný kód zranitelný. Vyzkoušíte si roli oběti, útočníka i administrátora banky. Server banky totiž standardně vidí pouze čísla a nedokáže sám od sebe poznat, z jaké webové stránky byla odeslána.
                            </p>

                            <div>
                                <p class="font-bold text-indigo-200 mb-3">
                                    Pro úspěšné dokončení experimentu postupujte podle těchto kroků:
                                </p>
                                <ul class="space-y-4">
                                    <li class="flex items-start">
                                        <span class="bg-indigo-500/20 text-indigo-400 font-mono text-[10px] font-bold w-6 h-6 flex items-center justify-center rounded mr-3 mt-0.5 shrink-0 border border-indigo-500/30">1</span>
                                        <span>
                                <strong class="text-slate-200">Test Origin Bindingu (Phishing):</strong> V levém panelu vygenerujte kód a klikněte na „Přihlásit se“. Útočník uprostřed kód zachytí na falešné doméně a přepošle jej bance. Sledujte, že banka kód přijme.
                            </span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-indigo-500/20 text-indigo-400 font-mono text-[10px] font-bold w-6 h-6 flex items-center justify-center rounded mr-3 mt-0.5 shrink-0 border border-indigo-500/30">2</span>
                                        <span>
                                <strong class="text-slate-200">Amnézie serveru (Replay Attack):</strong> Nyní, když útočník drží platný kód, klikněte ve středním panelu na <em>Spustit Replay Útok</em>. Sledujte v terminálu banky (vpravo), jak nechráněný server přijme stejný kód podruhé.
                            </span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="bg-indigo-500/20 text-indigo-400 font-mono text-[10px] font-bold w-6 h-6 flex items-center justify-center rounded mr-3 mt-0.5 shrink-0 border border-indigo-500/30">3</span>
                                        <span>
                                <strong class="text-slate-200">Nasazení obrany (Ochranná opatření):</strong> Staňte se obráncem. V pravém panelu zapněte <strong>Stavovou paměť (Cache)</strong>. Vygenerujte si vlevo nový kód a zopakujte celý útok. Server si nyní kód "zapamatuje" a pokus o Replay zablokuje.
                            </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch mt-8">

                {{-- LEVÁ ČÁST: Veřejná síť (Oběť a Útočník) - 7 sloupců --}}
                <div class="lg:col-span-7 flex flex-col space-y-6">

                    {{-- Box Oběti --}}
                    <div class="bg-slate-800/50 rounded-3xl p-8 border border-slate-700 relative transition-all duration-300 shadow-xl"
                         :class="state === 'start' ? 'ring-2 ring-indigo-500/50' : 'opacity-75'">
                        <h3 class="text-slate-300 font-bold text-sm mb-6 tracking-tighter uppercase flex items-center">
                            <svg class="w-5 h-5 mr-3 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                            Pohled oběti (Prohlížeč)
                        </h3>

                        {{-- Falešný prohlížeč --}}
                        <div class="bg-slate-950 rounded-2xl border border-rose-500/30 p-4 mb-6 shadow-inner">
                            <span class="text-xs text-slate-500 font-bold block mb-2 uppercase tracking-widest">Adresní řádek (Phishing):</span>
                            <div class="text-rose-400 font-mono text-sm bg-rose-500/10 p-3 rounded-xl flex items-center">
                                <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                https://www.<span class="font-black underline">g00gle</span>.com/login
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="flex-1">
                                <div class="relative h-full">
                                    <input type="text" x-model="generatedCode" readonly class="w-full h-full bg-slate-900 border border-slate-700 text-slate-300 text-center font-mono text-4xl font-black rounded-xl tracking-[0.3em] shadow-inner" placeholder="------">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <button @click="generateAndFill()" class="text-[10px] bg-slate-700 hover:bg-slate-600 text-white px-3 py-2 rounded-lg font-bold uppercase transition-colors">
                                            Generovat
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button @click="submitPhishing()" :disabled="!generatedCode || state !== 'start'" class="bg-indigo-600 hover:bg-indigo-500 disabled:bg-slate-800 disabled:text-slate-600 text-white px-8 py-5 rounded-xl font-black uppercase text-sm tracking-widest transition-all shadow-lg hover:-translate-y-0.5 disabled:transform-none disabled:shadow-none">
                                Přihlásit se
                            </button>
                        </div>
                    </div>

                    {{-- Vizuální šipka toku dat --}}
                    <div class="flex justify-center -my-3 z-10 relative">
                        <div class="bg-slate-900 p-3 rounded-full border-2 border-slate-700 text-slate-500 shadow-xl" :class="state !== 'start' ? 'text-rose-500 border-rose-500/50 bg-rose-500/10' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                    </div>

                    {{-- Box Útočníka --}}
                    <div class="bg-slate-950 rounded-3xl p-8 border border-rose-500/50 shadow-2xl relative transition-all duration-300"
                         :class="(state === 'replay' || state === 'defense') ? 'ring-2 ring-rose-500/50 shadow-[0_0_30px_rgba(225,29,72,0.15)]' : ''">
                        <h3 class="text-rose-500 font-mono font-bold text-sm mb-6 tracking-tighter uppercase flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                Útočník (AitM Proxy)
                            </div>
                            <span x-show="capturedCode" class="text-xs font-bold bg-rose-500/20 px-3 py-1 rounded-lg text-rose-400 border border-rose-500/30 animate-pulse">Data zachycena</span>
                        </h3>

                        <div class="flex flex-col sm:flex-row gap-6 items-stretch">
                            <div class="flex-1 bg-slate-900 rounded-2xl p-6 border border-slate-800 flex flex-col items-center justify-center shadow-inner">
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-widest mb-3">Zachycený TOTP Kód</span>
                                <span class="text-rose-400 font-mono text-4xl font-black tracking-[0.2em]" x-text="capturedCode || '------'"></span>
                            </div>
                            <div class="flex-1 flex flex-col justify-center space-y-3">
                                <button @click="executeReplay()" :disabled="!capturedCode" class="w-full h-full min-h-[80px] bg-rose-600 hover:bg-rose-500 disabled:bg-slate-800 disabled:text-slate-600 text-white py-4 rounded-2xl font-black uppercase text-sm tracking-widest transition-transform shadow-xl disabled:shadow-none hover:-translate-y-1">
                                    Spustit Replay Útok
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PRAVÁ ČÁST: Server (Obránce) - 5 sloupců --}}
                <div class="lg:col-span-5 bg-slate-800/60 backdrop-blur-md rounded-3xl p-8 border-t-4 shadow-2xl flex flex-col h-full transition-colors duration-500"
                     :class="config.cache ? 'border-emerald-500 ring-2 ring-emerald-500/30' : 'border-slate-600'">

                    <h3 class="text-emerald-400 font-mono font-bold text-sm mb-8 tracking-tighter uppercase flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                        Backend Server Banky
                    </h3>

                    {{-- Konfigurace --}}
                    <div class="space-y-6 mb-8">
                        {{-- Cache Toggle --}}
                        <div class="bg-slate-900/80 p-5 rounded-2xl border transition-colors duration-300 shadow-inner" :class="config.cache ? 'border-emerald-500/50' : 'border-slate-700'">
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-sm font-bold text-slate-200 uppercase tracking-wider">Stavová paměť (Cache)</label>
                                <button @click="toggleCache()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none" :class="config.cache ? 'bg-emerald-500' : 'bg-slate-600'">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform" :class="config.cache ? 'translate-x-6' : 'translate-x-1'"></span>
                                </button>
                            </div>
                            <div class="text-xs text-slate-400 mb-4 leading-relaxed">Ukládá použité kódy pro zamezení Replay útoků.</div>

                            {{-- Zobrazení paměti --}}
                            <div class="bg-slate-950 p-3 rounded-xl text-xs font-mono min-h-[40px] flex items-center border border-slate-800">
                                <span class="text-slate-600 mr-3 font-bold">STORE:</span>
                                <span x-show="!config.cache" class="text-rose-400 font-bold uppercase tracking-wider">Vypnuto (Zranitelné)</span>
                                <span x-show="config.cache && usedCodes.length === 0" class="text-slate-500 italic">Prázdné</span>
                                <div x-show="config.cache && usedCodes.length > 0" class="flex flex-wrap gap-2">
                                    <template x-for="code in usedCodes">
                                        <span class="text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20 font-bold" x-text="code"></span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Time Drift --}}
                        <div class="bg-slate-900/80 p-5 rounded-2xl border border-slate-700 shadow-inner">
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tolerance zpoždění sítě</label>
                                <span class="text-xs font-mono text-indigo-400 font-bold bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20">± <span x-text="config.window"></span> krok(y)</span>
                            </div>
                            <input type="range" min="0" max="2" x-model.number="config.window" class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-indigo-500 mt-2">
                        </div>
                    </div>

                    {{-- Server Terminal --}}
                    <div class="bg-slate-950 rounded-2xl p-5 border border-slate-800 flex-1 flex flex-col relative overflow-hidden min-h-[250px] shadow-inner">
                        <div class="flex justify-between items-center border-b border-slate-800 pb-3 mb-3 shrink-0">
                            <span class="text-xs text-slate-500 font-mono uppercase tracking-widest font-bold">// Validation Logs</span>
                            <span class="text-indigo-400 font-mono text-xs font-bold bg-indigo-500/10 px-2 py-1 rounded" x-text="'Čas Serveru: T+' + timeStep"></span>
                        </div>
                        <div class="flex-1 overflow-y-auto space-y-2 pr-2" x-ref="bankLogs">
                            <template x-for="(log, i) in serverLogs" :key="i">
                                <div class="text-xs font-mono animate-fade-in leading-relaxed" :class="{
                                    'text-slate-300': log.type === 'info',
                                    'text-emerald-400 font-bold': log.type === 'success',
                                    'text-rose-400 font-bold bg-rose-500/10 p-1.5 rounded border border-rose-500/20': log.type === 'error',
                                    'text-amber-400': log.type === 'warn'
                                }">
                                    <span class="opacity-50">></span> <span x-text="log.msg"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Navigační patička (Aktivuje se až po testu obrany) --}}
            <div class="mt-8 flex justify-end" x-show="state === 'done'" x-transition>
                <form action="{{ route($module->getSimulationLessonsRoute(), ['module' => $module->slug]) }}" method="GET">
                    @csrf
                    <button type="submit" class="group bg-indigo-600 hover:bg-indigo-500 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-[0_0_20px_rgba(99,102,241,0.4)] flex items-center text-sm">
                        Pokračovat na analýzu ochranných opatření
                        <svg class="ml-3 w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        function totpSandbox() {
            return {
                state: 'start', // start, replay, defense, done
                config: { window: 1, cache: false },
                timeStep: 0,
                validCodes: [],
                usedCodes: [],
                generatedCode: '',
                capturedCode: '',
                serverLogs: [{type: 'info', msg: 'System ready. Waiting for auth requests...'}],

                init() {
                    setInterval(() => {
                        this.timeStep++;
                        if(this.timeStep % 3 === 0) this.usedCodes = []; // Simulace expirace oken
                    }, 10000);
                },

                generateAndFill() {
                    const code = Math.floor(100000 + Math.random() * 900000).toString();
                    this.validCodes.push({ code: code, step: this.timeStep });
                    this.generatedCode = code;
                },

                submitPhishing() {
                    this.capturedCode = this.generatedCode;
                    this.generatedCode = '';

                    this.serverLogs.push({type: 'warn', msg: `[AITM PROXY] Požadavek přijat z neověřené domény. Přeposílám kód ${this.capturedCode}`});
                    this.verifyOnServer(this.capturedCode, 'first_use');

                    this.state = 'replay';
                },

                executeReplay() {
                    this.serverLogs.push({type: 'warn', msg: `[REPLAY ATTACK] Odesílám kód ${this.capturedCode} podruhé...`});
                    this.verifyOnServer(this.capturedCode, 'replay');

                    if (!this.config.cache) {
                        this.state = 'defense';
                    } else {
                        this.state = 'done';
                    }
                },

                toggleCache() {
                    this.config.cache = !this.config.cache;
                    if(this.config.cache) {
                        this.state = 'start';
                        this.capturedCode = '';
                        this.serverLogs.push({type: 'info', msg: '--- STAVOVÁ OBRANA AKTIVOVÁNA ---'});
                        this.serverLogs.push({type: 'info', msg: 'Zkuste vygenerovat nový kód a útok zopakovat.'});
                        this.scrollToBottom();
                    }
                },

                verifyOnServer(code, type) {
                    setTimeout(() => {
                        const validEntry = this.validCodes.find(c => c.code === code);

                        if (!validEntry || Math.abs(this.timeStep - validEntry.step) > this.config.window) {
                            this.serverLogs.push({type: 'error', msg: `ZAMÍTNUTO: Neplatný nebo vypršelý kód.`});
                            return this.scrollToBottom();
                        }

                        if (this.config.cache) {
                            if (this.usedCodes.includes(code)) {
                                this.serverLogs.push({type: 'success', msg: `ZABLOKOVÁNO: Replay detekován! (Kód nalezen v paměti)`});
                                this.state = 'done';
                                return this.scrollToBottom();
                            } else {
                                this.usedCodes.push(code);
                            }
                        }

                        if (type === 'first_use') {
                            this.serverLogs.push({type: 'error', msg: `CRITICAL: Přihlášení povoleno (Ověřena matematika, Origin Binding chybí!)`});
                        } else if (type === 'replay') {
                            this.serverLogs.push({type: 'error', msg: `CRITICAL: Replay útok úspěšný! Server kód akceptoval znovu.`});
                        }

                        this.scrollToBottom();
                    }, 600);
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = this.$refs.bankLogs;
                        if(container) container.scrollTop = container.scrollHeight;
                    });
                }
            }
        }
    </script>
</x-app-layout>
