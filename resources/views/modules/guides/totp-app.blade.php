{{-- TOTP Guide: Konkrétní návod nastavení TOTP na Google účtu --}}
<div x-data="{ currentStep: 1, totalSteps: 5, platform: 'android' }">

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
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Stáhněte si Google Authenticator</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Otevřete obchod na telefonu a vyhledejte <strong>Google Authenticator</strong>.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span x-text="platform === 'android' ? 'Otevřete Google Play Store' : 'Otevřete App Store'"></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Vyhledejte <strong>„Google Authenticator"</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span x-text="platform === 'android' ? 'Klepněte na Instalovat (vydavatel: Google LLC)' : 'Klepněte na Stáhnout (vydavatel: Google LLC)'"></span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
                <p class="text-xs text-indigo-700 dark:text-indigo-300 text-center font-medium">
                    💡 <strong>Alternativy:</strong> Funguje i Microsoft Authenticator nebo Authy — postup je stejný.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 2: Zapnutí 2FA na Google účtu --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zapněte dvoufázové ověření na Google účtu</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Ukážeme si to na Google účtu — postup je u většiny služeb podobný.</p>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Na počítači otevřete <strong class="text-amber-600 dark:text-amber-400">myaccount.google.com</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>V levém menu klikněte na <strong>Zabezpečení</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>V sekci „Jak se přihlašujete" klikněte na <strong>Dvoufázové ověření</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Klikněte na <strong>Začít</strong> a zadejte své heslo</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">5</span>
                        <span>V sekci „Aplikace Authenticator" klikněte na <strong>Nastavit</strong></span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    {{-- KROK 3: Naskenování QR kódu --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Naskenujte QR kód telefonem</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Google vám na obrazovce počítače zobrazí QR kód. Teď ho naskenujete.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Na telefonu otevřete <strong>Google Authenticator</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klepněte na <strong>+</strong> (vpravo dole) → <strong>Naskenovat QR kód</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Namiřte fotoaparát telefonu na QR kód na monitoru</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>V aplikaci se objeví váš Google účet s <strong>6místným kódem</strong>, který se mění každých 30 sekund</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl">
                <p class="text-xs text-rose-700 dark:text-rose-300 text-center font-medium">
                    ⚠️ <strong>Nefotografujte QR kód!</strong> Obsahuje tajný klíč — kdo ho získá, může generovat vaše kódy.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 4: Ověření kódu --}}
    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Ověřte, že to funguje</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Google vás požádá o zadání kódu z aplikace — tím potvrdíte, že vše funguje.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Podívejte se na aktuální <strong>6místný kód</strong> v Google Authenticator</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Zadejte ho do pole na obrazovce počítače a klikněte <strong>Ověřit</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Pokud kód expiruje (odpočet je téměř na nule), počkejte na nový</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                <p class="text-xs text-emerald-700 dark:text-emerald-300 text-center font-medium">
                    ✅ Po úspěšném ověření je TOTP na vašem Google účtu aktivní. Při každém přihlášení z nového zařízení budete zadávat kód z aplikace.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 5: Záložní kódy + další služby --}}
    <div x-show="currentStep === 5" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Uložte si záložní kódy a zabezpečte další služby</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Recovery kódy vás zachrání, když ztratíte telefon.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl p-5">
                <h4 class="font-bold text-sm text-rose-600 dark:text-rose-400 mb-3">⚠️ Záložní kódy — neudělejte tuto chybu</h4>
                <ol class="space-y-2 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-rose-500 text-white rounded-full text-xs font-bold shrink-0">!</span>
                        <span>Google vám vygeneruje <strong>10 jednorázových záložních kódů</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-rose-500 text-white rounded-full text-xs font-bold shrink-0">!</span>
                        <span><strong>Vytiskněte je</strong> nebo uložte do password manažeru — ne do poznámek na telefonu!</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-rose-500 text-white rounded-full text-xs font-bold shrink-0">!</span>
                        <span>Bez těchto kódů se k účtu <strong>nedostanete</strong>, pokud ztratíte telefon</span>
                    </li>
                </ol>
            </div>

            {{-- Další služby --}}
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-3">Zapněte TOTP i na dalších službách</h4>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="w-8 h-8 bg-slate-800 dark:bg-white/10 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0">GH</span>
                        <div class="flex-1">
                            <strong class="text-slate-800 dark:text-slate-200">GitHub</strong>
                            <span class="block text-[10px] font-mono text-slate-400">Settings → Password and authentication → Enable 2FA</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0">IG</span>
                        <div class="flex-1">
                            <strong class="text-slate-800 dark:text-slate-200">Instagram</strong>
                            <span class="block text-[10px] font-mono text-slate-400">Nastavení → Zabezpečení → Dvoufázové ověření → Ověřovací aplikace</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0">DC</span>
                        <div class="flex-1">
                            <strong class="text-slate-800 dark:text-slate-200">Discord</strong>
                            <span class="block text-[10px] font-mono text-slate-400">Uživatelská nastavení → Můj účet → Zapnout 2FA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center">
                <div class="text-3xl mb-2">🎉</div>
                <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Hotovo!</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Váš účet je chráněn TOTP. Opakujte postup na každé službě, kterou aktivně používáte.</p>
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
