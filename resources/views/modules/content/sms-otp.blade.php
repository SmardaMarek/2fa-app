<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Co je SMS-OTP (Out-of-Band)?</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        <strong>SMS-OTP (One-Time Password)</strong> je historicky nejrozšířenější metoda OOB autentizace. Funguje na principu vazby mezi veřejným identifikátorem <strong>MSISDN</strong> (telefonní číslo) a hardwarovým identifikátorem <strong>IMSI</strong> na SIM kartě uživatele.
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Architektura doručování</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </div>
        <div class="p-6">
            <p class="text-sm dark:text-slate-300 mb-4 leading-relaxed">
                Na rozdíl od TOTP není kód generován lokálně. Server (Relying Party) generuje <em>n-místný</em> řetězec a odesílá jej skrze SMS bránu do sítě operátora.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[11px] font-mono text-indigo-300 bg-slate-950/50 p-4 rounded-xl border border-indigo-500/20">
                <div><span class="text-indigo-500 font-bold">Iniciace:</span> RandomInt(100000, 999999)</div>
                <div><span class="text-indigo-500 font-bold">Transport:</span> SMPP -> SS7 MAP -> GSM</div>
            </div>
        </div>
    </div>



    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Kritické strukturální slabiny</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        Ačkoliv je SMS stále vnímána jako "vlastněný faktor", z pohledu moderní bezpečnosti (dle <strong>NIST SP 800-63B</strong>) je považována za rizikovou z důvodu inherentní nedůvěryhodnosti signalizačních protokolů:
    </p>

    <div class="grid grid-cols-1 gap-4 my-8">
        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">SIM Swapping (HLR Manipulation)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Útočník manipuluje s registrem <strong>HLR (Home Location Register)</strong> operátora. Přesměrováním MSISDN na novou SIM kartu (IMSI) útočníka se stává legitimním endpointem pro doručení kódu.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">SS7/Diameter Interception</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Využití zranitelností v protokolu <strong>MAP (Mobile Application Part)</strong>. Aktér s přístupem k roamingovému uzlu může podvrhnout zprávu <em>UpdateLocation</em> a odposlechnout SMS v reálném čase.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Absence Origin Bindingu</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Stejně jako u TOTP, ani SMS kód není kryptograficky vázán na TLS relaci nebo doménu. Uživatel jej může pod tlakem sociálního inženýrství přepsat na libovolnou AitM proxy.
                </p>
            </div>
        </div>
    </div>



    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-rose-500 rounded-r-2xl shadow-inner">
        <h4 class="text-rose-400 font-bold mb-2 uppercase text-[10px] tracking-widest flex items-center">
            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Technický cíl simulace
        </h4>
        <p class="text-sm dark:text-slate-400 leading-relaxed">
            V experimentu se zaměříme na <strong>SIM Swapping</strong>. Provedete útok na zákaznickou podporu operátora, vyvoláte deautorizaci legitimní SIM karty oběti a následně zachytíte bankovní SMS kód přímo ve svém útočném terminálu skrze podvržený routing.
        </p>
    </div>
</div>
