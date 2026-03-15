<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $module->title }} - Simulace: Presentation Attack (2D vs 3D)
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

    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50">
            <div class="flex items-start">
                <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-4 flex-1">
                    <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-3">
                        Cíl experimentu: Testování Liveness Detection (Detekce živosti)
                    </h3>
                    <div class="text-sm text-slate-300 space-y-4 leading-relaxed">
                        <p>
                            Cílem této simulace je prakticky demonstrovat zranitelnost biometrických systémů vůči tzv. <strong>Presentation Attack (Spoofing)</strong>. V roli útočníka jste získali kvalitní, statickou fotografii oběti (např. z veřejného profilu na sociálních sítích) a pokusíte se ji použít k neoprávněnému přihlášení.
                        </p>
                        <p>
                            Experiment proveďte ve dvou fázích a sledujte rozdílné reakce systému:
                        </p>
                        <ol class="list-decimal list-inside space-y-2 pl-2">
                            <li>
                                <strong>Fáze 1 (Útok na 2D Kameru):</strong> Zaútočte na běžný senzor, který spoléhá pouze na analýzu obrazu (RGB). Sledujte, zda systém dokáže odlišit živou tvář od ploché fotografie pouze na základě vizuální shody rysů.
                            </li>
                            <li>
                                <strong>Fáze 2 (Útok na 3D IR/Depth):</strong> Přepněte na pokročilý senzor vybavený hloubkovou analýzou (infračervený projektor/LiDAR). Pozorujte, jak aktivní detekce živosti (PAD - Presentation Attack Detection) reaguje na statický, plochý předmět.
                            </li>
                        </ol>
                        <p class="font-semibold text-indigo-200 mt-2">
                            Sledujte výpisy v terminálu (vpravo dole) a všímejte si, jaké metriky rozhodují o úspěchu či selhání autentizace.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="py-8" x-data="biometricSimulation()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border-t-4 border-rose-500 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5 pointer-events-none">
                        <svg class="w-32 h-32 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                    </div>

                    <h3 class="text-rose-500 font-mono font-bold text-sm mb-8 tracking-tighter flex items-center z-10">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        // ATTACK_VECTOR: SPOOFING_2D_IMAGE
                    </h3>

                    <div class="flex-1 flex flex-col justify-start items-center z-10 space-y-8">

                        <div class="relative w-64 h-64 bg-slate-900 rounded-2xl border-2 border-slate-700 overflow-hidden shadow-lg flex items-center justify-center group shrink-0">
                            <img src="{{ asset('img/generated_person.png') }}" alt="Stolen target photo" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-300">

                            <div class="absolute bottom-0 inset-x-0 bg-slate-900/90 text-[10px] text-rose-400 font-mono text-center py-2 border-t border-slate-700">
                                PAYLOAD: target_highres_photo.jpg (4K Resolution)
                            </div>
                        </div>

                        <div class="text-left space-y-5 bg-slate-900/80 p-5 rounded-xl border border-slate-700/50 w-full shadow-inner mt-4">

                            <div>
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-4 h-4 text-rose-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <p class="text-rose-400 font-mono text-xs font-bold uppercase tracking-wider">1. Vektor útoku (Execution)</p>
                                </div>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed pl-6">
                                    Fyzická prezentace statického vizuálního payloadu (fotografie oběti s vysokým rozlišením) do zorného pole optického senzoru cílového zařízení.
                                </p>
                            </div>

                            <div class="w-full h-px bg-slate-800"></div>

                            <div>
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-4 h-4 text-indigo-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                                    <p class="text-slate-300 font-mono text-xs font-bold uppercase tracking-wider">2. Zranitelnost 2D RGB kamer</p>
                                </div>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed pl-6">
                                    Běžné kamery extrahují pouze dvourozměrné vektory (osy X a Y). Vzdálenost očí a tvar čelisti na fotografii dokonale odpovídají realitě. Bez hardwarové kontroly živosti vypočítá systém validní hash a útočníka akceptuje.
                                </p>
                            </div>

                            <div class="w-full h-px bg-slate-800"></div>

                            <div>
                                <div class="flex items-center mb-1.5">
                                    <svg class="w-4 h-4 text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                                    <p class="text-slate-300 font-mono text-xs font-bold uppercase tracking-wider">3. Obrana 3D senzorem (PAD)</p>
                                </div>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed pl-6">
                                    Pokročilé senzory využívají infračervený projektor k vytvoření hloubkové mapy (osa Z). Fotografie postrádá hloubku (Z = 0). Ochranný modul PAD (<span class="italic">Presentation Attack Detection</span>) tak okamžitě odhalí plochý objekt a útok zablokuje.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="mt-auto z-10 pt-6">
                        <button
                            @click="startAttack()"
                            :disabled="attackStatus === 'scanning'"
                            class="w-full bg-rose-600 hover:bg-rose-500 disabled:bg-slate-800 disabled:text-slate-500 text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all transform hover:-translate-y-1 shadow-[0_0_15px_rgba(225,29,72,0.4)] disabled:shadow-none disabled:transform-none flex items-center justify-center group"
                        >
                            <span x-show="attackStatus !== 'scanning'">[ EXECUTE: Inject Visual Payload ]</span>
                            <span x-show="attackStatus === 'scanning'" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Sending data stream...
                            </span>
                        </button>
                    </div>
                </div>

                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative">
                    <div class="absolute top-0 left-0 w-1/3 h-1 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] rounded-tl-3xl"></div>

                    <div class="flex justify-between items-center mb-8 shrink-0">
                        <h3 class="text-indigo-400 font-bold text-sm uppercase tracking-widest flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m14-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            Target System: Secure Enclave
                        </h3>

                        <div class="flex bg-slate-900 rounded-xl p-1 border border-slate-700/50">
                            <button @click="sensorMode = '2d'; reset()" :class="sensorMode === '2d' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                Fáze 1: 2D RGB Camera
                            </button>
                            <button @click="sensorMode = '3d'; reset()" :class="sensorMode === '3d' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-slate-200'" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-colors">
                                Fáze 2: 3D IR/Depth
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-700/50 mb-6 shadow-inner min-h-[100px] flex items-center shrink-0">

                        <div x-show="sensorMode === '2d'" x-transition.opacity class="flex items-start w-full">
                            <div class="bg-indigo-500/20 p-2 rounded-lg text-indigo-400 mr-3 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-indigo-400 font-mono text-xs font-bold uppercase tracking-wider mb-1">Optická komparace (2D RGB)</p>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed">
                                    Systém analyzuje pouze viditelné světlo. Extrahují se biometrické markery (vzdálenost očí, tvar čelisti) do 2D polygonové sítě. <span class="text-rose-400 font-bold">Chybí schopnost vnímat hloubku prostoru.</span> Výsledek závisí čistě na shodě barevných pixelů s referenční šablonou.
                                </p>
                            </div>
                        </div>

                        <div x-show="sensorMode === '3d'" x-transition.opacity class="flex items-start w-full" style="display: none;">
                            <div class="bg-emerald-500/20 p-2 rounded-lg text-emerald-400 mr-3 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                            </div>
                            <div>
                                <p class="text-emerald-400 font-mono text-xs font-bold uppercase tracking-wider mb-1">Topografická mapa (3D IR / ToF)</p>
                                <p class="text-slate-400 font-mono text-[11px] leading-relaxed">
                                    Hardwarový projektor vysílá tisíce neviditelných infračervených bodů. Měřením jejich deformace a času návratu (Time-of-Flight) vytváří přesný 3D model tváře. <span class="text-emerald-400 font-bold">Aktivní Liveness Check:</span> Plochý objekt (obrazovka/papír) je okamžitě matematicky odhalen a odmítnut.
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="flex-1 flex flex-col items-center justify-start pt-4">
                        <div class="relative w-64 h-64 rounded-full border-4 overflow-hidden bg-slate-900 transition-colors duration-300 shrink-0"
                             :class="{
                                'border-slate-700': attackStatus === 'idle',
                                'border-indigo-500 shadow-[0_0_30px_rgba(99,102,241,0.3)]': attackStatus === 'scanning',
                                'border-rose-500 shadow-[0_0_30px_rgba(225,29,72,0.4)]': attackStatus === 'success',
                                'border-emerald-500 shadow-[0_0_30px_rgba(16,185,129,0.4)]': attackStatus === 'failed'
                             }">

                            <div class="absolute inset-0 flex items-center justify-center opacity-30">
                                <svg class="w-full h-full text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 4H6a2 2 0 00-2 2v2m16 0V6a2 2 0 00-2-2h-2M4 16v2a2 2 0 002 2h2m12-2v-2a2 2 0 00-2-2h-2m-4-8v16m-8-8h16"></path></svg>
                            </div>

                            <div x-show="attackStatus !== 'idle'" x-transition.opacity class="absolute inset-0 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('img/generated_person.png') }}" alt="Scanned input" class="w-full h-full object-cover opacity-60 grayscale brightness-125">
                            </div>

                            <div x-show="attackStatus !== 'idle' && sensorMode === '2d'" class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMSIgZmlsbD0iIzYzNjZmMCIvPjwvc3ZnPg==')] opacity-50 z-20 mix-blend-screen"></div>

                            <div x-show="attackStatus !== 'idle' && sensorMode === '3d'" class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMTRiOGE2IiBzdHJva2Utd2lkdGg9IjEiIG9wYWNpdHk9IjAuNSIvPjwvc3ZnPg==')] opacity-60 z-20 mix-blend-screen" :class="{'animate-pulse text-rose-500': attackStatus === 'failed'}"></div>

                            <div x-show="attackStatus === 'scanning'" class="absolute inset-x-0 h-1 bg-indigo-400 shadow-[0_0_15px_#818cf8] z-30" :style="`top: ${scanProgress}%`"></div>
                        </div>

                        <div class="mt-8 text-center h-16 shrink-0">
                            <template x-if="attackStatus === 'success'">
                                <div>
                                    <span class="text-rose-500 font-black text-2xl tracking-widest uppercase animate-pulse">BYPASS SUCCESSFUL</span>
                                    <p class="text-sm text-rose-400 mt-2 font-bold">Senzor oklamán 2D fotografií.</p>
                                </div>
                            </template>
                            <template x-if="attackStatus === 'failed'">
                                <div>
                                    <span class="text-emerald-500 font-black text-2xl tracking-widest uppercase">ATTACK BLOCKED</span>
                                    <p class="text-sm text-emerald-400 mt-2 font-bold">Liveness Check PAD: Detekován plochý objekt.</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-56 overflow-y-auto font-mono text-[10px] sm:text-xs mt-auto shrink-0">
                        <div class="text-slate-500 mb-2 flex justify-between">
                            <span>// SECURE_ENCLAVE_LOG (Real-time)</span>
                            <span x-text="sensorMode === '2d' ? 'Mode: BASIC_RGB' : 'Mode: DEPTH_IR_LIDAR'"></span>
                        </div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in leading-relaxed" :class="{
                                'text-slate-300': log.type === 'info',
                                'text-emerald-400': log.type === 'success',
                                'text-rose-400 font-bold': log.type === 'error',
                                'text-yellow-400': log.type === 'warn'
                            }">
                                <span class="opacity-50 mr-2">>></span>
                                <span x-text="log.msg"></span>
                            </div>
                        </template>
                        <div x-show="attackStatus === 'scanning'" class="text-indigo-400 animate-pulse mt-2">
                            <span class="opacity-50 mr-2">>></span>
                            Processing biometric template...
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end" x-show="hasTriedBoth" x-transition>
                <form action="{{  route('module.biometrics.attack2', ['module' => $module->slug]) }}" method="GET">
                    @csrf
                    <button type="submit" class="group bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-105 shadow-[0_0_20px_rgba(99,102,241,0.4)] flex items-center">
                        Pokračovat dál
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function biometricSimulation() {
            return {
                sensorMode: '2d',
                attackStatus: 'idle',
                scanProgress: 0,
                logs: [],
                tried2D: false,
                tried3D: false,

                get hasTriedBoth() {
                    return this.tried2D && this.tried3D;
                },

                startAttack() {
                    this.attackStatus = 'scanning';
                    this.scanProgress = 0;
                    this.logs = [{ type: 'info', msg: '[SYS] Initializing sensor array...' }];

                    if (this.sensorMode === '2d') this.tried2D = true;
                    if (this.sensorMode === '3d') this.tried3D = true;

                    let interval = setInterval(() => {
                        this.scanProgress += 5;

                        if (this.scanProgress === 20) {
                            this.logs.push({ type: 'info', msg: '[SYS] Capturing optical frame...' });
                        }

                        if (this.scanProgress === 40) {
                            this.logs.push({ type: 'info', msg: '[ALGO] Vectoring facial landmarks (eyes, nose, jaw)...' });
                        }

                        if (this.scanProgress === 70) {
                            if (this.sensorMode === '2d') {
                                this.logs.push({ type: 'warn', msg: '[PAD] Liveness Check: SKIPPED (Hardware restriction - No IR/Depth sensor)' });
                                this.logs.push({ type: 'success', msg: '[MATCH] 2D Template Score: 98.4% (Threshold: 90%)' });
                            } else {
                                this.logs.push({ type: 'info', msg: '[SYS] Activating IR Dot Projector & ToF Sensor...' });
                                this.logs.push({ type: 'info', msg: '[ALGO] Computing depth map (Z-axis)...' });
                                this.logs.push({ type: 'error', msg: '[PAD] CRITICAL: Detected flat surface! Depth variance < 0.5mm.' });
                            }
                        }

                        if (this.scanProgress >= 100) {
                            clearInterval(interval);
                            this.attackStatus = this.sensorMode === '2d' ? 'success' : 'failed';

                            if (this.attackStatus === 'success') {
                                this.logs.push({ type: 'error', msg: '[AUTH] RESULT: ACCESS GRANTED. System compromised by 2D spoof.' });
                            } else {
                                this.logs.push({ type: 'success', msg: '[AUTH] RESULT: ACCESS DENIED. Presentation attack blocked.' });
                            }

                            this.$nextTick(() => {
                                const logContainer = document.querySelector('.overflow-y-auto');
                                if(logContainer) logContainer.scrollTop = logContainer.scrollHeight;
                            });
                        }
                    }, 150);
                },

                reset() {
                    this.attackStatus = 'idle';
                    this.scanProgress = 0;
                    this.logs = [];
                }
            }
        }
    </script>
</x-app-layout>
