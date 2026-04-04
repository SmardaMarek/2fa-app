{{-- SMS OTP Guide: Konkrétní návod na přechod z SMS na bezpečnější metodu --}}
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

    {{-- KROK 1: Zabezpečte svou SIM u operátora --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zabezpečte svou SIM kartu u operátora</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Prvním krokem je ochrana proti SIM Swappingu — útoku, který jste provedli v simulaci.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-4">Co udělat — zabere to 5 minut</h4>
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Zavolejte na zákaznickou linku svého operátora (T-Mobile: 4603, O2: 800 02 02 02, Vodafone: 800 77 00 77)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Požádejte o <strong>nastavení autorizačního PINu</strong> pro veškeré změny na účtu (výměna SIM, portace čísla)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Zeptejte se, zda nabízejí <strong>eSIM</strong> — tu nelze fyzicky vyměnit na pobočce</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl">
                <p class="text-xs text-rose-700 dark:text-rose-300 text-center font-medium">
                    ⚠️ <strong>Proč to udělat hned?</strong> Bez PINu stačí útočníkovi vaše jméno a rodné číslo — přesně jako v simulaci.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 2: Přepněte Google účet z SMS na Authenticator --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Přepněte Google účet z SMS na Authenticator</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Pokud máte na Google účtu aktivní SMS ověření, nahraďte ho za TOTP aplikaci.</p>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong class="text-amber-600 dark:text-amber-400">myaccount.google.com/security</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klikněte na <strong>Dvoufázové ověření</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>V sekci „Aplikace Authenticator" klikněte <strong>Nastavit</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Naskenujte QR kód v Google Authenticator (viz modul TOTP)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">5</span>
                        <span>Po ověření <strong>odstraňte telefonní číslo</strong> jako záložní metodu (pokud to Google umožní)</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    {{-- KROK 3: Zkontrolujte další služby --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zkontrolujte další služby, kde máte SMS</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Projděte si tento seznam a u každé služby aktivujte silnější metodu.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-3">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <span class="w-10 h-10 bg-blue-600/10 rounded-lg flex items-center justify-center text-lg shrink-0">f</span>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Facebook</h4>
                    <p class="text-[10px] text-slate-400 font-mono">Nastavení → Zabezpečení → Dvoufázové ověření → Ověřovací aplikace</p>
                </div>
                <span class="text-[9px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded uppercase font-bold">Přepněte</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <span class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white text-xs font-bold shrink-0">IG</span>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Instagram</h4>
                    <p class="text-[10px] text-slate-400 font-mono">Nastavení → Zabezpečení → Dvoufázové ověření → Ověřovací aplikace</p>
                </div>
                <span class="text-[9px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded uppercase font-bold">Přepněte</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <span class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center shrink-0">🏦</span>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Banka</h4>
                    <p class="text-[10px] text-slate-400">Aktivujte potvrzování přes <strong>mobilní aplikaci</strong> (push notifikace) místo SMS</p>
                </div>
                <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded uppercase font-bold">Ověřte</span>
            </div>
        </div>
    </div>

    {{-- KROK 4: Skryjte své číslo --}}
    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Chraňte své telefonní číslo</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">SIM Swap začíná tím, že útočník zná vaše číslo. Omezte jeho dostupnost.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-3">Praktické kroky</h4>
                <ul class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0">✓</span>
                        <span>Na sociálních sítích <strong>skryjte své telefonní číslo</strong> z profilu</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0">✓</span>
                        <span>Nepřihlašujte se číslem — používejte <strong>e-mail jako login</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0">✓</span>
                        <span>Zvažte <strong>sekundární číslo</strong> pro služby, kde musíte číslo uvést (e-shopy, registrace)</span>
                    </li>
                </ul>
            </div>

            <div class="p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center">
                <div class="text-3xl mb-2">🔒</div>
                <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Gratulujeme!</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Zabezpečili jste SIM u operátora, přepnuli služby z SMS na Authenticator a omezili dostupnost svého čísla.</p>
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
