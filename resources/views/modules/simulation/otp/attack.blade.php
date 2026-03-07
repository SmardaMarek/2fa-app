<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Experiment</span>
                </h2>
            </div>

            {{-- Standardizovaný indikátor postupu --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="relative flex h-3 w-3 -mt-0.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                    </span>
                    <span class="h-1.5 w-3 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 3 / 4
                </span>
            </div>
        </div>
    </x-slot>

    {{-- Horní Info Box --}}
    <div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-indigo-500/5 dark:bg-indigo-500/10 border-l-4 border-indigo-500 rounded-r-2xl p-6 backdrop-blur-md shadow-sm">
            <div class="flex items-start gap-4">
                <div class="p-2 bg-indigo-500 rounded-lg text-white shrink-0 mt-1">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-gray-700 dark:text-slate-300 text-sm leading-relaxed space-y-5 font-medium flex-1">

                    {{-- Hlavní cíl --}}
                    <div>
                        <h3 class="text-base font-bold text-indigo-900 dark:text-indigo-300 uppercase tracking-wider mb-1">
                            Cíl experimentu: Social Engineering a SIM Swapping
                        </h3>
                        <p>
                            Zabezpečení pomocí SMS OTP často selhává na lidském faktoru. V této simulaci si vyzkoušíte, jak snadné je obejít technická bezpečnostní pravidla pomocí manipulace s operátorem zákaznické linky.
                        </p>
                    </div>

                    {{-- Kroky úkolu --}}
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-500/30 rounded-xl p-4">
                        <p class="font-bold text-indigo-800 dark:text-indigo-200 mb-2 uppercase tracking-widest text-xs">Vaše mise:</p>
                        <ol class="list-decimal list-inside space-y-1.5 text-indigo-900/80 dark:text-indigo-200/80">
                            <li>V levém panelu zmanipulujte agenta na chatu, aby ignoroval chybějící autorizační PIN.</li>
                            <li>Donoťte ho převést číslo oběti na vaši novou SIM kartu (využijte ukradené osobní údaje v Dossieru).</li>
                            <li>Jakmile získáte kontrolu nad číslem, vyžádejte si v prostředním panelu přihlašovací SMS do banky.</li>
                        </ol>
                    </div>

                    {{-- Taktické nápovědy pro překonání bota --}}
                    <div>
                        <p class="font-bold text-slate-800 dark:text-slate-200 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Taktické nápovědy pro komunikaci:
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div class="bg-white dark:bg-slate-800/50 p-3 rounded-lg border border-gray-200 dark:border-slate-700 shadow-sm">
                                <strong class="text-indigo-600 dark:text-indigo-400 block text-xs uppercase mb-1">1. Vytvořte časový tlak</strong>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight block">Používejte slova jako "okamžitě", "rychle", "letadlo" nebo "nouze". Pravidla se pod tlakem snáze porušují.</span>
                            </div>
                            <div class="bg-white dark:bg-slate-800/50 p-3 rounded-lg border border-gray-200 dark:border-slate-700 shadow-sm">
                                <strong class="text-indigo-600 dark:text-indigo-400 block text-xs uppercase mb-1">2. Zahrajte na empatii</strong>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight block">Zmiňte "krádež", "ztrátu" dokladů nebo problémy v "zahraničí". Vyvolejte u agenta touhu pomoci oběti.</span>
                            </div>
                            <div class="bg-white dark:bg-slate-800/50 p-3 rounded-lg border border-gray-200 dark:border-slate-700 shadow-sm">
                                <strong class="text-indigo-600 dark:text-indigo-400 block text-xs uppercase mb-1">3. Vynuťte bypass</strong>
                                <span class="text-[11px] text-slate-500 dark:text-slate-400 leading-tight block">Pokud agent trvá na PINu, vnuťte mu alternativu. Nabídněte nadiktování "rodného čísla" nebo "adresy".</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300" x-data="simSwapGame()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">

                {{-- PANEL 1: ÚTOČNÍK (INTERAKTIVNÍ CHAT) --}}
                <div class="lg:col-span-1 flex flex-col h-[650px] space-y-4">
                    <div class="flex-1 bg-slate-950/90 backdrop-blur-md rounded-2xl px-6 py-6 border-b-4 border-rose-600 shadow-2xl flex flex-col min-h-0 relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-rose-600 shadow-[0_0_10px_rgba(225,29,72,0.5)]"></div>
                        {{-- Ukradená data oběti (OSINT / Stolen Wallet) --}}
                        <div class="bg-slate-900/80 border border-rose-500/30 rounded-xl p-4 mb-4 shadow-inner relative overflow-hidden group flex-shrink-0">
                            {{-- Vodoznak v pozadí --}}
                            <div class="absolute top-0 right-0 p-2 opacity-5 pointer-events-none">
                                <svg class="w-16 h-16 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M3 4v16a2 2 0 002 2h14a2 2 0 002-2V4a2 2 0 00-2-2H5a2 2 0 00-2 2zm7 4a3 3 0 11-6 0 3 3 0 016 0zm-1.84 4.34A5.002 5.002 0 003 16v1h10v-1a5.002 5.002 0 00-4.84-3.66H8.16zM15 12h6v2h-6v-2zm0-4h6v2h-6V8zm0 8h6v2h-6v-2z"></path></svg>
                            </div>

                            <h4 class="text-rose-500 font-mono text-[10px] font-black uppercase tracking-[0.2em] mb-3 flex items-center border-b border-slate-800 pb-2">
                                <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                Dossier: Ukradená data oběti
                            </h4>

                            <div class="grid grid-cols-[100px_1fr] gap-y-2 text-[10px] font-mono relative z-10">
                                <div class="text-slate-500 uppercase tracking-widest">Jméno:</div>
                                <div class="text-slate-200 font-bold selection:bg-rose-500 selection:text-white">Jan Novák</div>

                                <div class="text-slate-500 uppercase tracking-widest">Rodné číslo:</div>
                                <div class="text-emerald-400 font-bold selection:bg-rose-500 selection:text-white">850515/1234</div>

                                <div class="text-slate-500 uppercase tracking-widest">Trvalý pobyt:</div>
                                <div class="text-slate-200 selection:bg-rose-500 selection:text-white">Smetanova 123, 602 00 Brno</div>

                                {{-- ICCID útočníka (To co diktuje operátorovi) --}}
                                <div class="text-slate-500 uppercase tracking-widest mt-2 pt-2 border-t border-slate-800/50">Vaše ICCID:</div>
                                <div class="text-rose-400 font-bold mt-2 pt-2 border-t border-slate-800/50 selection:bg-rose-500 selection:text-white">8942031122334455667</div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-4 flex-shrink-0">
                            <h3 class="text-rose-500 font-mono font-bold text-[10px] tracking-[0.2em] uppercase flex items-center gap-2">
                                <span>// SOCIAL_ENGINEERING</span>
                                <span class="animate-pulse text-rose-400">● LIVE</span>
                            </h3>

                            {{-- Trust Meter --}}
                            <div class="flex items-center gap-2 bg-slate-900 border border-slate-700 px-2 py-1 rounded" x-show="step === 'chat' && chatStarted">
                                <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Důvěra</span>
                                <div class="w-16 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full transition-all duration-500" :class="trustLevel > 75 ? 'bg-emerald-500' : (trustLevel > 40 ? 'bg-amber-500' : 'bg-rose-500')" :style="`width: ${trustLevel}%`"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col min-h-0" x-show="step === 'chat'">
                            {{-- Chat zóna --}}
                            <div id="chat-box" class="bg-slate-900/50 p-4 rounded-t-xl text-[11px] font-mono overflow-y-auto flex-1 border-x border-t border-slate-800 shadow-inner space-y-4 scrollbar-hide">
                                <p class="mb-4 text-slate-500 italic text-center border-b border-slate-700 pb-2 flex-shrink-0 font-bold text-[9px]">-- ZABEZPEČENÝ CHAT OPERÁTORA --</p>

                                <div x-show="!chatStarted" class="h-full flex flex-col items-center justify-center space-y-4">
                                    <p class="text-[10px] text-slate-400 text-center px-4">Použijte manipulaci, empatii a pocit urgence k oklamání agenta.</p>
                                    <button @click="startChat" class="bg-rose-600 hover:bg-rose-500 text-white px-6 py-3 rounded-xl font-black uppercase transition-all shadow-xl shadow-rose-600/20 text-[10px]">
                                        Zahájit útok
                                    </button>
                                </div>

                                <div x-show="chatStarted" class="space-y-4 pb-2">
                                    <template x-for="(msg, index) in messages" :key="index">
                                        <div class="animate-fade-in space-y-1">
                                            <span :class="msg.role === 'agent' ? 'text-blue-500' : 'text-rose-500'" class="font-black text-[9px] uppercase tracking-widest" x-text="msg.role === 'agent' ? 'Agent' : 'Vy'"></span>
                                            <p :class="msg.role === 'agent' ? 'text-slate-300' : 'text-slate-100'" class="leading-relaxed bg-slate-800/40 p-2.5 rounded-lg border border-slate-800" x-text="msg.text"></p>
                                        </div>
                                    </template>
                                    <div x-show="isTyping" class="text-slate-500 italic text-[10px] animate-pulse flex items-center gap-2 mt-2">
                                        Agent píše...
                                    </div>
                                </div>
                            </div>

                            {{-- Input zóna --}}
                            <div x-show="chatStarted && !chatFinished" class="bg-slate-900 border-x border-b border-slate-800 rounded-b-xl p-2 flex gap-2">
                                <input type="text" x-model="userInput" @keydown.enter="sendMessage" placeholder="Napište agentovi výmluvu..." class="flex-1 bg-slate-950 border border-slate-700 text-white text-[11px] rounded-lg focus:border-rose-500 focus:ring-0 placeholder-slate-600 px-3">
                                <button @click="sendMessage" :disabled="userInput.trim() === '' || isTyping" class="bg-rose-600 hover:bg-rose-500 disabled:bg-slate-800 disabled:text-slate-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase transition-colors">
                                    Odeslat
                                </button>
                            </div>

                            <div x-show="chatFinished" x-transition.opacity class="mt-4 flex-shrink-0">
                                <button @click="executeSwap" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-[0.2em] transition-all shadow-xl shadow-emerald-500/20">
                                    [ Provést SIM Swap ]
                                </button>
                            </div>
                        </div>

                        <div x-show="step === 'intercept'" x-cloak class="flex-1 flex flex-col items-center justify-center animate-fade-in space-y-6">
                            <div class="bg-emerald-500/10 border border-emerald-500/30 p-8 rounded-3xl text-center shadow-[0_0_20px_rgba(16,185,129,0.1)] w-full">
                                <svg class="w-10 h-10 text-emerald-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="text-emerald-500 font-mono text-xs font-black block tracking-widest uppercase">Útok úspěšný</span>
                                <span class="text-slate-400 font-mono text-[10px] block mt-2">Target: +420 ••• ••• 789</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-950/90 rounded-2xl p-5 border border-slate-800 shadow-xl h-[160px] flex-shrink-0" x-show="step === 'intercept'" x-cloak>
                        <h4 class="text-slate-600 font-mono text-[9px] font-black uppercase tracking-[0.2em] mb-3">INCOMING_LOG</h4>
                        <div class="font-mono text-[11px] space-y-2">
                            <p class="text-slate-500 animate-pulse" x-show="!attackerCode">> Searching for packets...</p>
                            <template x-if="attackerCode">
                                <div class="p-3 bg-emerald-500/5 border border-emerald-500/20 rounded-xl animate-bounce">
                                    <span class="text-emerald-500 text-[10px] font-bold block">Zachycená SMS:</span>
                                    <span class="text-white font-black text-2xl tracking-widest" x-text="attackerCode"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- PANEL 2: BANKA (Beze změny) --}}
                <div class="lg:col-span-1 h-[650px]">
                    <div class="bg-white dark:bg-slate-800/60 dark:backdrop-blur-md rounded-3xl shadow-2xl border border-gray-200 dark:border-slate-700/50 overflow-hidden h-full flex flex-col relative">
                        <div class="absolute top-0 left-0 w-full h-1 bg-blue-600"></div>

                        <div class="bg-slate-50 dark:bg-slate-900/50 px-6 py-3 border-b border-slate-200 dark:border-slate-700/50 flex items-center gap-2 flex-shrink-0">
                            <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-[10px] font-bold text-slate-500">ib.securebank.cz</span>
                        </div>

                        <div class="p-8 flex-1 flex flex-col overflow-y-auto">
                            <div class="text-center mb-6">
                                <div class="inline-flex items-center gap-2 text-blue-700 dark:text-blue-400 mb-4 font-black">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-xl">SecureBank</span>
                                </div>
                                <div class="w-14 h-14 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-3 border-2 border-white dark:border-slate-600 shadow-md">
                                    <span class="font-bold text-slate-700 dark:text-slate-100">JN</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800 dark:text-slate-100">Jan Novák</h3>
                            </div>

                            <div class="flex-1 flex flex-col justify-center space-y-6">
                                <div x-show="!smsSent" class="space-y-6 animate-fade-in text-center">
                                    <p class="text-xs text-slate-500 dark:text-slate-300 font-medium">Pro přihlášení zašleme SMS na:</p>
                                    <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                        <span class="font-mono text-lg text-slate-800 dark:text-slate-200 font-black tracking-widest">+420 ••• ••• 789</span>
                                    </div>
                                    <button @click="requestSms" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-lg active:scale-95">
                                        Odeslat SMS kód
                                    </button>
                                </div>

                                <div x-show="smsSent" x-cloak class="space-y-6 animate-fade-in">
                                    <div class="bg-indigo-500/5 border border-indigo-500/20 p-4 rounded-2xl">
                                        <p class="text-[10px] text-indigo-700 dark:text-indigo-300 leading-relaxed text-center font-medium">SMS kód byl odeslán. Platnost 5 minut.</p>
                                    </div>

                                    <form action="{{ route('module.sms.verify_attack', ['module' => $module->slug]) }}" method="POST" class="space-y-6">
                                        @csrf
                                        <div class="text-center">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Zadejte 6místný kód</label>
                                            <input type="text" name="code" maxlength="6" class="w-full text-center text-3xl font-black tracking-[0.4em] bg-transparent border-b-2 border-slate-200 dark:border-slate-700 text-blue-600 dark:text-blue-400 focus:border-blue-500 focus:ring-0 placeholder-slate-200 dark:placeholder-slate-800" placeholder="000000" required>
                                        </div>
                                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest transition-all shadow-lg">
                                            Potvrdit a přihlásit
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PANEL 3: TELEFON (Beze změny) --}}
                <div class="lg:col-span-1 flex flex-col h-[650px]">
                    <div class="sticky top-0 flex flex-col items-center">
                        <div class="mb-6 flex flex-col items-center gap-2">
                            <span class="text-[9px] font-black uppercase tracking-widest" :class="simSwapped ? 'text-rose-500 animate-pulse' : 'text-emerald-500'" x-text="simSwapped ? 'Žádný signál' : 'SÍŤ: 4G LTE'"></span>
                            <div class="flex items-end gap-0.5 h-3">
                                <template x-for="i in 4">
                                    <div class="w-1 rounded-full" :class="[i === 1 ? 'h-1' : (i === 2 ? 'h-1.5' : (i === 3 ? 'h-2' : 'h-3')), i <= (simSwapped ? 0 : 3) ? (simSwapped ? 'bg-rose-500' : 'bg-emerald-500') : 'bg-slate-300 dark:bg-slate-700']"></div>
                                </template>
                            </div>
                        </div>

                        <div class="relative scale-90 origin-top">
                            <x-phone code="victimCode" simSwapped="simSwapped" />
                        </div>

                        <div x-show="simSwapped" x-cloak x-transition.delay-500ms class="mt-8 bg-rose-500/5 dark:bg-rose-500/10 border border-rose-500/20 rounded-2xl p-6 backdrop-blur-md shadow-2xl relative max-w-sm">
                            <h4 class="text-rose-500 font-bold text-sm mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Incident report
                            </h4>
                            <p class="text-[11px] text-slate-600 dark:text-slate-300 leading-relaxed font-medium">Číslo bylo odpojeno a přesměrováno na SIM kartu útočníka. Zprávy na tento telefon nedorazí.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function simSwapGame() {
            return {
                step: 'chat', simSwapped: false, smsSent: false, attackerCode: null, victimCode: null,
                chatStarted: false, isTyping: false, chatFinished: false, trustLevel: 0,
                userInput: '',
                messages: [],

                // Klíčová slova, na která bot reaguje
                urgencyKeywords: ['rychle', 'krádež', 'ukrad', 'ztrát', 'ztrat', 'nouze', 'letad', 'zahranič', 'prosím', 'okamžitě', 'peněženk', 'doklad'],
                infoKeywords: ['rodné číslo', 'rč', 'adresa', 'iccid', 'novou sim', 'číslo sim'],

                startChat() {
                    this.chatStarted = true;
                    this.addAgentMessage('Dobrý den, zde podpora operátora. Jak vám mohu pomoci? Prosím, pro jakoukoliv změnu si připravte svůj 4místný PIN.', 800);
                },

                sendMessage() {
                    if(this.userInput.trim() === '') return;

                    const text = this.userInput;
                    this.messages.push({ role: 'user', text: text });
                    this.userInput = '';
                    this.scrollChat();

                    this.processBotLogic(text.toLowerCase());
                },

                addAgentMessage(text, delay) {
                    this.isTyping = true;
                    setTimeout(() => {
                        this.isTyping = false;
                        this.messages.push({ role: 'agent', text: text });
                        this.scrollChat();
                    }, delay);
                },

                processBotLogic(input) {
                    let trustGained = 0;

                    // Jednoduchá analýza textu
                    this.urgencyKeywords.forEach(kw => { if(input.includes(kw)) trustGained += 15; });
                    this.infoKeywords.forEach(kw => { if(input.includes(kw)) trustGained += 20; });

                    if (trustGained > 0) {
                        this.trustLevel = Math.min(100, this.trustLevel + trustGained);
                    }

                    // Reakce bota podle úrovně důvěry
                    if (this.trustLevel >= 100) {
                        this.addAgentMessage('Ověřil jsem si vaše údaje. Výjimečně jsem schválil přenos čísla bez PINu vzhledem k vaší krizové situaci. Proces převodu byl zahájen.', 2000);
                        setTimeout(() => { this.chatFinished = true; }, 3500);
                    } else if (this.trustLevel >= 70) {
                        this.addAgentMessage('Rozumím vážnosti situace. Pokud nemáte PIN, nadiktujte mi alespoň své rodné číslo a adresu pro manuální identifikaci.', 1500);
                    } else if (this.trustLevel >= 40) {
                        this.addAgentMessage('Chápu, ale bezpečnostní pravidla jsou striktní. Jste si jistý, že si na PIN nevzpomenete? Případně potřebuji znát detailní důvod, proč to musíme řešit hned.', 1500);
                    } else {
                        this.addAgentMessage('Omlouvám se, ale bez vašeho PIN kódu nemohu provádět změny na účtu. Taková jsou pravidla.', 1500);
                    }
                },

                scrollChat() {
                    this.$nextTick(() => {
                        const chatBox = document.getElementById('chat-box');
                        if(chatBox) chatBox.scrollTop = chatBox.scrollHeight;
                    });
                },

                executeSwap() {
                    this.simSwapped = true;
                    this.step = 'intercept';
                    this.victimCode = null;
                },

                async requestSms() {
                    this.smsSent = true;
                    try {
                        let response = await fetch('{{ route('module.sms.send', ['module' => $module->slug]) }}', {
                            method: 'POST', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
                        });
                        let data = await response.json();
                        setTimeout(() => {
                            if (this.simSwapped) {
                                this.attackerCode = data.simulated_code;
                            } else {
                                this.victimCode = data.simulated_code;
                            }
                        }, 1500);
                    } catch (e) { console.error(e); }
                }
            }
        }
    </script>
</x-app-layout>
