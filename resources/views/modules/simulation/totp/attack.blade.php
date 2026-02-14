<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $module->title }} - Experiment: Phishing
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Cíl experimentu: Phishing (AitM) a Replay útoky</h3>
                            <div class="mt-2 text-sm text-blue-700 space-y-3">
                                <p>
                                    V tomto scénáři testujeme dvě fundamentální slabiny TOTP protokolu. Zaprvé ověříme <strong>absenci vazby na původ (Origin Binding)</strong>. Zkuste zadat validní kód na simulované podvržené doméně. Kód totiž není vázán na konkrétní web, ale pouze na časové okno.
                                </p>
                                <p>
                                    Zadruhé demonstrujeme hrozbu <strong>útoku přehráním (Replay Attack)</strong>. Pokud útočník získá váš kód z podvodné stránky , pokusí se jej okamžitě použít na legitimním serveru. Vaším cílem je zjistit, zda náš systém takový útok v reálném čase propustí.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-red-200 relative">
                    <div class="bg-gray-100 border-b border-gray-200 px-4 py-2 flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                        <div class="flex-1 bg-white rounded px-2 py-1 text-xs text-gray-500 font-mono text-center border border-red-300">
                            🔒 https://g00gle-login-secure.com
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-center text-lg font-bold text-gray-700 mb-4">Přihlášení k účtu</h3>

                        <form action="{{ route('module.simulation.verify_attack', $module) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Váš TOTP kód</label>
                                <input type="text" name="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center text-xl tracking-widest" placeholder="000 000">
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Odeslat na falešný server
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-green-400 font-mono text-sm h-full flex flex-col">
                    <div class="mb-4 border-b border-gray-700 pb-2 font-bold text-white flex justify-between items-center">
                        <span>> SYSTEM ANALYZER</span>
                        <span class="text-red-500 text-xs animate-pulse border border-red-500 px-1 rounded">VULNERABILITY SCAN ACTIVE</span>
                    </div>
                    <p class="mb-2">> Waiting for input...</p>
                    <p class="mb-6 opacity-50">> Monitoring traffic on port 443...</p>

                    <div class="space-y-6 text-gray-300 mt-auto">
                        <div class="bg-gray-800 p-3 rounded border-l-2 border-yellow-500">
                            <p class="text-white font-bold mb-1">[?] Zamyšlení 1: Chybějící kontext (Origin Binding)</p>
                            <p class="text-xs leading-relaxed">
                                Ví vaše autentizační aplikace v mobilu, na jakou webovou stránku se právě díváte?
                                Zabrání vám opsat kód, když jste na <code class="text-red-400 bg-gray-900 px-1">g00gle.com</code> místo <code class="text-green-400 bg-gray-900 px-1">google.com</code>?
                                Odpověď zní ne. Aplikace generuje kódy offline a nezajímá ji, kam je zadáváte.
                            </p>
                        </div>

                        <div class="bg-gray-800 p-3 rounded border-l-2 border-red-500">
                            <p class="text-white font-bold mb-1">[?] Zamyšlení 2: Časové okno (Replay Attack)</p>
                            <p class="text-xs leading-relaxed">
                                TOTP kód se standardně mění každých 30 sekund. Co se stane, když kód zadáte do podvodné stránky hned v 5. sekundě jeho platnosti?
                                Útočníkovi zbývá celých 25 sekund na to, aby ho odeslal na legitimní server. Pokud backend <strong>neukládá již použité kódy do mezipaměti (např. Redis)</strong>, aby je do konce jejich platnosti zneplatnil, přijme ten samý kód dvakrát.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
