<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $module->title }} - Závěrečný test
            </h2>
            <div class="text-sm text-gray-500">Krok 4/4</div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-slate-200">
                <form action="{{ route('module.quiz.submit', $module) }}" method="POST">
                    @csrf

                    <div class="p-8">
                        @foreach($questions as $index => $question)
                            <div class="mb-8 {{ !$loop->last ? 'border-b border-gray-100 pb-8' : '' }}">
                                <p class="text-lg font-medium text-gray-900 mb-4">
                                    {{ $index + 1 }}. {{ $question->text }}
                                </p>

                                <div class="space-y-3">
                                    @foreach($question->options as $key => $text)
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center h-5">
                                                <input type="radio"
                                                       name="answers[{{ $question->id }}]"
                                                       value="{{ $key }}"
                                                       class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                                                       required
                                                    {{ old('answers.' . $question->id) == $key ? 'checked' : '' }}>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <span class="text-gray-700">{{ $text }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 shadow-md transition">
                            Odeslat test k vyhodnocení
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
