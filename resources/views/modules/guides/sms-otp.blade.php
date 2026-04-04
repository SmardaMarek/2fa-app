{{-- SMS OTP Guide: Průvodce bezpečnějšími alternativami --}}
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

    {{-- KROK 1: Kde máte SMS OTP aktivní --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Kde máte SMS ověření aktivní?</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Zkontrolujte, které vaše služby stále používají SMS jako druhý faktor. Typicky to jsou:</p>
        </div>

        <div class="space-y-3 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center shrink-0">🏦</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Internetové bankovnictví</h4>
                    <p class="text-[10px] text-slate-400">Většina českých bank stále posílá potvrzovací SMS</p>
                </div>
                <span class="text-[9px] bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded uppercase font-bold">Riziko</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-green-500/10 rounded-lg flex items-center justify-center shrink-0">📱</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Sociální sítě</h4>
                    <p class="text-[10px] text-slate-400">Facebook, Instagram — často výchozí metoda</p>
                </div>
                <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded uppercase font-bold">Změňte</span>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-purple-500/10 rounded-lg flex items-center justify-center shrink-0">📧</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">E-mailové služby</h4>
                    <p class="text-[10px] text-slate-400">Gmail, Seznam — nabízejí lepší alternativy</p>
                </div>
                <span class="text-[9px] bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded uppercase font-bold">Změňte</span>
            </div>
        </div>
    </div>

    {{-- KROK 2: Proč SMS nestačí --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-rose-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Proč přejít z SMS na silnější metodu?</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Jak jste viděli v simulaci, SMS OTP má zásadní zranitelnosti.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-lg mx-auto">
            <div class="bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-xl p-4">
                <h4 class="font-bold text-xs text-rose-500 uppercase tracking-wider mb-2">❌ SMS OTP</h4>
                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-1.5">
                    <li>• SIM Swapping útok</li>
                    <li>• SS7 odposlech</li>
                    <li>• Závisí na mobilní síti</li>
                    <li>• Kód lze přečíst z notifikace</li>
                </ul>
            </div>
            <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4">
                <h4 class="font-bold text-xs text-emerald-500 uppercase tracking-wider mb-2">✅ TOTP / Passkeys</h4>
                <ul class="text-xs text-slate-600 dark:text-slate-400 space-y-1.5">
                    <li>• Kód se generuje offline</li>
                    <li>• Nelze odposlechnout</li>
                    <li>• Funguje bez signálu</li>
                    <li>• Passkeys: phishing-resistant</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- KROK 3: Jak přepnout --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Přepněte na bezpečnější metodu</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">U většiny služeb lze SMS nahradit za TOTP aplikaci nebo Passkey.</p>
        </div>

        <div class="space-y-3 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-2">Google účet</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">myaccount.google.com → Zabezpečení → Dvoufázové ověření → <strong>Přidat aplikaci Authenticator</strong></p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-2">Facebook</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Nastavení → Zabezpečení → Dvoufázové ověření → <strong>Změnit na Authenticator</strong></p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-2">Bankovnictví</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">Většina bank přechází na potvrzení v <strong>mobilní aplikaci</strong> (push notifikace). Pokud to vaše banka nabízí, aktivujte to.</p>
            </div>
        </div>

        <div class="mt-6 p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center max-w-lg mx-auto">
            <div class="text-3xl mb-2">🔒</div>
            <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Každý krok se počítá</h4>
            <p class="text-xs text-slate-600 dark:text-slate-400">I přepnutí jednoho účtu z SMS na TOTP výrazně zvyšuje vaše zabezpečení.</p>
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
