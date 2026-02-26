<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Co je TOTP (Authenticator)?</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        <strong>TOTP (Time-based One-Time Password)</strong>, definovaný v <strong>RFC 6238</strong>, představuje algoritmus generující jednorázová hesla synchronizovaná časem. Na rozdíl od SMS mechanismů je TOTP plně autonomní a nevyžaduje interakci s infrastrukturou mobilního operátora (přenos probíhá v <em>out-of-band</em> režimu).
    </p>

    <div class="my-8 bg-violet-900/20 border border-violet-500/30 rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-violet-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-violet-100 uppercase tracking-widest font-mono">Kryptografické jádro (RFC 6238)</span>
            <svg class="w-4 h-4 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
        </div>
        <div class="p-6">
            <p class="text-sm dark:text-slate-300 mb-4 leading-relaxed">
                Server a klientská aplikace sdílejí <strong>symetrický tajný klíč (K)</strong>. Kód se počítá lokálně jako hash HMAC aktuálního Unixového času (T) vyděleného periodou (X).
            </p>
            <div class="font-mono text-lg text-violet-300 text-center my-4">
                $$TOTP = Truncate(HMAC-SHA(K, T))$$
            </div>
            <p class="text-[11px] dark:text-slate-400 leading-relaxed italic border-t border-violet-500/20 pt-4">
                Klíč (Seed) je obvykle distribuován formou <strong>Base32</strong> řetězce zakódovaného do QR kódu.
            </p>
        </div>
    </div>



    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Bezpečnostní analýza vektoru útoků</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        Ačkoliv TOTP efektivně eliminuje rizika spojená se signalizací <strong>SS7</strong> a <strong>SIM Swappingem</strong>, jeho architektura vykazuje fundamentální slabiny proti moderním technikám sociálního inženýrství:
    </p>

    <div class="grid grid-cols-1 gap-4 my-8">
        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-colors shadow-lg">
            <div class="mr-4 mt-1 bg-indigo-500/20 p-2 rounded-lg text-indigo-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">AitM Phishing (Real-time Proxy)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Útočník v roli transparentní proxy zachycuje OTP kód na podvržené doméně a v rámci platného časového okna (T) jej automatizovaně přeposílá legitimní službě.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-colors shadow-lg">
            <div class="mr-4 mt-1 bg-indigo-500/20 p-2 rounded-lg text-indigo-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H10a1 1 0 01-1-1v-4z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Absence Origin Bindingu</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Kód není kryptograficky svázán s doménou (TLS server certificate). Autentizační token je pro aplikaci platný nezávisle na tom, kde jej uživatel vyplnil.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-colors shadow-lg">
            <div class="mr-4 mt-1 bg-indigo-500/20 p-2 rounded-lg text-indigo-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Endpoint Integrity</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Bezpečnost celého řetězce degraduje na bezpečnost mobilního zařízení. Fyzický přístup k odemčenému telefonu nebo přítomnost malware (screen scrapers) kompromituje druhý faktor.
                </p>
            </div>
        </div>
    </div>



    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-indigo-500 rounded-r-2xl shadow-inner">
        <h4 class="text-indigo-400 font-bold mb-2 uppercase text-[10px] tracking-widest">Architektonický dopad</h4>
        <p class="text-sm dark:text-slate-400 leading-relaxed">
            V simulaci si prakticky vyzkoušíte <strong>AitM útok</strong>. Uvidíte, jak snadné je z pohledu útočníka zautomatizovat zachycení TOTP kódu a jeho okamžité zneužití, pokud systém neimplementuje striktní kontrolu původu požadavku.
        </p>
    </div>
</div>
