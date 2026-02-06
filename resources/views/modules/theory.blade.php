<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $module->title }} - Teorie
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Zpět na přehled
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">

                <div class="p-8 prose max-w-none">
                    @if(View::exists($contentView))
                        @include($contentView)
                    @else
                        <div class="p-4 bg-yellow-100 text-yellow-800 rounded-lg">
                            ⚠️ Obsah pro modul <strong>{{ $module->slug }}</strong> zatím nebyl vytvořen.
                            <br>
                            (Vytvořte soubor: <code>resources/views/modules/content/{{ $module->slug }}.blade.php</code>)
                        </div>
                    @endif
                </div>

                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex justify-end items-center">
                    <form action="{{ route('module.theory.complete', $module) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Rozumím, přejít k ukázce kódu
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
