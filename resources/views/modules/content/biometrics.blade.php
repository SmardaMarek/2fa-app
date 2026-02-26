<div class="prose dark:prose-invert prose-indigo max-w-none">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Biometrie jako faktor inherence</h3>
    <p class="dark:text-slate-300">
        Biometrie („něco, co jste“) využívá k autentizaci unikátní fyziologické nebo behaviorální charakteristiky subjektu. Na rozdíl od TOTP či SMS se nejedná o diskrétní binární shodu, ale o <strong>stochastický proces</strong> porovnávání vzorků s uloženou referenční šablonou.
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Pravděpodobnostní modelování (Error Rates)</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <div class="p-6">
            <p class="text-sm dark:text-slate-300 mb-4">
                Klíčem k hodnocení biometrického systému je bod <strong>EER (Equal Error Rate)</strong>, kde platí:
            </p>
            <div class="font-mono text-lg text-indigo-300 text-center my-4">
                $$FAR(\tau) = FRR(\tau) \rightarrow EER$$
            </div>
            <p class="text-[11px] dark:text-slate-400 leading-relaxed italic border-t border-indigo-500/20 pt-4">
                <strong>FAR (False Acceptance Rate):</strong> pravděpodobnost neoprávněného přístupu. <br>
                <strong>FRR (False Rejection Rate):</strong> pravděpodobnost odmítnutí legitimního uživatele.
            </p>
        </div>
    </div>



    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">Bezpečnostní architektura (TEE & Enclave)</h3>
    <p class="dark:text-slate-300">
        Moderní systémy (např. Apple Secure Enclave nebo ARM TrustZone) nikdy nepracují s <strong>raw daty</strong> senzoru. Obraz otisku či obličeje je transformován na matematický model (šablonu).
    </p>

    <ul class="space-y-4 list-none pl-0 dark:text-slate-300">
        <li class="flex items-start bg-slate-800/40 p-4 rounded-xl border border-slate-700/50">
            <div class="mr-4 mt-1 text-indigo-500 font-mono font-bold">01</div>
            <div>
                <strong class="text-slate-100">Hardwarová izolace:</strong> Porovnání probíhá v dedikovaném procesoru, ke kterému nemá přístup ani jádro OS. Kompromitace systému neznamená kompromitaci biometrie.
            </div>
        </li>
        <li class="flex items-start bg-slate-800/40 p-4 rounded-xl border border-slate-700/50">
            <div class="mr-4 mt-1 text-indigo-500 font-mono font-bold">02</div>
            <div>
                <strong class="text-slate-100">Neodvolatelnost (Non-revocability):</strong> Pokud je biometrická šablona odcizena, nelze ji "změnit" jako heslo. Proto je kritické šablony ukládat pomocí <em>Cancelable Biometrics</em> (transformací, které lze v případě úniku zneplatnit).
            </div>
        </li>
        <li class="flex items-start bg-slate-800/40 p-4 rounded-xl border border-slate-700/50">
            <div class="mr-4 mt-1 text-indigo-500 font-mono font-bold">03</div>
            <div>
                <strong class="text-slate-100">Presentation Attack Detection (PAD):</strong> Biometrie je náchylná na spoofing (2D fotky, 3D masky). Systémy OI úrovně musí implementovat <em>Liveness Detection</em> (detekci živosti) pomocí multispektrální analýzy nebo výzev k akci.
            </div>
        </li>
    </ul>



    <div class="mt-8 p-6 bg-slate-900 border-l-4 border-indigo-500 rounded-r-2xl shadow-inner">
        <h4 class="text-indigo-400 font-bold mb-2 uppercase text-xs tracking-widest">Vektor úroku v simulaci</h4>
        <p class="text-sm dark:text-slate-400">
            V simulaci se zaměříme na <strong>Presentation Attack</strong>. Ukážeme si, jak jednoduchá absence hloubkového senzoru (IR/LiDAR) u levnějších implementací obličejové autentizace dovoluje bypass systému pomocí statického obrazu s vysokým rozlišením.
        </p>
    </div>
</div>
