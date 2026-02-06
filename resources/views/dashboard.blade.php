<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Výukové moduly MFA') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

                @foreach ($modules as $module)
                    @php
                        $userProgress = $module->progress->first();
                        $isCompleted = $userProgress && $userProgress->completed_at;

                        $difficultyColor = match($module->difficulty->color()) {
                            'green' => 'bg-green-100 text-green-800',
                            'yellow' => 'bg-yellow-100 text-yellow-800',
                            'red' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp

                    <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $difficultyColor }}">
                                    {{ ucfirst($module->difficulty->value) }}
                                </span>

                                @if($isCompleted)
                                    <span class="text-green-600 font-bold flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Hotovo
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                {{ $module->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-6 h-12 overflow-hidden">
                                {{ Str::limit($module->description, 100) }}
                            </p>

                            <div class="flex justify-end">
                                <a href="{{ route('module.theory', $module) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ $userProgress ? 'Pokračovat' : 'Zahájit lekci' }}
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
