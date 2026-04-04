{{-- Biometrie Guide: Průvodce nastavením biometrického přihlášení --}}
<div x-data="{ currentStep: 1, totalSteps: 3, platform: 'android' }">

    {{-- Výběr platformy --}}
    <div class="flex items-center justify-center gap-4 mb-8">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Vaše zařízení:</span>
        <div class="flex bg-slate-100 dark:bg-slate-900/50 rounded-xl p-1 border border-slate-200 dark:border-slate-700">
            <button @click="platform = 'android'" :class="platform === 'android' ? 'bg-white dark:bg-slate-700 shadow-sm text-emerald-600 dark:text-emerald-400' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                 Android
            </button>
            <button @click="platform = 'iphone'" :class="platform === 'iphone' ? 'bg-white dark:bg-slate-700 shadow-sm text-blue-600 dark:text-blue-400' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                 iPhone
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

    {{-- KROK 1: Zapnutí biometrie na telefonu --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zapněte biometrii na telefonu</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Prvním krokem je nastavení otisku prstu nebo rozpoznání obličeje pro odemykání telefonu.</p>
        </div>

        <div class="max-w-lg mx-auto">
            {{-- Android --}}
            <div x-show="platform === 'android'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-4">Android</h4>
                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Nastavení → Zabezpečení → Biometrie</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Zvolte <strong>Otisk prstu</strong> nebo <strong>Rozpoznání obličeje</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Přiložte prst k senzoru a postupujte dle pokynů (opakovaně přikládejte z různých úhlů)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Doporučení: zaregistrujte <strong>2 prsty</strong> (palec pravé i levé ruky)</span>
                    </li>
                </ol>
            </div>

            {{-- iPhone --}}
            <div x-show="platform === 'iphone'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4">iPhone</h4>
                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Nastavení → Face ID a kódový zámek</strong> (nebo Touch ID)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klepněte na <strong>Nastavit Face ID</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Pomalu otáčejte hlavou v kruhu, dokud se sken nedokončí</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Zapněte Face ID pro <strong>Odemykání iPhonu</strong> a <strong>iTunes a App Store</strong></span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    {{-- KROK 2: Aktivace v bankovní aplikaci --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zapněte biometrii v mobilním bankovnictví</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Většina českých bank umožňuje přihlášení a potvrzení plateb biometrií.</p>
        </div>

        <div class="space-y-3 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-1">Obecný postup</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Otevřete bankovní aplikaci → Nastavení → Zabezpečení → <strong>Přihlášení otiskem/obličejem</strong> → Zapnout</p>
            </div>
            <div class="p-4 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
                <p class="text-xs text-indigo-700 dark:text-indigo-300 text-center font-medium">
                    💡 <strong>Tip:</strong> Zapněte biometrii i pro <strong>podepisování plateb</strong> — je to rychlejší a bezpečnější než opisování SMS kódu.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 3: Nastavení na počítači --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Biometrie na počítači</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">I na notebooku si můžete nastavit přihlašování otiskem prstu nebo obličejem.</p>
        </div>

        <div class="space-y-4 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <h4 class="font-bold text-sm text-blue-600 dark:text-blue-400 mb-3">🪟 Windows Hello</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Nastavení → Účty → Možnosti přihlášení → <strong>Rozpoznání obličeje</strong> nebo <strong>Rozpoznání otisku prstu</strong></p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <h4 class="font-bold text-sm text-slate-600 dark:text-slate-400 mb-3">🍎 macOS Touch ID</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Předvolby systému → Touch ID & heslo → <strong>Přidat otisk prstu</strong> (dostupné na MacBook Pro/Air s Touch ID)</p>
            </div>
        </div>

        <div class="mt-6 p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center max-w-lg mx-auto">
            <div class="text-3xl mb-2">👆</div>
            <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Biometrie je všude kolem vás</h4>
            <p class="text-xs text-slate-600 dark:text-slate-400">Telefon, notebook, bankovní aplikace — aktivujte ji všude, kde to jde.</p>
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
