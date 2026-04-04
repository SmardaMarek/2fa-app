<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Analýza a mitigace</span>
                </h2>
            </div>

            {{-- Standardizovaný indikátor postupu --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 3 / 4
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Stavová hláška --}}
            @if(session('status'))
                <div class="bg-emerald-500/10 border border-emerald-500/20 p-5 rounded-2xl flex items-center gap-4 animate-fade-in">
                    <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-emerald-800 dark:text-emerald-400 font-bold text-sm tracking-wide uppercase">{{ session('status') }}</span>
                </div>
            @endif

            {{-- SEKCЕ 1: ANALÝZA ZRANITELNOSTÍ --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-rose-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        Strukturální selhání SMS MFA
                    </h3>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-200 leading-relaxed font-medium mb-10">
                        <p>
                            Experiment demonstroval, že SMS OTP nesplňuje definici bezpečného vlastnictví autentizátoru. Metoda se spoléhá na důvěryhodnost směrovací infrastruktury třetích stran <strong>a na odolnost lidského faktoru</strong>, nad kterými uživatel ani služba nemají kryptografickou kontrolu.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bod 1 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technika 0x01</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Social Engineering (SIM Swap)</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Jak jste si vyzkoušeli v simulaci, útočník nemusí prolomit žádné šifrování. Stačí zmanipulovat operátora zákaznické linky pomocí ukradeného jména, adresy a rodného čísla. <strong>Lidský faktor je primární vektor útoku</strong> — technická pravidla operátora selžou pod emočním tlakem.
                            </p>
                        </div>

                        {{-- Bod 2 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technika 0x02</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Manipulace HLR a IMSI</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Po úspěšném Social Engineeringu operátor přepíše vazbu v <strong>HLR (Home Location Register)</strong> mezi směrovacím číslem (MSISDN) a hardwarovým identifikátorem <code>IMSI</code> nové SIM karty útočníka. Původní SIM oběti je okamžitě deautorizována.
                            </p>
                        </div>

                        {{-- Bod 3 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technika 0x03</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Zranitelnosti SS7</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                Globální doručování SMS závisí na protokolu <strong>SS7</strong> z 80. let. Ten spoléhá na implicitní důvěru a postrádá end-to-end šifrování i autentizaci zdroje. Útočník s přístupem do SS7 sítě může přesměrovat zprávy bez fyzického SIM Swapu.
                            </p>
                        </div>

                        {{-- Bod 4 --}}
                        <div class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-2xl border border-slate-200 dark:border-slate-700/50 shadow-inner group hover:border-rose-500/30 transition-colors">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-rose-500/10 text-rose-500 text-[10px] px-2 py-1 rounded font-black tracking-tighter uppercase">Technika 0x04</span>
                            </div>
                            <h4 class="text-slate-900 dark:text-white font-bold mb-3 text-sm">Absence Origin Binding</h4>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                                SMS kód nijak nekoreluje s TLS spojením ani doménou služby. Pokud uživatel zadá kód na phishingové stránce, útočník jej může okamžitě přeposlat legitimní službě. Server banky nedokáže poznat, odkud kód přišel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEKCE 2: PREVENCE A MITIGACE --}}
            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">
                <div class="bg-slate-900 px-8 py-5 border-l-4 border-emerald-500 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center font-mono uppercase tracking-wider">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Prevence a doporučení
                    </h3>
                </div>

                <div class="p-8 md:p-10">
                    <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-700 dark:text-slate-300 leading-relaxed font-medium mb-8">
                        <p>
                            Dokument <strong>NIST SP 800-63B</strong> klasifikuje SMS jako dostatečné maximálně pro úroveň <strong>AAL2</strong> a explicitně ho označuje jako <em>Restricted</em>. Pro zajištění odolnosti vůči phishingu (AAL3) je nutné přejít na kryptografické standardy.
                        </p>
                    </div>

                    {{-- Dvě sekce: Pro uživatele + Pro vývojáře --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                        {{-- Pro uživatele --}}
                        <div class="bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-6 shadow-inner">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="p-2 bg-emerald-500/20 rounded-lg text-emerald-500">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h4 class="font-black text-emerald-900 dark:text-emerald-300 uppercase tracking-tight text-sm">Ochrana pro uživatele</h4>
                            </div>

                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <span class="bg-emerald-500/20 text-emerald-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">1</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Nastavte si SIM PIN u operátora</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Kontaktujte svého operátora a požadujte nastavení autorizačního PINu (nikoliv PIN kód SIM karty) pro jakékoliv změny na účtu. Bez něj by operátor neměl provést SIM swap.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-emerald-500/20 text-emerald-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">2</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Zvažte přechod na eSIM</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">eSIM nelze fyzicky vyměnit na pobočce. Přenos vyžaduje přístup k zařízení, čímž se eliminuje nejběžnější vektor SIM swapu (návštěva pobočky se zfalšovanou plnou mocí).</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-emerald-500/20 text-emerald-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">3</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Nepoužívejte SMS jako jediný MFA faktor</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Pro kritické služby (banka, email) přejděte na autentizační aplikaci (Google/Microsoft Authenticator) nebo ideálně na Passkeys/FIDO2. SMS ponechte jen tam, kde není jiná možnost.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-emerald-500/20 text-emerald-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">4</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Aktivujte notifikace o změnách SIM</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Většina operátorů umožňuje zasílání upozornění (email, push) při jakékoliv změně na účtu. Ztráta signálu + příchozí oznámení = okamžitý varovný signál.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        {{-- Pro vývojáře / Relying Party --}}
                        <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-2xl p-6 shadow-inner">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="p-2 bg-indigo-500/20 rounded-lg text-indigo-500">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                </div>
                                <h4 class="font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-tight text-sm">Mitigace pro vývojáře</h4>
                            </div>

                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <span class="bg-indigo-500/20 text-indigo-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">1</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Zkrátit platnost SMS kódu</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Používejte TTL kratší než 60 sekund. Čím kratší okno, tím menší šance, že útočník stihne kód zachytit a spotřebovat.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-indigo-500/20 text-indigo-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">2</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Implementovat detekci SIM swapu</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Využijte Number Verify API operátorů k ověření, zda nedošlo k nedávné změně IMSI pro dané číslo. Při detekci pozastavte citlivé operace.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-indigo-500/20 text-indigo-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">3</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Nabídnout silnější alternativy</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Prioritizujte v UI push notifikace přes vlastní aplikaci, TOTP a především Passkeys. SMS ponechte jako fallback, nikoliv jako výchozí metodu.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="bg-indigo-500/20 text-indigo-500 text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded shrink-0 mt-0.5">4</span>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 dark:text-slate-200">Rate limiting a lockout</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Omezit počet SMS odeslání i pokusů o verifikaci. Po N neúspěšných pokusech zablokovat účet a vyžadovat ruční zásah.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Passkey / FIDO2 Box --}}
                    <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border border-indigo-500/20 rounded-3xl p-8 relative overflow-hidden shadow-inner">
                        <div class="absolute -top-10 -right-10 opacity-5 pointer-events-none">
                            <svg class="w-64 h-64 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"></path></svg>
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-500/20 rounded-lg text-indigo-500 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                </div>
                                <h4 class="text-lg font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-tight">Nejsilnější alternativa: FIDO2 / Passkeys</h4>
                            </div>

                            <p class="text-sm text-indigo-800 dark:text-slate-300 mb-6 leading-relaxed max-w-3xl">
                                Architektura FIDO2 je založená na asymetrické kryptografii. Při registraci generuje autentizátor pár klíčů <strong>kryptograficky svázaný s doménou (Relying Party ID)</strong>. Neexistuje žádné telefonní číslo, které by šlo přesměrovat — SIM swap je tak zcela irelevantní.
                            </p>

                            {{-- IDE Snippet Style --}}
                            <div class="bg-slate-950/90 rounded-2xl p-6 font-mono text-[11px] text-emerald-400 border border-slate-800 shadow-2xl my-6">
                                <div class="flex justify-between items-center mb-4 border-b border-slate-800 pb-2">
                                    <span class="text-slate-500 uppercase tracking-widest text-[9px] font-black">// Browser API: Origin Binding</span>
                                    <span class="text-rose-500 text-[9px] font-bold">FIDO2_PROTECTED</span>
                                </div>
                                <div class="space-y-1">
                                    <p><span class="text-indigo-400">const</span> requestOptions = {</p>
                                    <p>&nbsp;&nbsp;challenge: <span class="text-amber-300">serverGeneratedChallenge</span>,</p>
                                    <p>&nbsp;&nbsp;rpId: <span class="text-amber-300">"securebank.cz"</span> <span class="text-slate-600">// <- Vázáno na doménu</span></p>
                                    <p>};</p>
                                    <p><span class="text-indigo-400">navigator</span>.credentials.get({ publicKey: requestOptions });</p>
                                </div>
                            </div>

                            <p class="text-xs text-indigo-700 dark:text-indigo-400/80 italic font-medium">
                                Útok AitM je zde matematicky nemožný – falešná doména vygeneruje odlišný hash a prohlížeč odmítne komunikovat s klíčem.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Co udělat teď --}}
                <div class="mx-8 md:mx-10 mb-8">
                    <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-2xl p-6 shadow-inner">
                        <h4 class="text-emerald-500 font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Co udělat teď — 3 kroky ke zvýšení bezpečnosti
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">1</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Zavolejte operátorovi</strong> a požadujte nastavení autorizačního PINu pro veškeré změny na vašem účtu.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">2</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Nainstalujte si Authenticator</strong> (Google/Microsoft) a přepněte banku a email z SMS na aplikaci.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="bg-emerald-500/20 text-emerald-400 font-mono text-xs font-bold w-7 h-7 flex items-center justify-center rounded-lg shrink-0 border border-emerald-500/30">3</span>
                                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-emerald-600 dark:text-emerald-400">Aktivujte Passkeys</strong> na Google/Apple/Microsoft účtu. Je to zdarma a eliminuje to phishing i SIM swap.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Patička s odesláním --}}
                <div class="bg-gray-50/80 dark:bg-slate-800/60 px-8 py-8 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-6 mt-auto">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                        Analýza dokončena. Jste připraveni na test?
                    </p>

                    <form action="{{ route('module.sms.complete', ['module' => $module->slug]) }}" method="POST" class="w-full md:w-auto">
                        @csrf
                        <button type="submit" class="w-full md:w-auto relative inline-flex items-center justify-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-indigo-500/20 active:scale-95 group/btn">
                            <span class="relative z-10 flex items-center gap-2">
                                Vstoupit do závěrečného testu
                                <svg class="w-5 h-5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
