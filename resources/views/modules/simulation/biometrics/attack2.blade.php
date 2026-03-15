<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Sandbox: Biometrie & MasterPrint</span>
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

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300" x-data="masterprintSandbox()">
        <div class="max-w-[1400px] mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Teoretický úvodní box --}}
            <div class="bg-indigo-900/20 border-l-4 border-indigo-500 p-6 rounded-r-2xl shadow-sm border-y border-r border-slate-700/50">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-indigo-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <div class="ml-4 flex-1">
                        <h3 class="text-base font-bold text-indigo-300 uppercase tracking-wider mb-3">
                            Laboratoř: Geometrie senzoru a MasterPrint útok
                        </h3>
                        <div class="text-sm text-slate-300 space-y-4 leading-relaxed font-medium">
                            <p>
                                V této simulaci si vyzkoušíte, jak fyzická velikost biometrického senzoru ovlivňuje jeho softwarovou bezpečnost (False Accept Rate). 
                                Mobilní senzory jsou malé, takže uchovávají desítky <strong>částečných šablon</strong> jednoho prstu. K odemčení stačí shoda s jakoukoliv z nich.
                            </p>
                            <div class="bg-indigo-950/50 border border-indigo-500/30 p-4 rounded-xl">
                                <p class="font-bold text-indigo-200 mb-2 uppercase tracking-widest text-xs">Postup experimentu:</p>
                                <ul class="list-decimal list-inside space-y-2 text-indigo-100">
                                    <li>Nejprve zkuste zaútočit "náhodným" cizím otiskem. Systém by vás měl bezpečně odmítnout.</li>
                                    <li>Přepněte typ útoku na <strong>MasterPrint</strong> (syntetický otisk složený z nejběžnějších papilárních linií populace). Pozorujte, jak roste skóre u malého senzoru.</li>
                                    <li>Zkuste změnit <strong>velikost senzoru</strong> v prostředním panelu na "Full-size" (jako u pasových kontrol) a útok zopakujte.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                {{-- 1. SLOUPEC: Útočník (Payload) --}}
                <div class="bg-slate-950 rounded-3xl p-6 border-t-4 border-rose-500 shadow-2xl flex flex-col h-full relative">
                    <h3 class="text-rose-500 font-mono font-bold text-xs mb-6 tracking-tighter uppercase flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        1. Vektor útoku (Spoofing)
                    </h3>

                    <div class="flex-1 flex flex-col space-y-6">
                        
                        {{-- Výběr typu útoku --}}
                        <div class="space-y-3">
                            <label class="text-[10px] text-slate-500 font-bold uppercase tracking-widest block">Typ podvrženého otisku</label>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <button @click="attackType = 'random'" 
                                        class="p-4 rounded-xl border transition-all text-center flex flex-col items-center justify-center gap-2"
                                        :class="attackType === 'random' ? 'bg-rose-600/20 border-rose-500 text-rose-400' : 'bg-slate-900 border-slate-700 text-slate-500 hover:border-slate-500'">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    <span class="text-[10px] font-bold uppercase">Náhodný otisk<br>(Cizí osoba)</span>
                                </button>

                                <button @click="attackType = 'masterprint'" 
                                        class="p-4 rounded-xl border transition-all text-center flex flex-col items-center justify-center gap-2"
                                        :class="attackType === 'masterprint' ? 'bg-rose-600/20 border-rose-500 text-rose-400 shadow-[0_0_15px_rgba(225,29,72,0.3)]' : 'bg-slate-900 border-slate-700 text-slate-500 hover:border-slate-500'">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                    <span class="text-[10px] font-bold uppercase">MasterPrint<br>(Syntetický AI)</span>
                                </button>
                            </div>
                        </div>

                        {{-- Popis vybraného útoku --}}
                        <div class="bg-slate-900/80 p-4 rounded-xl border border-rose-500/30 shadow-inner min-h-[100px]">
                            <p x-show="attackType === 'random'" class="text-xs text-slate-400 leading-relaxed font-mono">
                                <span class="text-rose-500 font-bold block mb-1">Náhodný cizí otisk:</span>
                                Pokus o odemčení zařízením přiložením prstu náhodného útočníka. Pravděpodobnost shody (FAR) je typicky menší než 0.002%.
                            </p>
                            <p x-show="attackType === 'masterprint'" class="text-xs text-slate-400 leading-relaxed font-mono">
                                <span class="text-rose-500 font-bold block mb-1">MasterPrint injekce:</span>
                                Syntetický otisk vygenerovaný algoritmem. Obsahuje shluk nejběžnějších markantů (minutiae). Cílí na maximalizaci šance, že se částečně shodne s uloženými daty.
                            </p>
                        </div>

                        <button @click="executeScan()" :disabled="isScanning" class="mt-auto w-full bg-rose-600 hover:bg-rose-500 disabled:bg-slate-800 disabled:text-slate-600 text-white py-4 rounded-xl font-black uppercase text-xs tracking-widest transition-all transform shadow-lg hover:-translate-y-0.5 flex items-center justify-center">
                            <span x-show="!isScanning">Přiložit podvržený prst</span>
                            <span x-show="isScanning" class="animate-pulse">Snímání...</span>
                        </button>
                    </div>
                </div>

                {{-- 2. SLOUPEC: Senzor a Uložené Šablony --}}
                <div class="bg-slate-900 rounded-3xl p-6 border-t-4 border-slate-600 shadow-2xl flex flex-col h-full relative">
                    <h3 class="text-slate-400 font-mono font-bold text-xs mb-6 tracking-tighter uppercase flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 7a1 1 0 112 0v4a1 1 0 11-2 0V7zm2 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path></svg>
                            2. Hardware: Databáze šablon
                        </div>
                    </h3>

                    <div class="flex-1 flex flex-col space-y-6">
                        
                        {{-- Konfigurace senzoru --}}
                        <div class="bg-slate-950 rounded-xl border border-slate-800 p-4 shadow-inner">
                            <div class="flex justify-between items-center mb-3">
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Velikost biometrického senzoru</label>
                            </div>
                            <div class="flex bg-slate-900 rounded-lg p-1 border border-slate-700">
                                <button @click="sensorSize = 'small'; resetLogs()" class="flex-1 py-2 text-xs font-bold uppercase rounded-md transition-colors" :class="sensorSize === 'small' ? 'bg-slate-700 text-white shadow' : 'text-slate-500 hover:text-slate-300'">Mobilní (Malý)</button>
                                <button @click="sensorSize = 'large'; resetLogs()" class="flex-1 py-2 text-xs font-bold uppercase rounded-md transition-colors" :class="sensorSize === 'large' ? 'bg-emerald-600 text-white shadow' : 'text-slate-500 hover:text-slate-300'">Full-size (Velký)</button>
                            </div>
                        </div>

                        {{-- Vizualizace uložených šablon --}}
                        <div class="flex-1 bg-slate-900/50 rounded-xl border border-slate-800/50 p-4 flex flex-col">
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-4 block text-center">Uložené šablony v Secure Enclave</span>
                            
                            {{-- Malý senzor (mnoho malých částečných šablon) --}}
                            <div x-show="sensorSize === 'small'" class="grid grid-cols-4 gap-2 flex-1 place-content-center">
                                <template x-for="i in 12">
                                    <div class="aspect-square rounded border border-slate-700 bg-slate-800 flex items-center justify-center transition-all duration-300"
                                         :class="{'ring-2 ring-emerald-500 bg-emerald-500/20': matchIndex === i, 'opacity-50': isScanning && matchIndex !== i}">
                                        <svg class="w-4 h-4 text-slate-600" :class="{'text-emerald-400': matchIndex === i}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                    </div>
                                </template>
                            </div>

                            {{-- Velký senzor (jedna velká šablona) --}}
                            <div x-show="sensorSize === 'large'" class="flex-1 flex items-center justify-center">
                                <div class="w-32 h-40 rounded-xl border-2 border-slate-700 bg-slate-800 flex items-center justify-center transition-all duration-300"
                                     :class="{'ring-4 ring-rose-500 bg-rose-500/10 border-rose-500': attackResult === 'failed'}">
                                     <svg class="w-16 h-16 text-slate-600" :class="{'text-rose-400': attackResult === 'failed'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- 3. SLOUPEC: Matching Engine (Výsledky) --}}
                <div class="bg-slate-800/60 backdrop-blur-md rounded-3xl p-6 border-t-4 shadow-2xl flex flex-col h-full relative transition-colors duration-500"
                     :class="attackResult === 'success' ? 'border-rose-500 ring-2 ring-rose-500/30' : (attackResult === 'failed' ? 'border-emerald-500 ring-2 ring-emerald-500/30' : 'border-slate-600')">
                    
                    <h3 class="font-mono font-bold text-xs mb-6 tracking-tighter uppercase flex items-center"
                        :class="attackResult === 'success' ? 'text-rose-500' : 'text-emerald-400'">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        3. Matching Engine (Vyhodnocení)
                    </h3>

                    <div class="space-y-4 flex-1 flex flex-col">
                        
                        <div class="bg-slate-900 rounded-xl border border-slate-700/50 p-4 shadow-inner">
                            <span class="text-[10px] text-slate-500 font-bold block mb-1 uppercase tracking-widest">Požadovaný práh (Threshold)</span>
                            <div class="text-emerald-400 font-mono text-sm bg-emerald-500/10 p-2 rounded text-center font-bold">Shoda > 80%</div>
                        </div>

                        {{-- Terminál koprocesoru --}}
                        <div class="bg-slate-950 rounded-xl p-4 border border-slate-800 flex-1 flex flex-col relative overflow-hidden min-h-[150px]">
                            <div class="text-[10px] text-slate-500 font-mono uppercase tracking-widest border-b border-slate-800 pb-2 mb-2">
                                // Biometric K-Coproc Logs
                            </div>
                            <div class="flex-1 overflow-y-auto space-y-1" x-ref="matchLogs">
                                <template x-for="(log, i) in logs" :key="i">
                                    <div class="text-[10px] font-mono animate-fade-in leading-relaxed" :class="{
                                        'text-slate-400': log.type === 'info',
                                        'text-emerald-400 font-bold': log.type === 'success',
                                        'text-rose-400 font-bold bg-rose-500/10 p-1 rounded': log.type === 'error'
                                    }">
                                        <span class="opacity-50">></span> <span x-text="log.msg"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Status Box --}}
                        <div class="h-16 flex items-center justify-center rounded-xl font-black uppercase tracking-widest text-sm transition-all duration-300"
                             :class="attackResult === 'idle' ? 'bg-slate-800/50 text-slate-600' : (attackResult === 'failed' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-500 border border-rose-500/30 shadow-[0_0_20px_rgba(225,29,72,0.4)]')">
                            <span x-show="attackResult === 'idle'">Čeká na otisk</span>
                            <span x-show="attackResult === 'failed'" class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> SHODA NENALEZENA (Bezpečné)</span>
                            <span x-show="attackResult === 'success'" class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> MASTERPRINT ÚSPĚŠNÝ!</span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mt-8 flex justify-end" x-show="hasTriedBoth" x-transition>
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
        function masterprintSandbox() {
            return {
                attackType: 'random', // random, masterprint
                sensorSize: 'small',  // small, large
                isScanning: false,
                attackResult: 'idle', // idle, success, failed
                matchIndex: 0,
                logs: [{type: 'info', msg: 'Systém připraven. Čekám na vstup ze senzoru...'}],
                triedRandom: false,
                triedMasterprint: false,

                get hasTriedBoth() {
                    return this.triedRandom && this.triedMasterprint;
                },

                resetLogs() {
                    this.logs = [{type: 'info', msg: 'Konfigurace senzoru změněna. Připraven.'}];
                    this.attackResult = 'idle';
                    this.matchIndex = 0;
                },

                executeScan() {
                    this.isScanning = true;
                    this.attackResult = 'idle';
                    this.matchIndex = 0;
                    this.logs = [{type: 'info', msg: 'Zahajuji snímání a extrakci markantů (minutiae)...'}];
                    this.scrollLogs();

                    if (this.attackType === 'random') this.triedRandom = true;
                    if (this.attackType === 'masterprint') this.triedMasterprint = true;

                    setTimeout(() => {
                        this.logs.push({type: 'info', msg: 'Porovnávám s uloženými šablonami...'});
                        this.scrollLogs();
                        
                        this.performMatching();
                    }, 800);
                },

                async performMatching() {
                    let isMatch = false;
                    let templatesToMatch = this.sensorSize === 'small' ? 12 : 1;
                    
                    for (let i = 1; i <= templatesToMatch; i++) {
                        // Simulace postupného zkoušení šablon
                        await new Promise(r => setTimeout(r, 150));
                        
                        // Generování skóre závislé na scénáři
                        let score = 0;
                        if (this.attackType === 'random') {
                            score = Math.floor(Math.random() * 30) + 10; // 10% - 40%
                        } else { // MasterPrint
                            if (this.sensorSize === 'large') {
                                score = Math.floor(Math.random() * 20) + 30; // 30% - 50% (Masterprint nepomůže na celý prst)
                            } else {
                                // MasterPrint + Malý senzor = Vysoká šance na částečnou shodu
                                score = Math.floor(Math.random() * 40) + 50; // 50% - 90%
                            }
                        }

                        // Hardcode situace, aby MasterPrint vždy uspěl u malého senzoru (pro didaktiku)
                        if (this.attackType === 'masterprint' && this.sensorSize === 'small' && i === 7) {
                            score = 86;
                        }

                        this.logs.push({type: 'info', msg: `Šablona #${i}: Shoda ${score}%`});
                        this.scrollLogs();

                        if (score >= 80) {
                            isMatch = true;
                            this.matchIndex = i;
                            this.logs.push({type: 'error', msg: `[CRITICAL] Prahová hodnota překonána na šabloně #${i}!`});
                            break; // Stačí jedna shoda
                        }
                    }

                    setTimeout(() => {
                        this.isScanning = false;
                        if (isMatch) {
                            this.attackResult = 'success';
                            this.logs.push({type: 'error', msg: 'Přístup povolen. False Accept Rate (FAR) exploitován.'});
                        } else {
                            this.attackResult = 'failed';
                            this.logs.push({type: 'success', msg: 'Žádná šablona nedosáhla prahu. Přístup zamítnut.'});
                        }
                        this.scrollLogs();
                    }, 500);
                },

                scrollLogs() {
                    this.$nextTick(() => {
                        const container = this.$refs.matchLogs;
                        if(container) container.scrollTop = container.scrollHeight;
                    });
                }
            }
        }
    </script>
</x-app-layout>