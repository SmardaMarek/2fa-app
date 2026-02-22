@props(['code' => 'receivedCode', 'simSwapped' => 'false'])

<div class="relative w-72 h-[500px] bg-gray-900 border-[12px] border-gray-800 rounded-[2.5rem] shadow-xl overflow-hidden flex flex-col mx-auto">
    <div class="absolute top-0 inset-x-0 h-6 flex justify-center z-20">
        <div class="w-24 h-5 bg-gray-800 rounded-b-xl"></div>
    </div>

    <div class="relative flex-1 bg-gray-100 flex flex-col p-4 pt-10">

        <div class="text-center mb-6">
            <h3 class="text-gray-800 font-semibold text-lg">Zprávy</h3>
        </div>

        <template x-if="{{ $code }}">
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-4 max-w-[90%] animate-fade-in">
                <p class="text-xs text-gray-500 mb-1">MFA Systém</p>
                <p class="text-sm text-gray-800">
                    Váš ověřovací kód je: <br>
                    <strong class="text-blue-600 text-xl tracking-widest mt-1 block" x-text="{{ $code }}"></strong>
                </p>
            </div>
        </template>

        <template x-if="!{{ $code }}">
            <div class="flex-1 flex items-center justify-center">
                <p class="text-gray-400 text-xs text-center px-4 italic">
                    Čekání na příchozí zprávu...
                </p>
            </div>
        </template>

        <div x-show="{{ $simSwapped }}" x-cloak x-transition.opacity.duration.500ms class="absolute inset-0 bg-gray-900/90 z-30 flex flex-col items-center justify-center backdrop-blur-sm">
            <svg class="w-12 h-12 text-red-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"></path></svg>
            <span class="bg-red-600 text-white text-xs px-3 py-1 rounded font-bold shadow-lg tracking-widest">ŽÁDNÁ SLUŽBA</span>
            <span class="text-gray-400 text-[10px] mt-4 max-w-[80%] text-center">SIM karta není registrována v síti.</span>
        </div>

    </div>
</div>
