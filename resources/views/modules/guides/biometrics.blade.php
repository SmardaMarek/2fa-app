{{-- Biometrie Guide: Konkrétní nastavení Windows Hello, Face ID a Android --}}
<div x-data="{ currentStep: 1, totalSteps: 4, platform: 'windows' }">

    {{-- Výběr platformy --}}
    <div class="flex items-center justify-center gap-4 mb-8">
        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Vaše zařízení:</span>
        <div class="flex flex-wrap bg-slate-100 dark:bg-slate-900/50 rounded-xl p-1 border border-slate-200 dark:border-slate-700 gap-0.5">
            <button @click="platform = 'windows'" :class="platform === 'windows' ? 'bg-white dark:bg-slate-700 shadow-sm text-blue-600 dark:text-blue-400' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                🪟 Windows
            </button>
            <button @click="platform = 'android'" :class="platform === 'android' ? 'bg-white dark:bg-slate-700 shadow-sm text-emerald-600 dark:text-emerald-400' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                 Android
            </button>
            <button @click="platform = 'iphone'" :class="platform === 'iphone' ? 'bg-white dark:bg-slate-700 shadow-sm text-slate-600 dark:text-slate-300' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="px-3 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                🍎 iPhone
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

    {{-- KROK 1: Nastavení biometrie na zařízení --}}
    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Nastavte biometrii na svém zařízení</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Zvolte platformu výše a postupujte krok za krokem.</p>
        </div>

        <div class="max-w-lg mx-auto">
            {{-- Windows Hello --}}
            <div x-show="platform === 'windows'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-4">🪟 Windows Hello — otisk prstu nebo obličej</h4>
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Nastavení</strong> (Win + I)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Přejděte na <strong>Účty → Možnosti přihlášení</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Klikněte na <strong>Rozpoznání obličeje (Windows Hello)</strong> nebo <strong>Rozpoznání otisku prstu</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Klikněte <strong>Nastavit</strong>, zadejte PIN a postupujte dle pokynů</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">5</span>
                        <span>U otisku: přikládejte prst z <strong>různých úhlů</strong>, dokud se lišta nenaplní</span>
                    </li>
                </ol>

                <div class="mt-4 p-3 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-lg">
                    <p class="text-xs text-indigo-700 dark:text-indigo-300 font-medium">
                        💡 <strong>Nemáte senzor?</strong> Většina moderních notebooků (ThinkPad, Surface, Dell XPS) ho má vestavěný. Pro stolní PC existují USB čtečky otisků (cca 500 Kč).
                    </p>
                </div>
            </div>

            {{-- Android --}}
            <div x-show="platform === 'android'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-4"> Android — otisk prstu nebo obličej</h4>
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Nastavení → Zabezpečení → Biometrie</strong> (u Samsung: Biometrie a zabezpečení)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Zvolte <strong>Otisk prstu</strong> → zadejte PIN/vzor jako zálohu</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Přikládejte prst k senzoru — <strong>opakovaně z různých úhlů</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Zaregistrujte <strong>2 prsty</strong> (palec pravé i levé ruky)</span>
                    </li>
                </ol>
            </div>

            {{-- iPhone --}}
            <div x-show="platform === 'iphone'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-slate-600 dark:text-slate-300 uppercase tracking-wider mb-4">🍎 iPhone — Face ID nebo Touch ID</h4>
                <ol class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong>Nastavení → Face ID a kódový zámek</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klepněte <strong>Nastavit Face ID</strong> (nebo Touch ID)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Face ID: pomalu <strong>otáčejte hlavou v kruhu</strong>, dokud se sken nedokončí (2 skeny)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Zapněte Face ID pro <strong>odemykání</strong>, <strong>App Store</strong> i <strong>Platby</strong></span>
                    </li>
                </ol>

                <div class="mt-4 p-3 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-lg">
                    <p class="text-xs text-indigo-700 dark:text-indigo-300 font-medium">
                        💡 <strong>Bonus:</strong> Klepněte na <strong>Nastavit alternativní vzhled</strong> — pomůže to s rozpoznáním v brýlích, čepici nebo roušce.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- KROK 2: Windows Hello jako Passkey v prohlížeči --}}
    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Přihlaste se biometrií do webových služeb</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Windows Hello a Face ID/Touch ID fungují jako Passkey — přihlásíte se otiskem místo hesla.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            {{-- Windows Hello Passkey --}}
            <div x-show="platform === 'windows'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-blue-600 dark:text-blue-400 mb-3">Windows Hello jako Passkey (např. pro Google)</h4>
                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete <strong class="text-amber-600 dark:text-amber-400">myaccount.google.com/security</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>V sekci „Jak se přihlašujete" klikněte <strong>Přístupové klíče a bezpečnostní klíče</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Klikněte <strong>Vytvořit přístupový klíč</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Prohlížeč zobrazí dialog Windows Hello — <strong>přiložte prst</strong> nebo se <strong>podívejte do kamery</strong></span>
                    </li>
                </ol>
            </div>

            {{-- Android / iPhone --}}
            <div x-show="platform !== 'windows'" class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-3" x-text="platform === 'android' ? 'Passkey na Androidu (např. pro Google)' : 'Passkey na iPhonu (např. pro Google)'"></h4>
                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>V prohlížeči na telefonu otevřete <strong class="text-amber-600 dark:text-amber-400">myaccount.google.com/security</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Klikněte na <strong>Přístupové klíče a bezpečnostní klíče</strong> → <strong>Vytvořit přístupový klíč</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span x-text="platform === 'android' ? 'Systém se zeptá na otisk prstu — přiložte prst k senzoru' : 'Systém vás požádá o Face ID — podívejte se na displej'"></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Passkey se uloží do <span x-text="platform === 'android' ? 'Google Password Manageru' : 'iCloud Klíčenky'"></span> a synchronizuje se na všechna vaše zařízení</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-xl">
                <p class="text-xs text-emerald-700 dark:text-emerald-300 text-center font-medium">
                    ✅ Příště se k Google přihlásíte <strong>jedním dotykem</strong> — bez hesla a bez kódu.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 3: Biometrie v bankovní aplikaci --}}
    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Zapněte biometrii v mobilním bankovnictví</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Biometrie v bance slouží jako lokální ověření — nahrazuje zadávání PINu.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100 mb-3">Obecný postup (platí pro většinu bank)</h4>
                <ol class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">1</span>
                        <span>Otevřete bankovní aplikaci a přihlaste se PINem</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">2</span>
                        <span>Přejděte do <strong>Nastavení → Zabezpečení</strong> (nebo Přihlášení)</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">3</span>
                        <span>Zapněte <strong>Přihlášení otiskem prstu / obličejem</strong></span>
                    </li>
                    <li class="flex gap-3">
                        <span class="flex items-center justify-center w-6 h-6 bg-amber-500 text-white rounded-full text-xs font-bold shrink-0">4</span>
                        <span>Zapněte i <strong>Potvrzování plateb biometrií</strong> (místo SMS kódu)</span>
                    </li>
                </ol>
            </div>

            <div class="p-4 bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-xl">
                <p class="text-xs text-indigo-700 dark:text-indigo-300 text-center font-medium">
                    💡 <strong>Víte, že:</strong> Biometrie v bance nevystavuje váš otisk riziku. Porovnání probíhá lokálně v Secure Enclave — banka váš otisk nikdy nevidí.
                </p>
            </div>
        </div>
    </div>

    {{-- KROK 4: Bezpečnostní doporučení --}}
    <div x-show="currentStep === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-500/10 rounded-2xl mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Co mít na paměti</h3>
            <p class="text-slate-500 dark:text-slate-400 text-sm max-w-md mx-auto">Biometrie je pohodlná, ale nezapomeňte na tyto zásady.</p>
        </div>

        <div class="max-w-lg mx-auto space-y-4">
            <div class="bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl p-5">
                <ul class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0 text-lg">✓</span>
                        <div>
                            <strong class="text-slate-800 dark:text-slate-100">Vždy mějte záložní PIN/heslo</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Mokré prsty, sluneční brýle nebo zranění = biometrie selže. PIN vás zachrání.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0 text-lg">✓</span>
                        <div>
                            <strong class="text-slate-800 dark:text-slate-100">Kombinujte biometrii s dalším faktorem</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Samotná biometrie je „něco, co jsem" — doplňte ji PINem („co vím") nebo klíčem („co mám").</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-rose-500 font-bold shrink-0 text-lg">!</span>
                        <div>
                            <strong class="text-slate-800 dark:text-slate-100">Biometrii nelze změnit</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Na rozdíl od hesla si „nový obličej" nevytvoříte. Proto se biometrie vyhodnocuje lokálně v hardwaru, nikoliv na serveru.</p>
                        </div>
                    </li>
                    <li class="flex gap-3">
                        <span class="text-emerald-500 font-bold shrink-0 text-lg">✓</span>
                        <div>
                            <strong class="text-slate-800 dark:text-slate-100">Preferujte 3D senzory</strong>
                            <p class="text-xs text-slate-400 mt-0.5">Face ID (IR projektor) je výrazně bezpečnější než 2D kamera — jak jste viděli v simulaci Presentation Attacku.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="p-5 bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center">
                <div class="text-3xl mb-2">👆</div>
                <h4 class="font-bold text-emerald-700 dark:text-emerald-400 mb-1">Hotovo!</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Máte nastavenou biometrii na zařízení, v prohlížeči jako Passkey a v bankovní aplikaci. Vaše přihlašování je teď rychlejší a bezpečnější.</p>
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
