@props(['code' => 'receivedCode'])

<div class="relative w-72 h-[500px] bg-gray-900 border-[12px] border-gray-800 rounded-[2.5rem] shadow-xl overflow-hidden flex flex-col mx-auto">
    <div class="absolute top-0 inset-x-0 h-6 flex justify-center z-20">
        <div class="w-24 h-5 bg-gray-800 rounded-b-xl"></div>
    </div>

    <div class="flex-1 bg-gray-100 flex flex-col p-4 pt-10">
        <div class="text-center mb-6">
            <h3 class="text-gray-800 font-semibold text-lg">Zprávy</h3>
        </div>

        <template x-if="{{ $code }}">
            <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-4 max-w-[90%] transform transition-all duration-500 translate-y-0 opacity-100">
                <p class="text-xs text-gray-500 mb-1">MFA Systém</p>
                <p class="text-sm text-gray-800">
                    Váš ověřovací kód je: <br>
                    <strong class="text-blue-600 text-xl tracking-widest mt-1 block" x-text="{{ $code }}"></strong>
                </p>
            </div>
        </template>

        <template x-if="!{{ $code }}">
            <div class="flex-1 flex items-center justify-center">
                <p class="text-gray-400 text-sm text-center">Telefon je v pohotovosti...</p>
            </div>
        </template>
    </div>
</div>
