<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Co je SMS-OTP (Out-of-Band)?</h3>
    <p class="dark:text-slate-300 leading-relaxed text-justify">
        <strong>SMS-OTP (One-Time Password)</strong> představuje metodu ověřování „mimo hlavní kanál“ (Out-of-Band). Na rozdíl od moderních metod není kód generován lokálně ve vašem zařízení, ale na straně serveru. Bezpečnost zde nespočívá v kryptografii, ale v <strong>časově omezené platnosti</strong> (typicky 30–300 sekund) a jednorázovosti kódu, který je doručován na základě vazby mezi vaším veřejným telefonním číslem (MSISDN) a fyzickou SIM kartou (IMSI).
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl transition-all hover:shadow-indigo-500/10">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Inženýrský pohled: Architektura doručování</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </div>
        <div class="p-6">
            <div class="mb-6 rounded-lg overflow-hidden border border-indigo-500/20 bg-slate-900/50 p-4">
                <img src="{{ asset('img/otp-schema.png') }}" alt="SMS OTP Architecture and Delivery Flow" class="w-full h-auto opacity-90">
                <p class="text-[10px] text-slate-500 mt-2 italic text-right">Zdroj: SMSLane - Princip doručování OTP přes SMS bránu</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-2 border-l-2 border-indigo-500/30 pl-4">
                    <h4 class="text-xs font-bold text-indigo-400 uppercase tracking-tighter">Generování (Server-Side)</h4>
                    <p class="text-[11px] text-slate-400">
                        Server vygeneruje náhodné n-místné číslo a uloží jej do dočasné paměti s omezenou dobou platnosti. Kód je následně odeslán jako prostý text prostřednictvím mobilní sítě na zařízení uživatele.
                    </p>
                </div>
                <div class="space-y-2 border-l-2 border-emerald-500/30 pl-4">
                    <h4 class="text-xs font-bold text-emerald-400 uppercase tracking-tighter">Transportní vrstva</h4>
                    <p class="text-[11px] text-slate-400">
                        Kód cestuje skrze signalizační síť <strong>SS7 (Signalling System No. 7)</strong>. Tento protokol vznikl v dobách absolutní důvěry mezi operátory a postrádá moderní šifrování, což umožňuje odposlech na úrovni roamingových uzlů.
                    </p>
                </div>
            </div>
            <div class="bg-slate-950/50 p-4 rounded-xl border border-indigo-500/20 font-mono text-[10px] text-indigo-300 shadow-inner">
                <span class="text-indigo-500 font-bold">Stack:</span> Auth Server -> SMS brána -> SS7 síť -> HLR -> Mobilní zařízení
            </div>
        </div>
    </div>

    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Kritické strukturální slabiny</h3>
    <p class="dark:text-slate-300 leading-relaxed text-justify">
        I když je SMS MFA lepší než žádné MFA, bezpečnostní autority jako <strong>NIST (SP 800-63B)</strong> od ní explicitně odrazují. Důvodem je, že útočník nemusí hacknout vaši aplikaci, ale „hackne“ telekomunikační cestu k vám.
    </p>

    <div class="grid grid-cols-1 gap-4 my-8">
        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-all duration-300 shadow-lg group">
            <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1 uppercase tracking-tighter text-xs">SIM Swapping (HLR Manipulation)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Nejnebezpečnější útok. Útočník pomocí sociálního inženýrství přesvědčí operátora k převodu čísla na novou SIM kartu. V registru <strong>HLR (Home Location Register)</strong> se změní mapování a veškeré OTP kódy začnou chodit útočníkovi, zatímco váš telefon ztratí signál.
                </p>
            </div>
        </div>

        <div class="flex flex-col bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-all duration-300 shadow-lg group">
            <div class="flex items-start mb-4">
                <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <strong class="text-slate-100 block mb-1 uppercase tracking-tighter text-xs">Interception (SS7 Vulnerabilities)</strong>
                    <p class="text-xs dark:text-slate-400 leading-relaxed">
                        Útočníci s přístupem k globální signalizační síti mohou podvrhnout zprávu o změně lokality vašeho zařízení. SMS s kódem je pak přesměrována do útočníkovy sítě, aniž by došlo k jakémukoliv fyzickému zásahu do vašeho telefonu.
                    </p>
                </div>
            </div>
            <div class="rounded-xl overflow-hidden bg-slate-900 p-4 border border-slate-700/50">

                <p class="text-[9px] text-slate-500 mt-2 italic text-right">Vektor útoku na signalizační vrstvu mobilní sítě</p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-rose-500/50 transition-all duration-300 shadow-lg group">
            <div class="mr-4 mt-1 bg-rose-500/20 p-2 rounded-lg text-rose-400 group-hover:bg-rose-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1 uppercase tracking-tighter text-xs">Absence Origin Bindingu</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    SMS je prostý text bez kryptografické vazby na TLS relaci. Pokud vás útočník naláká na falešný web, kód z SMS mu tam ochotně přepíšete, protože zpráva neobsahuje mechanismus, který by ověřil, že kód zadáváte na legitimní doméně.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-rose-500 rounded-r-2xl shadow-inner relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 opacity-10">
            <svg class="w-24 h-24 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2v-2zm0-7h2v5h-2V9z"></path></svg>
        </div>
        <h4 class="text-rose-400 font-bold mb-2 uppercase text-[10px] tracking-widest flex items-center">
            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Technický cíl simulace
        </h4>
        <p class="text-sm dark:text-slate-400 leading-relaxed text-justify">
            V následujícím cvičení si vyzkoušíte roli útočníka provádějícího <strong>SIM Swapping</strong> útok. Uvidíte, jak snadné je pomocí sociálního inženýrství přesvědčit operátora k převodu telefonního čísla a následně zachytit SMS kód oběti. Pochopíte, proč je SMS OTP považováno za nejméně bezpečnou formu MFA a proč se doporučuje přechod na silnější autentizační metody.
        </p>
    </div>
</div>
