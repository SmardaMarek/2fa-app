<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">
                {{ $module->title }} - Iniciace: Váš biometrický hardware
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

    <div class="py-8" x-data="biometricSetup()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50 mb-8">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-2">
                            Příprava na modul: Biometrie jako faktor inherence
                        </h3>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Než se ponoříme do zranitelností biometrických systémů a matematických chyb (FAR/FRR), podívejme se na základní princip. Většina uživatelů si myslí, že jejich telefon ukládá fotografii jejich obličeje nebo otisku. Z architektonického hlediska je to ale smrtelné bezpečnostní riziko.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

                <div class="bg-slate-950 rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative overflow-hidden">
                    <h3 class="text-indigo-400 font-mono font-bold text-sm mb-6 tracking-tighter flex items-center z-10">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        // ALGORITHM: MINUTIAE_EXTRACTION
                    </h3>

                    <div class="flex-1 flex flex-col items-center justify-center relative">
                        <div class="relative w-48 h-64 border-2 rounded-[40px] flex items-center justify-center overflow-hidden transition-colors duration-500"
                             :class="isScanning ? 'border-indigo-500 shadow-[0_0_30px_rgba(99,102,241,0.2)]' : (scanComplete ? 'border-emerald-500' : 'border-slate-700')">

                            <svg class="w-32 h-48 transition-all duration-500" :class="isScanning ? 'text-indigo-400' : (scanComplete ? 'text-emerald-500' : 'text-slate-600')" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>

                            <div x-show="isScanning" class="absolute inset-x-0 h-1 bg-indigo-400 shadow-[0_0_20px_#818cf8] z-30" :style="`top: ${scanProgress}%`"></div>

                            <template x-if="scanProgress > 30">
                                <div class="absolute w-2 h-2 bg-rose-500 rounded-full top-[30%] left-[40%] shadow-[0_0_5px_#f43f5e]"></div>
                            </template>
                            <template x-if="scanProgress > 60">
                                <div class="absolute w-2 h-2 bg-rose-500 rounded-full top-[60%] left-[60%] shadow-[0_0_5px_#f43f5e]"></div>
                            </template>
                            <template x-if="scanProgress > 80">
                                <div class="absolute w-2 h-2 bg-rose-500 rounded-full top-[75%] left-[35%] shadow-[0_0_5px_#f43f5e]"></div>
                            </template>
                        </div>

                        <div class="mt-6 h-12 text-center w-full px-4">
                            <div x-show="scanComplete" x-transition.duration.500ms class="bg-slate-900 border border-emerald-500/30 p-2 rounded-lg font-mono text-[10px] text-emerald-400 break-all">
                                TEMPLATE_HASH: e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-xl p-4 border border-slate-700/50 h-40 overflow-y-auto font-mono text-[10px] sm:text-xs shrink-0 mt-4">
                        <div class="text-slate-500 mb-2">// SECURE_ENCLAVE_PROCESS</div>
                        <template x-for="(log, index) in logs" :key="index">
                            <div class="mb-1 animate-fade-in text-slate-300">
                                <span class="opacity-50 mr-2 text-indigo-400">>></span>
                                <span x-text="log"></span>
                            </div>
                        </template>
                        <div x-show="isScanning" class="text-indigo-400 animate-pulse mt-2">
                            <span class="opacity-50 mr-2">>></span>
                            Extrahuji markanty (minutiae points)...
                        </div>
                    </div>

                    <button @click="startSimulation()" :disabled="isScanning" class="mt-4 w-full bg-slate-800 hover:bg-slate-700 text-indigo-400 disabled:opacity-50 border border-slate-700 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition-colors">
                        <span x-text="scanComplete ? 'Restartovat extrakci' : 'Spustit simulaci extrakce'"></span>
                    </button>
                </div>

                <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-slate-700/50 shadow-2xl flex flex-col h-full relative">
                    <div class="absolute top-0 left-0 w-1/3 h-1 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] rounded-tl-3xl"></div>

                    <h3 class="text-slate-100 font-black text-xl mb-6 tracking-tight">Otestujte svůj vlastní hardware</h3>

                    <div class="space-y-6 text-sm text-slate-300 flex-1">
                        <p>
                            Vlevo vidíte, jak funguje biometrická transformace. Senzor nenačte otisk jako obrázek, ale najde na něm specifické body (tzv. markanty - větvení, zakončení papilárních linií). Tyto vzdálenosti a úhly převede pomocí jednosměrné funkce do matematické šablony (Template).
                        </p>

                        <div class="bg-slate-900/60 p-5 rounded-xl border border-slate-700/50 shadow-inner">
                            <h4 class="text-indigo-400 font-bold mb-3 uppercase tracking-widest text-xs">Vaše zadání:</h4>
                            <ol class="list-decimal list-inside space-y-3">
                                <li>Vezměte do ruky svůj mobilní telefon.</li>
                                <li>Zamkněte obrazovku.</li>
                                <li>Odemkněte zařízení pomocí své biometrie (Otisk / Obličej).</li>
                                <li><strong>Zamyslete se:</strong> Jaký typ senzoru výrobce vašeho telefonu použil?</li>
                            </ol>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-slate-900 border border-slate-700 rounded-lg p-3">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Otisk prstu</span>
                                <span class="text-[11px] text-slate-500 leading-tight">Je senzor optický (svítí pod displejem), kapacitní (na zádech/v tlačítku), nebo ultrazvukový (neviditelný pod displejem)?</span>
                            </div>
                            <div class="bg-slate-900 border border-slate-700 rounded-lg p-3">
                                <span class="block text-xs font-bold text-slate-400 uppercase mb-1">Rozpoznání tváře</span>
                                <span class="text-[11px] text-slate-500 leading-tight">Používá telefon pouze standardní selfie kameru (2D), nebo má výřez pro IR projektor (Apple FaceID, 3D)?</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <form action="{{ route($module->getSimulationAttackRoute(), ['module' => $module->slug]) }}" method="GET">
                            @csrf
                            <button type="submit" @click="hardwareChecked = true" class="w-full group bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest transition-all transform hover:scale-[1.02] shadow-[0_0_20px_rgba(99,102,241,0.4)] flex items-center justify-center">
                                Otestoval jsem svůj telefon
                                <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function biometricSetup() {
            return {
                isScanning: false,
                scanComplete: false,
                scanProgress: 0,
                logs: [],

                startSimulation() {
                    this.isScanning = true;
                    this.scanComplete = false;
                    this.scanProgress = 0;
                    this.logs = ['[SENSOR] Inicializace senzoru...', '[SENSOR] Čekám na vzorek... Vzorek detekován.'];

                    let interval = setInterval(() => {
                        this.scanProgress += 2; // Rychlost skenování

                        if (this.scanProgress === 30) {
                            this.logs.push('[ALGO] Nalezen markant: Zakončení linie (X:14, Y:42)');
                        }
                        if (this.scanProgress === 60) {
                            this.logs.push('[ALGO] Nalezen markant: Větvení (X:28, Y:71)');
                        }
                        if (this.scanProgress === 80) {
                            this.logs.push('[ALGO] Vytvářím vektorovou mapu vzdáleností...');
                        }

                        if (this.scanProgress >= 100) {
                            clearInterval(interval);
                            this.isScanning = false;
                            this.scanComplete = true;
                            this.logs.push('[ENCLAVE] Vektorová mapa transformována.');
                            this.logs.push('[ENCLAVE] Biometrická šablona (Template) bezpečně uložena.');

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
