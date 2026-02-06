<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $module->title }} - Praktické nastavení
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-6 text-center">

                <h3 class="text-lg font-bold mb-4">1. Naskenujte QR kód</h3>
                <p class="text-gray-600 mb-6">Otevřete Google Authenticator na svém mobilu a naskenujte tento kód.</p>

                <div class="inline-block p-4 border-2 border-gray-200 rounded-lg mb-6">
                    <img src=" {!! $qrCodeSvg !!}"
                         alt="QR Kód pro MFA"
                         class="w-48 h-48 mx-auto"
                    />
                </div>

                <div class="bg-gray-100 p-2 rounded text-sm font-mono text-gray-600 mb-8">
                    Secret Key: {{ $secret }}
                </div>

                <h3 class="text-lg font-bold mb-4">2. Ověřte nastavení</h3>
                <form action="{{ route('module.simulation.verify_setup', $module) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="text" name="code" placeholder="123456" class="text-center text-2xl tracking-widest w-48 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" maxlength="6" required>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700">
                        Ověřit a Pokračovat
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
