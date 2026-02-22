<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-100 leading-tight tracking-tight">
                    {{ __('Výukové moduly MFA') }}
                </h2>
                <p class="text-slate-400 text-sm mt-1">Vyberte si metodu autentizace a prozkoumejte její principy i rizika.</p>
            </div>

            {{-- Celkový progres studenta --}}
            <div class="bg-slate-800/80 rounded-xl px-5 py-3 border border-slate-700/50 backdrop-blur-sm shadow-inner">
                <span class="text-slate-400 text-xs uppercase tracking-wider font-semibold block mb-1">Celkový postup</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-indigo-400">
                        {{ collect($progress)->filter(fn($val) => $val === 4)->count() }}
                    </span>
                    <span class="text-slate-500 font-medium">/ {{ $modules->count() }} modulů</span>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Dark mode wrapper pro celý obsah --}}
    <div class="py-12 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">

                @foreach ($modules as $module)
                    @php
                        $completedSteps = $progress[$module->slug] ?? 0;
                        $totalSteps = 4;

                        $progressPercentage = ($completedSteps / $totalSteps) * 100;
                        $isCompleted = $completedSteps === $totalSteps;

                        // Moderní barvy pro štítky v tmavém režimu
                        $diffClasses = match($module->difficulty->color()) {
                            'green' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'yellow' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                            'red' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                            default => 'bg-slate-500/10 text-slate-400 border-slate-500/20'
                        };

                        $modulEnum = \App\Enums\ModulSlug::tryFrom($module->slug);

                        $nextRoute = match($completedSteps) {
                            1 => route($modulEnum ? $modulEnum->getSimulationSetupRoute() : 'dashboard', ['module' => $module->slug]),
                            2 => route($modulEnum ? $modulEnum->getSimulationAttackRoute() : 'dashboard', ['module' => $module->slug]),
                            3 => route($modulEnum ? $modulEnum->getSimulationLessonsRoute() : 'dashboard', ['module' => $module->slug]),
                            4 => route('module.quiz', ['module' => $module->slug]),
                            default => route('module.theory', ['module' => $module->slug]),
                        };
                    @endphp

                    {{-- Samotná karta modulu --}}
                    <div class="relative group bg-slate-800/40 backdrop-blur-md overflow-hidden rounded-2xl border border-slate-700/50 hover:border-indigo-500/50 transition-all duration-300 flex flex-col shadow-xl hover:shadow-indigo-500/10">

                        {{-- Horní indikátor postupu (svítící linka) --}}
                        <div class="absolute top-0 left-0 h-1 bg-indigo-500 transition-all duration-700 ease-out shadow-[0_0_10px_rgba(99,102,241,0.5)]" style="width: {{ $progressPercentage }}%"></div>

                        <div class="p-6 md:p-8 flex-grow">
                            <div class="flex justify-between items-start mb-6">

                                {{-- Ikona modulu s hover efektem --}}
                                <div class="p-3 bg-slate-700/50 rounded-xl border border-slate-600/50 text-indigo-400 group-hover:scale-110 group-hover:bg-indigo-500/20 group-hover:text-indigo-300 transition-all duration-300">
                                    {{-- Lze nahradit dynamickým @include('components.mfa-icons.' . $module->slug) --}}
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>

                                {{-- Štítky (Obtížnost + Status) --}}
                                <div class="flex flex-col items-end gap-2">
                                    {{-- <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full border {{ $diffClasses }}">
                                         {{ ucfirst($module->difficulty->value) }}
                                     </span> --}}

                                     @if($isCompleted)
                                         <span class="flex items-center text-[10px] font-bold uppercase tracking-widest text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1 rounded-full">
                                             <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                             Hotovo
                                         </span>
                                     @endif
                                 </div>
                             </div>

                             <h3 class="text-xl font-bold text-slate-100 mb-3 group-hover:text-indigo-400 transition-colors duration-300">
                                 {{ $module->title }}
                             </h3>
                             <p class="text-slate-400 text-sm leading-relaxed">
                                 {{ Str::limit($module->description, 120) }}
                             </p>
                         </div>

                         {{-- Spodní část s navigací a detailem postupu --}}
                        <div class="px-6 md:px-8 pb-6 md:pb-8 mt-auto">
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Postup modulem</span>
                                    <span class="text-xs font-bold text-indigo-400">{{ $completedSteps }} / {{ $totalSteps }}</span>
                                </div>
                                <div class="w-full bg-slate-700/50 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-1.5 rounded-full transition-all duration-500 ease-in-out" style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <a href="{{ $nextRoute }}"
                               class="relative w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600/90 hover:bg-indigo-500 border border-transparent rounded-xl font-bold text-sm text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900 group/btn overflow-hidden shadow-lg shadow-indigo-500/20">
                                <span class="relative z-10 flex items-center gap-2">
                                    {{ $completedSteps > 0 && !$isCompleted ? 'Pokračovat v lekci' : ($isCompleted ? 'Zopakovat lekci' : 'Zahájit lekci') }}
                                    <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
