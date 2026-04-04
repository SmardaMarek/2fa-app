{{-- FIDO2 Guide: Průvodce nastavením Passkeys --}}
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

    {{-- KROK 1: Co jsou Passkeys --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Co jsou Passkeys?</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Passkeys jsou moderní náhrada hesel. Nepotřebujete fyzický klíč — stačí váš telefon nebo notebook.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-lg mx-auto">
            <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-center">
                <div class="text-2xl mb-2">🔐</div>
                <h4 class="font-bold text-xs text-emerald-600 dark:text-emerald-400 mb-1">Bez hesla</h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400">Přihlášení otiskem nebo obličejem</p>
            </div>
            <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-center">
                <div class="text-2xl mb-2">🛡️</div>
                <h4 class="font-bold text-xs text-emerald-600 dark:text-emerald-400 mb-1">Anti-phishing</h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400">Kryptograficky vázáno na doménu</p>
            </div>
            <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-center">
                <div class="text-2xl mb-2">💰</div>
                <h4 class="font-bold text-xs text-emerald-600 dark:text-emerald-400 mb-1">Zdarma</h4>
                <p class="text-[10px] text-slate-500 dark:text-slate-400">Vestavěno v telefonu a prohlížeči</p>
            </div>
        </div>

        <div class="mt-6 p-4 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl max-w-lg mx-auto">
            <p class="text-xs text-indigo-700 dark:text-indigo-300 text-center font-medium">
                💡 <strong>Passkeys ≠ fyzický klíč.</strong> Passkey je uložen přímo ve vašem zařízení a odemyká se biometrií. Žádný USB klíč nepotřebujete.
            </p>
        </div>
    </div>

    {{-- KROK 2: Nastavení na Google účtu --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Vytvořte svůj první Passkey</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Ukážeme si to na Google účtu — nejrychlejší způsob, jak začít.</p>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong x-text="platform === 'android' ? 'Chrome na telefonu' : 'Safari na iPhonu'"></strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Přejděte na <strong class="font-mono text-indigo-600 dark:text-indigo-400">g.co/passkeys</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Přihlaste se ke svému Google účtu</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Klepněte na <strong>„Vytvořit přístupový klíč"</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">5</span>
                        <span x-text="platform === 'android' ? 'Potvrďte otiskem prstu nebo zámkem obrazovky' : 'Potvrďte pomocí Face ID nebo Touch ID'"></span>
                    </li>
                </ol>
            </div>

            <div class="mt-4 p-4 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                <p class="text-xs text-emerald-700 dark:text-emerald-300 text-center font-medium">
                    ✅ Hotovo! Příště se do Google přihlásíte bez hesla — stačí biometrie.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 3: Další služby --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Přidejte Passkeys na další služby</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Stále více služeb Passkeys podporuje. Tady jsou ty nejznámější:</p>
        </div>

        <div class="space-y-3 max-w-lg mx-auto">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-slate-700/10 dark:bg-white/10 rounded-lg flex items-center justify-center text-lg shrink-0">⌨️</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">GitHub</h4>
                    <p class="text-[10px] text-slate-400 font-mono">Settings → Password and authentication → Add a passkey</p>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center text-lg shrink-0">Ⓜ️</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Microsoft</h4>
                    <p class="text-[10px] text-slate-400 font-mono">account.microsoft.com → Zabezpečení → Přístupové klíče</p>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-4 flex items-center gap-4">
                <div class="w-10 h-10 bg-slate-500/10 rounded-lg flex items-center justify-center text-lg shrink-0">🍎</div>
                <div class="flex-1">
                    <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">Apple</h4>
                    <p class="text-[10px] text-slate-400 font-mono">appleid.apple.com → Přihlášení a zabezpečení → Přístupové klíče</p>
                </div>
            </div>
        </div>

        <div class="mt-6 p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center max-w-lg mx-auto">
            <div class="text-3xl mb-2">🏆</div>
            <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Nejvyšší úroveň ochrany</h4>
            <p class="text-xs text-slate-600 dark:text-slate-400">Passkeys jsou odolné vůči phishingu díky Origin Binding — útočník nemůže klíč zneužít na jiné doméně.</p>
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
