<div class="prose dark:prose-invert prose-indigo max-w-none text-justify">
    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x01: Biometrie jako pravděpodobnostní ověření</h3>
    <p class="dark:text-slate-300">
        Biometrie („něco, co jste“) využívá k autentizaci unikátní fyziologické nebo behaviorální rysy osoby. Na rozdíl od hesel se nejedná o diskrétní binární shodu, ale o <strong>vzorové rozpoznávání</strong>. Každý vstup je zatížen šumem, proto systém nehledá identitu, ale <strong>skóre podobnosti</strong> porovnávané s rozhodovacím prahem.
    </p>

    <div class="my-8 bg-indigo-900/20 border border-indigo-500/30 rounded-2xl overflow-hidden shadow-2xl transition-all hover:shadow-indigo-500/10">
        <div class="bg-indigo-600 px-4 py-2 flex items-center justify-between">
            <span class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest font-mono">Architektura biometrického subsystému</span>
            <svg class="w-4 h-4 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div class="p-6">
            <div class="mb-6 rounded-lg overflow-hidden border border-indigo-500/20 bg-slate-900/50 p-4 text-center">
                <img src="{{ asset('img/biometric-schema.png') }}" alt="Biometric Authentication Process" class="mx-auto h-auto max-w-full opacity-90">
                <p class="mt-2 text-right text-[10px] italic text-slate-500">Zdroj: BIO-key (Security of Smartphone Biometrics)</p>
            </div>

            <p class="mb-4 text-sm leading-relaxed dark:text-slate-300">
                Proces začíná u <strong>Senzoru</strong>, který digitalizuje analogový signál. Klíčovým krokem je <strong>Extrakce příznaků</strong>, kde se z Raw dat vytvoří matematický vektor. Tento vektor se pak v <strong>Matcheru</strong> porovná s uloženou šablonou (Template).
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 rounded-xl border border-indigo-500/20 bg-slate-950/50 p-4 font-mono text-[11px] text-indigo-300 shadow-inner">
                <div class="flex items-center"><span class="mr-2 font-bold text-indigo-500 uppercase tracking-tighter">Vstup:</span> Analogový signál (Otisk/Tvář)</div>
                <div class="flex items-center"><span class="mr-2 font-bold text-indigo-500 uppercase tracking-tighter">Výstup:</span> Similarity Score (Pravděpodobnost)</div>
            </div>
        </div>
    </div>

    <div class="my-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="rounded-2xl border border-slate-700 bg-slate-800/40 p-6">
            <h4 class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">1. Sběr dat (Sensing)</h4>
            <p class="text-sm text-slate-400">
                Senzor zachytí analogový signál. U otisků může jít o <strong>kapacitní</strong>, <strong>optické</strong> nebo <strong>ultrazvukové</strong> čtení. Výsledkem je surový digitální obraz (Raw Data).
            </p>
        </div>
        <div class="rounded-2xl border border-slate-700 bg-slate-800/40 p-6">
            <h4 class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">2. Extrakce příznaků</h4>
            <p class="text-sm text-slate-400">
                Algoritmus nehledá shodu pixel po pixelu. Hledá tzv. <strong>minucie</strong> (konce a rozdvojení čar) nebo <strong>specifické rysy tváře</strong>. Tyto body převede na matematický vektor.
            </p>
        </div>
    </div>

    <h3 class="dark:text-slate-100 italic font-black tracking-tighter uppercase">0x02: Šablona vs. Obraz</h3>
    <p class="dark:text-slate-300 text-justify">
        Zásadní inženýrský princip: <strong>Systém nikdy neukládá vaši fotku nebo otisk.</strong> Ukládá pouze tzv. <strong>šablonu (template)</strong>, což je výsledek jednosměrné funkce. Biometrická šablona zůstává uložena v zabezpečeném úložišti zařízení a není přístupná externím aplikacím.
    </p>

    <div class="my-8 flex flex-col gap-4">
        <div class="group flex items-start rounded-2xl border border-slate-700/50 bg-slate-800/40 p-5 shadow-lg transition-all duration-300 hover:border-emerald-500/50">
            <div class="mr-4 mt-1 rounded-lg bg-emerald-500/20 p-2 text-emerald-400 transition-all group-hover:bg-emerald-500 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8-0v4h8z"></path></svg>
            </div>
            <div>
                <strong class="mb-1 block text-xs uppercase tracking-tighter text-slate-100">Jednosměrná transformace</strong>
                <p class="text-xs leading-relaxed dark:text-slate-400 text-justify">
                    Z matematické šablony nelze zpětně zrekonstruovat původní obraz tváře. I v případě totální kompromitace databáze útočník nezíská biometrická data uživatele, pouze jejich matematický otisk, který je pro něj bez originálního senzoru nepoužitelný.
                </p>
            </div>
        </div>

        <div class="group flex items-start rounded-2xl border border-slate-700/50 bg-slate-800/40 p-5 shadow-lg transition-all duration-300 hover:border-emerald-500/50 text-justify">
            <div class="mr-4 mt-1 rounded-lg bg-emerald-500/20 p-2 text-emerald-400 transition-all group-hover:bg-emerald-500 group-hover:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <strong class="mb-1 block text-xs uppercase tracking-tighter text-slate-100">Integrace s WebAuthn</strong>
                <p class="text-xs leading-relaxed dark:text-slate-400">
                    Při přihlašování na web biometrie slouží pouze k lokálnímu odemknutí soukromého klíče v zařízení. Server obdrží pouze kryptografický podpis potvrzující, že lokální autentizace proběhla úspěšně.
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
        <p class="text-sm dark:text-slate-400 leading-relaxed text-justify">
            V této simulaci prozkoumáme <strong>False Acceptance Rate (FAR)</strong> v praxi. Pokusíte se oklamat systém statickou fotografií a následně aktivujete <strong>Liveness Detection</strong>, abyste viděli, jak multispektrální analýza a 3D mapování tváře zneplatní útok, který standardní 2D kamera považovala za legitimní.
        </p>
    </div>
</div>
