{{-- FIDO2 Guide: Průvodce vytvořením USB klíče do Windows pomocí USB Raptor --}}
<div x-data="{ currentStep: 1, totalSteps: 4, platform: 'windows' }">

    {{-- Výběr platformy (Zde pouze Windows, protože USB Raptor je Windows program) --}}
    <div class="flex items-center justify-center gap-4 mb-8">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Platforma:</span>
        <div class="flex bg-slate-100 dark:bg-slate-900/50 rounded-xl p-1 border border-slate-200 dark:border-slate-700">
            <button class="px-4 py-2 bg-white dark:bg-slate-700 shadow-sm text-blue-600 dark:text-blue-400 rounded-lg text-xs font-bold uppercase tracking-wider transition-all cursor-default">
                 Windows 10/11
            </button>
        </div>
    </div>

    {{-- Indikátor kroků --}}
    <div class="flex items-center justify-center gap-2 mb-10">
        <template x-for="step in totalSteps" :key="step">
            <div class="flex items-center">
                <div @click="currentStep = step" class="cursor-pointer flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold transition-all duration-300"
                     :class="step <= currentStep ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-slate-200 dark:bg-slate-700 text-slate-400'">
                    <span x-text="step"></span>
                </div>
                <div x-show="step < totalSteps" class="w-8 h-0.5 mx-1 transition-all duration-300" :class="step < currentStep ? 'bg-amber-500' : 'bg-slate-200 dark:bg-slate-700'"></div>
            </div>
        </template>
    </div>

    {{-- KROK 1: Koncept a příprava --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Jak si doma vyrobit "FIDO2" klíč</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Zkoušeli jsme hardwarové klíče jako YubiKey. Nemusíte utrácet tisíce, doma si můžete podobný princip pro zamykání Windows vyzkoušet zadarmo s obyčejnou Flashkou.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-xl mx-auto">
            <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl p-5 text-left">
                <div class="text-2xl mb-3">💾</div>
                <h4 class="font-bold text-sm text-indigo-700 dark:text-indigo-400 mb-1">Připravte si Flashku</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Najděte libovolný starý USB Flash disk. Program ho nesmaže, jen na něj přidá malý soubor jako klíč. Ujistěte se, že ji máte zasunutou v počítači.</p>
            </div>
            <div class="bg-amber-500/5 dark:bg-amber-500/10 border border-amber-500/20 rounded-xl p-5 text-left">
                <div class="text-2xl mb-3">⚙️</div>
                <h4 class="font-bold text-sm text-amber-700 dark:text-amber-400 mb-1">Princip programu USB Raptor</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Vygenerujeme unikátní šifrovaný hashový soubor (<code class="bg-slate-200 dark:bg-slate-800 px-1 rounded text-[10px]">.k3y</code>). Windows se odemknou pouze poté, co zachytí fyzické připojení tohoto souboru na portu.</p>
            </div>
        </div>
    </div>

    {{-- KROK 2: Stažení a spuštění --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Instalace je blesková</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Otevřený program USB Raptor nemusíte vůbec instalovat (je Portable). Stáhnete a rovnou běží.</p>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Stáhněte zip repozitář z internetu (Hledejte <strong>USB Raptor SourceForge</strong> na Googlu).</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Po stažení zazipovanou složku extrahujte do vlastního adresáře (např. na Plochu).</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Uvnitř najděte soubor <strong class="font-mono text-blue-600 dark:text-blue-400">USB Raptor.exe</strong> a spusťte jej.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Potvrďte povolení správce a Přečtěte si (nebo aspoň přeskočte) uvítací okno s upozorněním programu.</span>
                    </li>
                </ol>
            </div>
            <div class="mt-4 p-4 bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl text-center">
                 <p class="text-[11px] text-rose-700 dark:text-rose-400 font-bold uppercase tracking-wider">! Důležité u takto silných bezpečnostních programů</p>
                 <p class="text-[10px] text-slate-600 dark:text-slate-400 mt-1">Stahujte vždy jen z autorizovaných platforem, abyste do Windows nenasadili rovnou opravdový malware navržený podobně jako InfoStealer ze simulace FIDO2.</p>
            </div>
        </div>
    </div>

    {{-- KROK 3: Vytvoření klíče --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Vykování fyzického klíče do Flashky</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Toto je ten reálný moment zapsání tokenu srovnatelný s kryptografickým "MakeCredential" z naší simulace WebAuthn.</p>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                     <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>V hlavním ovládacím panelu zadejte bezpečné zadní heslo (Master Password). <strong>To funguje jako FIDO Recovery code, a v případě ztráty disku jím odemknete PC ručně.</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Do rozbalovací kolonky "Select USB drive" vyberte písmeno Vaší připojené Flashky (třeba `E:\`).</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Klikněte na tlačítko <strong><code class="text-indigo-600 dark:text-indigo-400">Create k3y file</code></strong>. Fyzický zápis tokenu proběhl a USB disk je teď Vaším HW klíčem.</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    {{-- KROK 4: Aktivace a Ponaučení ze Sandboxu --}}
    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zapnutí magie s hardwarem</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Kus hardwaru proměníme přímo v zámek operačního systému počítače.</p>
        </div>

        <div class="max-w-xl mx-auto space-y-6">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6 text-center">
                 <p class="text-xs font-bold text-slate-800 dark:text-slate-200 mb-4">Uvnitř okna zaklikněte čtvereček: <br><span class="text-emerald-600 dark:text-emerald-500 bg-emerald-500/10 px-2 py-1 rounded inline-block mt-2 font-black border border-emerald-500/30">✓ Enable USB Raptor</span></p>
                 <div class="grid grid-cols-2 gap-4 text-left">
                     <div class="p-3 border border-slate-200 dark:border-slate-700 rounded-lg">
                         <div class="text-sm font-bold text-rose-500 flex items-center mb-1"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Zkuste flešku vyjmout</div>
                         <p class="text-[10px] text-slate-500 dark:text-slate-400">Na monitoru ihned naběhne Red Screen zámek Windows.</p>
                     </div>
                     <div class="p-3 border border-slate-200 dark:border-slate-700 rounded-lg">
                         <div class="text-sm font-bold text-emerald-500 flex items-center mb-1"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg> Flashku vraťte zpátky </div>
                         <p class="text-[10px] text-slate-500 dark:text-slate-400">Software fyzicky detekuje .k3y a zruší zamykací obalení.</p>
                     </div>
                 </div>
            </div>

            <div class="p-5 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-2xl text-center max-w-lg mx-auto shadow-inner">
                <h4 class="font-bold text-indigo-700 dark:text-indigo-400 mb-2 uppercase tracking-wider text-xs">Vzpomeňte na "User Verification" útok</h4>
                <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                    Jak jste si sami zkusili v FIDO2 simulátoru u <strong>konfigurace proti fyzické krádeži</strong>: Pokud nemáte na Flash klíč heslo nebo nemá biometrický senzor (tzn. jakýkoliv zloděj ji vloží do počítače), zamykací SW vás nezachrání. Raptor nepoužívá PIN pro vložení! A proto se mu neříká FIDO2 klíč, ale pouze Token Přítomnosti Uživatele (User Presence Token).
                </p>
            </div>
        </div>
    </div>

    {{-- Navigační tlačítka --}}
    <div class="flex justify-between items-center mt-10 pt-6 border-t border-slate-200 dark:border-slate-700">
        <button @click="currentStep = Math.max(1, currentStep - 1)" x-show="currentStep > 1" class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Předchozí
        </button>
        <div x-show="currentStep === 1"></div>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="'Krok ' + currentStep + ' / ' + totalSteps"></span>
        <button @click="currentStep = Math.min(totalSteps, currentStep + 1)" x-show="currentStep < totalSteps" class="flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-amber-500/20">
            Další
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>
</div>
