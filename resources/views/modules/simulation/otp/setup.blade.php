<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-400 leading-tight">
                {{ $module->title }} - Scénář A: Úspěšné ověření
            </h2>
            <div class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                Krok 3 / 4
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="smsSimulation()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <div class="space-y-6">
                    <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-slate-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 font-mono uppercase tracking-tight">
                            Simulace přihlášení
                        </h3>

                        <div class="prose prose-slate text-sm mb-6">
                            <p>
                                SMS OTP (One-Time Password) je metoda založená na tom, co uživatel <strong>vlastní</strong>.
                                Server vygeneruje náhodný kód a odešle jej na registrované číslo.
                            </p>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 my-4">
                                <p class="text-blue-700 m-0 italic">
                                    <strong>Didaktická poznámka:</strong> V této fázi uvidíte kód přímo na simulovaném telefonu.
                                    Všimněte si časové prodlevy doručení, která je způsobena směrováním v telekomunikační síti.
                                </p>
                            </div>
                        </div>

                        <div x-show="!smsSent" class="space-y-4">
                            <button
                                @click="sendSms"
                                :disabled="isLoading"
                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition disabled:opacity-50"
                            >
                                <span x-show="!isLoading">Zaslat ověřovací kód</span>
                                <span x-show="isLoading" class="flex items-center">
                                    <svg class="animate-spin h-4 w-4 mr-2 text-white" viewBox="0 0 24 24"></svg>
                                    Generování kódu na serveru...
                                </span>
                            </button>
                        </div>

                        <div x-show="smsSent" x-cloak class="space-y-4 animate-fade-in">
                            <form action="{{ route('module.sms.verify', ['module' => $module->slug]) }}" method="POST">
                                @csrf
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Zadejte 6místný kód z vaší SMS zprávy
                                    </label>
                                    <input
                                        type="text"
                                        name="code"
                                        maxlength="6"
                                        required
                                        class="block w-full text-center text-3xl tracking-[0.5em] font-mono border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="000000"
                                    >
                                    @error('code')
                                    <p class="text-red-500 text-xs mt-2 font-semibold">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="w-full mt-4 inline-flex justify-center items-center px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition"
                                >
                                    Ověřit totožnost
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="bg-slate-800 p-6 rounded-xl shadow-inner text-slate-300">
                        <h4 class="text-white font-bold mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Technické pozadí doručení
                        </h4>
                        <p class="text-xs leading-relaxed">
                            SMS kód cestuje přes protokol <strong>Signalling System No. 7 (SS7)</strong>.
                            Tento protokol je zastaralý a neobsahuje standardní šifrování, což umožňuje útočníkům s přístupem k síti kód odposlechnout.
                        </p>
                    </div>
                </div>

                <div class="sticky top-6">
                    <div class="text-center mb-4">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Simulované zařízení uživatele</span>
                    </div>
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

                        // Simulace zpoždění doručení přes síť operátora (2 sekundy)
                        // Student tak vnímá prodlevu doručení
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
