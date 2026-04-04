{{-- TOTP Guide: Krokový průvodce nastavením Google Authenticator --}}
<div x-data="{ currentStep: 1, totalSteps: 4, platform: 'android' }">

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

    {{-- KROK 1: Stažení aplikace --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Stáhněte si autentizační aplikaci</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Otevřete obchod s aplikacemi na svém telefonu a vyhledejte jednu z těchto aplikací. Všechny jsou zdarma.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center hover:border-amber-500/50 transition-colors">
                <div class="text-2xl mb-2">🔐</div>
                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm">Google Authenticator</h4>
                <p class="text-[10px] text-slate-400 mt-1" x-text="platform === 'android' ? 'Google Play Store' : 'App Store'"></p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5 text-center hover:border-amber-500/50 transition-colors">
                <div class="text-2xl mb-2">🛡️</div>
                <h4 class="font-bold text-slate-800 dark:text-slate-100 text-sm">Microsoft Authenticator</h4>
                <p class="text-[10px] text-slate-400 mt-1" x-text="platform === 'android' ? 'Google Play Store' : 'App Store'"></p>
            </div>
        </div>

        <div class="mt-6 p-4 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
            <p class="text-xs text-indigo-700 dark:text-indigo-300 text-center font-medium">
                💡 <strong>Tip:</strong> Google Authenticator je nejrozšířenější — doporučujeme začít s ním.
            </p>
        </div>
    </div>

    {{-- KROK 2: Otevření nastavení zabezpečení --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Otevřete nastavení zabezpečení</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Vyberte službu, kde chcete aktivovat dvoufázové ověření, a najděte nastavení zabezpečení.</p>
        </div>

        <div class="space-y-3 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center text-lg shrink-0">G</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Google účet</h4>
                    <p class="text-[10px] text-slate-400 font-mono">myaccount.google.com → Zabezpečení → Dvoufázové ověření</p>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600/10 rounded-lg flex items-center justify-center text-lg shrink-0">f</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Facebook</h4>
                    <p class="text-[10px] text-slate-400 font-mono">Nastavení → Zabezpečení a přihlášení → Dvoufázové ověření</p>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-slate-700/10 dark:bg-white/10 rounded-lg flex items-center justify-center text-lg shrink-0">⌨️</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">GitHub</h4>
                    <p class="text-[10px] text-slate-400 font-mono">Settings → Password and authentication → 2FA</p>
                </div>
            </div>
        </div>
    </div>

    {{-- KROK 3: Naskenování QR kódu --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Naskenujte QR kód</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Služba vám zobrazí QR kód. Otevřete autentizační aplikaci a naskenujte ho.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Google Authenticator</strong> na telefonu</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klepněte na tlačítko <strong>+</strong> (přidat účet)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span x-text="platform === 'android' ? 'Zvolte „Naskenovat QR kód" a namiřte fotoaparát na obrazovku počítače' : 'Klepněte na „Naskenovat QR kód" a namiřte fotoaparát na obrazovku'"></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Aplikace automaticky rozpozná kód a přidá účet</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                <p class="text-xs text-emerald-700 dark:text-emerald-300 text-center font-medium">
                    ✅ Po naskenování se v aplikaci začne zobrazovat 6místný kód, který se mění každých 30 sekund.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 4: Ověření a záloha --}}
    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Ověřte a uložte záložní kódy</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Zadejte kód z aplikace pro potvrzení. Poté si bezpečně uložte záložní kódy.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6 space-y-4">
                <div class="flex gap-3 items-start">
                    <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0 mt-0.5">1</span>
                    <div>
                        <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">Služba vás požádá o zadání aktuálního <strong>6místného kódu</strong> z aplikace</p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0 mt-0.5">2</span>
                    <div>
                        <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">Po ověření vám služba vygeneruje <strong>záložní kódy</strong></p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0 mt-0.5">3</span>
                    <div>
                        <p class="text-sm text-slate-700 dark:text-slate-300 font-medium">Záložní kódy si <strong>vytiskněte nebo uložte</strong> na bezpečné místo (ne na telefon!)</p>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl">
                <p class="text-xs text-rose-700 dark:text-rose-300 text-center font-medium">
                    ⚠️ <strong>Důležité:</strong> Bez záložních kódů se nedostanete k účtu, pokud ztratíte telefon!
                </p>
            </div>

            <div class="p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center">
                <div class="text-3xl mb-2">🎉</div>
                <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Hotovo!</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Váš účet je nyní chráněn dvoufaktorovou autentizací pomocí TOTP.</p>
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
