<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Simulace přihlášení</span>
                </h2>
            </div>

            {{-- Indikátor postupu krokem --}}
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

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300" x-data="smsSimulation()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

                <div class="space-y-8">
                    {{-- Karta simulace --}}
                    <div class="relative bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                        {{-- Neonová linka progresu (75%) --}}
                        <div class="absolute top-0 left-0 h-1 w-3/4 bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>

                        <div class="p-8 md:p-10">
                            <h3 class="text-xl font-black text-gray-800 dark:text-slate-100 uppercase tracking-tight mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Simulace přihlášení
                            </h3>

                            <div class="prose dark:prose-invert prose-indigo max-w-none text-gray-600 dark:text-slate-300 leading-relaxed font-medium mb-8">
                                <p>
                                    SMS OTP nevyužívá standardní kryptografii na straně klienta[cite: 3]. Server vygeneruje náhodný kód a odešle jej přes telekomunikační síť na vaše zařízení[cite: 5, 623].
                                </p>

                                {{-- Didaktická poznámka ve stylu standardu --}}
                                <div class="bg-indigo-500/5 dark:bg-indigo-500/10 border-l-4 border-indigo-500 p-5 my-6 rounded-r-xl">
                                    <p class="text-indigo-700 dark:text-indigo-300 m-0 text-sm">
                                        <strong>Didaktická poznámka:</strong> V této fázi uvidíte kód přímo na simulovaném telefonu. Všimněte si časové prodlevy doručení, která simuluje reálný přenos přes síť operátora.
                                    </p>
                                </div>
                            </div>

                            {{-- Ovládací prvky simulace --}}
                            <div x-show="!smsSent" class="space-y-4">
                                <button
                                    @click="sendSms"
                                    :disabled="isLoading"
                                    class="group relative w-full inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-bold text-white transition-all duration-300 shadow-xl shadow-indigo-500/20 disabled:opacity-50 overflow-hidden"
                                >
                                    <span x-show="!isLoading" class="relative z-10 flex items-center gap-2 uppercase tracking-widest text-sm">
                                        Zaslat ověřovací kód
                                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    </span>
                                    <span x-show="isLoading" class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Generování kódu...
                                    </span>
                                </button>
                            </div>

                            {{-- Formulář pro ověření --}}
                            <div x-show="smsSent" x-cloak class="space-y-6 animate-fade-in">
                                <form action="{{ route('module.sms.verify', ['module' => $module->slug]) }}" method="POST">
                                    @csrf
                                    <div class="group">
                                        <label class="block text-xs font-black text-gray-500 dark:text-slate-400 uppercase tracking-[0.2em] mb-4">
                                            Vložte 6místný kód ze zprávy
                                        </label>
                                        <input
                                            type="text"
                                            name="code"
                                            maxlength="6"
                                            required
                                            class="block w-full text-center text-4xl font-black tracking-[0.5em] bg-transparent border-b-2 border-gray-200 dark:border-slate-700 text-indigo-600 dark:text-indigo-400 focus:border-indigo-500 focus:ring-0 transition-all duration-300 placeholder-gray-200 dark:placeholder-slate-800"
                                            placeholder="000000"
                                            autocomplete="off"
                                        >
                                        @error('code')
                                        <p class="text-rose-500 text-xs mt-3 font-bold uppercase tracking-wide">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button
                                        type="submit"
                                        class="w-full mt-8 inline-flex justify-center items-center px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white rounded-2xl font-bold uppercase tracking-widest text-sm transition-all duration-300 shadow-lg shadow-emerald-500/20"
                                    >
                                        Ověřit totožnost
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Technický panel --}}
                    <div class="bg-slate-900/80 backdrop-blur-md p-8 rounded-3xl border border-slate-800 shadow-2xl transition-all duration-300 hover:border-slate-700">
                        <h4 class="text-white font-black text-xs uppercase tracking-[0.2em] mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Technické pozadí doručení
                        </h4>
                        <p class="text-slate-300 text-xs leading-relaxed font-medium">
                            SMS kód je doručován přes protokol **Signalling System No. 7 (SS7)**[cite: 6]. Tento protokol obsahuje fundamentální zranitelnosti umožňující odposlech či přesměrování zpráv útočníkem, jelikož SMS nejsou standardně end-to-end šifrovány[cite: 7, 13, 108].
                        </p>
                    </div>
                </div>

                {{-- Simulované zařízení --}}
                <div class="sticky top-12">
                    <div class="text-center mb-6">
                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.3em]">
                            Simulované zařízení uživatele
                        </span>
                    </div>
                    {{-- Komponenta telefonu - předpokládáme integraci s Alpine proměnnou receivedCode --}}
                    <x-phone code="receivedCode" />
                </div>

            </div>
        </div>
    </div>

    <script>
        function smsSimulation() {
            return {
                isLoading: false,
                smsSent: false,
                receivedCode: null,

                async sendSms() {
                    this.isLoading = true;

                    try {
                        let response = await fetch('{{ route('module.sms.send', ['module' => $module->slug]) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        let data = await response.json();
                        this.smsSent = true;

                        // Simulace zpoždění sítě (2s) dle didaktického záměru
                        setTimeout(() => {
                            this.receivedCode = data.simulated_code;
                        }, 2000);

                    } catch (error) {
                        console.error('Chyba simulace:', error);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }
    </script>
</x-app-layout>
