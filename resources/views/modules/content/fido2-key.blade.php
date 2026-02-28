<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Co je FIDO2 a WebAuthn (Passkeys)?</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        <strong>FIDO2</strong> (Fast IDentity Online) a jeho webové API <strong>WebAuthn</strong> představují současný zlatý standard bezheslové autentizace (Passwordless). Na rozdíl od předchozích metod (MFA nad heslem) kompletně opouští koncept sdíleného tajemství a přechází na <strong>asymetrickou kryptografii</strong> přímo vázanou na hardware uživatele.
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Architektura protokolu (CTAP2 + WebAuthn)</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div class="p-6">
            <p class="text-sm dark:text-slate-300 mb-4 leading-relaxed">
                Při registraci vytvoří autentizátor (např. TPM čip, YubiKey nebo Secure Enclave) unikátní pár klíčů pro danou službu (Relying Party). Veřejný klíč se odešle na server, privátní klíč nikdy neopustí hardware uživatele.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-[11px] font-mono text-indigo-300 bg-slate-950/50 p-4 rounded-xl border border-indigo-500/20">
                <div><span class="text-indigo-500 font-bold">Registrace:</span> Generování $K_{pub}$ a $K_{priv}$</div>
                <div><span class="text-indigo-500 font-bold">Ověření:</span> $Sign(K_{priv}, clientDataHash)$</div>
            </div>
        </div>
    </div>



    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Absolutní mitigace hrozeb (AAL3)</h3>
    <p class="dark:text-slate-300 leading-relaxed">
        Podle standardu <strong>NIST SP 800-63B</strong> je FIDO2 klasifikováno jako <em>Phishing-Resistant MFA</em> a splňuje nejvyšší úroveň zabezpečení <strong>AAL3 (Authenticator Assurance Level 3)</strong> díky těmto strukturálním vlastnostem:
    </p>

    <div class="grid grid-cols-1 gap-4 my-8">
        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-emerald-500/20 p-2 rounded-lg text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Origin Binding (Kryptografická vazba domény)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Prohlížeč předává autentizátoru parametr <code>rpId</code> (Relying Party ID) přímo z TLS spojení. Podpis je proveden pouze pokud se <code>rpId</code> shoduje s tím, pro které byl klíč vytvořen. AitM proxy na podvržené doméně je matematicky eliminována.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-emerald-500/20 p-2 rounded-lg text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Absence sdíleného tajemství (Asymmetric Crypto)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Na rozdíl od TOTP, kde server drží stejný tajný klíč jako klient, WebAuthn ukládá na serveru pouze veřejný klíč. Kompromitace databáze banky neumožní útočníkovi generovat platné autentizační tokeny.
                </p>
            </div>
        </div>

        <div class="flex items-start bg-slate-800/40 p-5 rounded-2xl border border-slate-700/50 hover:border-emerald-500/50 transition-colors shadow-lg group">
            <div class="mr-4 mt-1 bg-emerald-500/20 p-2 rounded-lg text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
            </div>
            <div>
                <strong class="text-slate-100 block mb-1">Lokální User Verification (UV & UP)</strong>
                <p class="text-xs dark:text-slate-400 leading-relaxed">
                    Vydání podpisu vyžaduje <em>User Presence</em> (fyzický dotek tokenu) nebo <em>User Verification</em> (biometrie / PIN). Škálovatelné útoky ze zámoří jsou nemožné, protože útočník nedisponuje fyzickým přístupem k modulu TPM/Secure Enclave.
                </p>
            </div>
        </div>
    </div>

    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-indigo-500 rounded-r-2xl shadow-inner">
        <h4 class="text-indigo-400 font-bold mb-2 uppercase text-[10px] tracking-widest flex items-center">
            <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Technický cíl simulace
        </h4>
        <p class="text-sm dark:text-slate-400 leading-relaxed">
            V následující simulaci si architektonicky rozebereme, jak WebAuthn API prohlížeče chrání uživatele. Provedete kryptografickou výzvu (Challenge) na legitimní i phishingové doméně a matematicky si dokážeme, proč je <strong>AitM útok proti FIDO2 nemožný</strong>.
        </p>
    </div>
</div>
