<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Co je TOTP (Authenticator)?</h3>
    <p class="dark:text-slate-300 leading-relaxed text-justify">
        <strong>TOTP (Time-based One-Time Password)</strong>, definovaný v <strong>RFC 6238</strong>, představuje algoritmus generující jednorázová hesla synchronizovaná časem. Na rozdíl od SMS mechanismů je TOTP plně autonomní a nevyžaduje interakci s infrastrukturou operátora. Jde o symetrický systém, kde obě strany znají stejné tajemství (Seed).
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl transition-all hover:shadow-indigo-500/10">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Kryptografické jádro (RFC 6238)</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m9-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="p-6">
            <div class="mb-6 rounded-lg overflow-hidden border border-indigo-500/20 bg-slate-900/50 p-4">
                <img src="{{ asset('img/totp-schema.jpg') }}" alt="TOTP Algorithm Schema" class="w-full h-auto opacity-90">
                <p class="text-[10px] text-slate-500 mt-2 italic text-right">Zdroj: Medium - Securing Your App</p>
            </div>

            <p class="text-sm dark:text-slate-300 mb-4 leading-relaxed">
                Výpočet probíhá lokálně jako hash <strong>HMAC-SHA1</strong> aktuálního Unixového času vyděleného periodou (standardně 30s). Výsledek je následně podroben <strong>dynamickému ořezu (Dynamic Truncation)</strong>, který z binárního hashe vyextrahuje 6–8místný číselný kód.
            </p>

            <div class="font-mono text-lg text-indigo-300 text-center my-4 bg-slate-950/50 py-4 rounded-xl border border-indigo-500/20 shadow-inner">
                $$TOTP = Truncate(HMAC-SHA1(K, T))$$
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[11px] font-mono text-indigo-400 border-t border-indigo-500/20 pt-4">
                <div class="flex items-center"><span class="text-indigo-500 font-bold mr-2">></span> K: Symetrický tajný klíč (Seed)</div>
                <div class="flex items-center"><span class="text-indigo-500 font-bold mr-2">></span> T: Časový krok (Epoch / 30s)</div>
            </div>
        </div>
    </div>

    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Analýza zranitelnosti vůči AitM</h3>
    <p class="dark:text-slate-300 leading-relaxed text-justify">
        I když TOTP eliminuje rizika SS7 sítě a SIM swappingu, zůstává zranitelné vůči útokům <strong>Adversary-in-the-Middle (AitM)</strong>. Důvodem je chybějící vazba na původ požadavku.
    </p>

    <div class="grid grid-cols-1 gap-4 my-8">
        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-all group shadow-lg">
            <div class="mr-4 mt-1 bg-indigo-500/20 p-2 rounded-lg text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1 uppercase tracking-tighter text-xs">Real-time Proxying</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Útočník zachytí OTP kód na podvržené doméně a v rámci platnosti časového okna jej okamžitě přepošle legitimní službě. Bez kryptografické vazby na doménu (Origin Binding) nemá server jak poznat, že kód byl zadán na cizím webu.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-all group shadow-lg">
            <div class="mr-4 mt-1 bg-indigo-500/20 p-2 rounded-lg text-indigo-400 group-hover:bg-indigo-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A10.003 10.003 0 0012 20a10.003 10.003 0 006.239-2.223l.054.09m-1.333-5.411c-1.66-3.11-4.822-5.366-8.506-5.366-3.684 0-6.846 2.256-8.506 5.366m17.012 0a9.97 9.97 0 011.012 4.429c0 2.263-.751 4.35-2.02 6.023m-15 0a9.97 9.97 0 01-2.02-6.023c0-2.263.751-4.35 2.02-6.023"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1 uppercase tracking-tighter text-xs">Bezpečnost Seedu (Endpoint Security)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Důvěra systému je plně přenesena na integritu koncového zařízení. Pokud útočník získá přístup k odemčenému telefonu nebo extrahuje seed z nechráněné paměti aplikace, může generovat identické kódy paralelně s uživatelem.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-indigo-500 rounded-r-2xl shadow-inner relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 opacity-10">
            <svg class="w-24 h-24 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"></path></svg>
        </div>
        <h4 class="text-indigo-400 font-bold mb-2 uppercase text-[10px] tracking-widest flex items-center">
            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Technický cíl simulace
        </h4>
        <p class="text-sm dark:text-slate-400 leading-relaxed">
            V následující části si naprogramujete vlastní <strong>TOTP generátor</strong>. Pochopíte proces bitového posunu a dynamického ořezu, který transformuje surový hash na lidsky čitelný kód. Následně provedete simulovaný <strong>AitM útok</strong> pomocí phishingového frameworku a zjistíte, jak útočník automatizuje zachycení kódu dříve, než vyprší jeho 30sekundová platnost.
        </p>
    </div>
</div>
