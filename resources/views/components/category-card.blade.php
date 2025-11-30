{{-- resources/views/components/category-card.blade.php --}}
@props(['name', 'icon', 'color' => 'purple', 'count' => 0])

@php
$colorClasses = [
    'purple' => 'from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700',
    'pink' => 'from-pink-500 to-pink-600 hover:from-pink-600 hover:to-pink-700',
    'blue' => 'from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700',
    'green' => 'from-green-500 to-green-600 hover:from-green-600 hover:to-green-700',
    'orange' => 'from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700',
    'red' => 'from-red-500 to-red-600 hover:from-red-600 hover:to-red-700',
];
@endphp

<a href="{{ route('events.index', ['category' => $name]) }}" 
   class="bg-gradient-to-br {{ $colorClasses[$color] ?? $colorClasses['purple'] }} rounded-xl shadow-lg p-6 text-white hover:scale-105 transition-transform duration-300 group">
    <div class="flex items-center justify-between mb-4">
        <i class="fas fa-{{ $icon }} text-4xl opacity-80 group-hover:opacity-100 transition"></i>
        @if($count > 0)
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">{{ $count }}</span>
        @endif
    </div>
    <h3 class="text-xl font-bold">{{ $name }}</h3>
    <p class="text-sm text-white/80 mt-1">Browse {{ strtolower($name) }} events</p>
</a>