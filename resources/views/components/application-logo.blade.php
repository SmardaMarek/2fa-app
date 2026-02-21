@props([
    'variant' => 'middle', // middle | big
])

@php
    $variants = [
        'middle' => [
            'wrapper' => 'gap-3',
            'box' => 'p-2.5',        // 🔥 VĚTŠÍ PADDING
            'icon' => 'w-6 h-6',
            'text' => 'text-xl',
        ],
        'big' => [
            'wrapper' => 'gap-4',
            'box' => 'p-4',          // 🔥 VÝRAZNĚ VĚTŠÍ PADDING
            'icon' => 'w-8 h-8',
            'text' => 'text-3xl',
        ],
    ];

    $v = $variants[$variant] ?? $variants['middle'];
@endphp

<div class="flex items-center {{ $v['wrapper'] }}">
    <div class="bg-indigo-600 rounded-xl {{ $v['box'] }} flex items-center justify-center text-white shadow-lg">
        <svg class="{{ $v['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
    </div>
</div>
