<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-slate-100 leading-tight tracking-tight">
                    {{ $module->title }} <span class="text-gray-500 dark:text-slate-400 font-normal">| Závěrečné ověření</span>
                </h2>
            </div>

            {{-- Indikátor postupu - Kompletně vyplněn --}}
            <div class="bg-white dark:bg-slate-800/80 rounded-xl px-5 py-2 border border-gray-200 dark:border-slate-700/50 backdrop-blur-sm shadow-sm dark:shadow-inner flex items-center gap-3">
                <div class="flex gap-1">
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                    <span class="h-1.5 w-3 rounded-full bg-indigo-500 shadow-[0_0_5px_rgba(99,102,241,0.5)]"></span>
                </div>
                <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                    Krok 4 / 4
                </span>
            </div>
        </div>
    </x-slot>

    @php
        $incorrectQuestions = session('incorrectQuestions', []);
        $submitted = session('submitted', false);
    @endphp

    <div class="py-12 bg-gray-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Chybové hlášení --}}
            @if(session('error'))
                <div class="mb-8 flex items-center gap-4 p-5 bg-rose-500/10 border border-rose-500/20 rounded-2xl text-rose-500 shadow-lg shadow-rose-500/5">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold text-sm uppercase tracking-wide">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800/40 dark:backdrop-blur-md overflow-hidden shadow-xl dark:shadow-2xl sm:rounded-3xl border border-gray-200 dark:border-slate-700/50 flex flex-col transition-all duration-300">

                {{-- Neonová linka progresu - Plná (100%) --}}
                <div class="absolute top-0 left-0 h-1 w-full bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,0.6)]"></div>

                <form action="{{ route('module.quiz.submit', ['module' => $module->slug]) }}" method="POST">
                    @csrf

                    <div class="p-8 md:p-12 space-y-12">
                        @foreach($questions as $index => $question)
                            @php
                                $isIncorrect = $submitted && array_key_exists($question->id, $incorrectQuestions);
                                $isCorrectlyAnswered = $submitted && !array_key_exists($question->id, $incorrectQuestions) && old('answers.' . $question->id);
                                $correctOption = $incorrectQuestions[$question->id] ?? null;
                            @endphp

                            <div class="relative group {{ $isIncorrect ? 'quiz-incorrect' : '' }}"
                                 @if($isIncorrect) id="question-{{ $question->id }}" @endif>

                                {{-- Číslo otázky jako subtilní pozadí --}}
                                <span class="absolute -left-4 -top-4 text-6xl font-black select-none pointer-events-none transition-colors
                                    {{ $isIncorrect ? 'text-rose-500/15' : ($isCorrectlyAnswered ? 'text-emerald-500/15' : 'text-slate-100 dark:text-slate-700/20 group-hover:text-indigo-500/10') }}">
                                    {{ $index + 1 }}
                                </span>

                                {{-- Indikátor stavu otázky --}}
                                @if($isIncorrect)
                                    <div class="absolute -right-2 -top-2 z-20">
                                        <span class="flex items-center gap-1.5 bg-rose-500 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg shadow-rose-500/30">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Nesprávně
                                        </span>
                                    </div>
                                @elseif($isCorrectlyAnswered)
                                    <div class="absolute -right-2 -top-2 z-20">
                                        <span class="flex items-center gap-1.5 bg-emerald-500 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg shadow-emerald-500/30">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Správně
                                        </span>
                                    </div>
                                @endif

                                <div class="relative z-10 p-5 rounded-2xl border-2 transition-all duration-300
                                    {{ $isIncorrect
                                        ? 'border-rose-500/40 bg-rose-500/5 dark:bg-rose-500/10'
                                        : ($isCorrectlyAnswered
                                            ? 'border-emerald-500/30 bg-emerald-500/5 dark:bg-emerald-500/5'
                                            : 'border-transparent') }}">

                                    <h3 class="text-xl font-bold text-gray-900 dark:text-slate-100 mb-6 tracking-tight leading-snug pr-24">
                                        {{ $question->text }}
                                    </h3>

                                    <div class="grid grid-cols-1 gap-3">
                                        @foreach($question->options as $key => $text)
                                            @php
                                                $userSelected = old('answers.' . $question->id) == $key;
                                                $isCorrectOption = $isIncorrect && $key === $correctOption;
                                                $isWrongSelection = $isIncorrect && $userSelected && $key !== $correctOption;
                                            @endphp

                                            <label class="relative flex items-center p-4 rounded-2xl border cursor-pointer transition-all duration-200 group/option
                                                @if($isWrongSelection)
                                                    border-rose-500/50 bg-rose-500/10 dark:bg-rose-500/15
                                                @elseif($isCorrectOption)
                                                    border-emerald-500/50 bg-emerald-500/10 dark:bg-emerald-500/15 ring-2 ring-emerald-500/30
                                                @elseif($isCorrectlyAnswered && $userSelected)
                                                    border-emerald-500/30 bg-emerald-500/5
                                                @else
                                                    border-gray-100 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/30 hover:border-indigo-500/50 hover:bg-white dark:hover:bg-slate-800
                                                @endif
                                            ">
                                                <div class="flex items-center h-5">
                                                    <input type="radio"
                                                           name="answers[{{ $question->id }}]"
                                                           value="{{ $key }}"
                                                           class="w-5 h-5 border-gray-300 dark:border-slate-600 focus:ring-indigo-500 dark:focus:ring-offset-slate-800 bg-white dark:bg-slate-800
                                                               {{ $isWrongSelection ? 'text-rose-500' : ($isCorrectOption || ($isCorrectlyAnswered && $userSelected) ? 'text-emerald-500' : 'text-indigo-600') }}"
                                                           required
                                                        {{ $userSelected ? 'checked' : '' }}>
                                                </div>
                                                <div class="ml-4 text-sm font-medium transition-colors flex-1
                                                    @if($isWrongSelection)
                                                        text-rose-700 dark:text-rose-400
                                                    @elseif($isCorrectOption)
                                                        text-emerald-700 dark:text-emerald-400
                                                    @elseif($isCorrectlyAnswered && $userSelected)
                                                        text-emerald-700 dark:text-emerald-400
                                                    @else
                                                        text-gray-700 dark:text-slate-300 group-hover/option:text-indigo-600 dark:group-hover/option:text-indigo-400
                                                    @endif
                                                ">
                                                    {{ $text }}
                                                </div>

                                                {{-- Ikony stavu --}}
                                                @if($isWrongSelection)
                                                    <div class="ml-2 shrink-0">
                                                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </div>
                                                @elseif($isCorrectOption)
                                                    <div class="ml-2 shrink-0 flex items-center gap-1.5">
                                                        <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider">Správná odpověď</span>
                                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                @elseif($isCorrectlyAnswered && $userSelected)
                                                    <div class="ml-2 shrink-0">
                                                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Patička s odesláním --}}
                    <div class="bg-gray-50/80 dark:bg-slate-800/60 px-8 py-8 border-t border-gray-100 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <p class="text-xs font-medium uppercase tracking-widest leading-none">
                                @if($submitted)
                                    Opravte nesprávné odpovědi a odešlete znovu.
                                @else
                                    Ujistěte se, že jste vybrali odpovědi u všech otázek.
                                @endif
                            </p>
                        </div>

                        <button type="submit" class="relative w-full md:w-auto inline-flex items-center justify-center px-10 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600/90 dark:hover:bg-indigo-500 border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-[0.2em] transition-all duration-300 shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 group/btn">
                            <span class="relative z-10 flex items-center gap-2">
                                {{ $submitted ? 'Odeslat opravené odpovědi' : 'Vyhodnotit výsledky' }}
                                <svg class="w-5 h-5 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scroll k první chybné otázce --}}
    @if($submitted && count($incorrectQuestions) > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const firstIncorrect = document.querySelector('.quiz-incorrect');
                if (firstIncorrect) {
                    setTimeout(() => {
                        firstIncorrect.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
            });
        </script>
    @endif
</x-app-layout>
