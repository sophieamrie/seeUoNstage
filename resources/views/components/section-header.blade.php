{{-- resources/views/components/section-header.blade.php --}}
@props(['title', 'subtitle', 'link' => null, 'linkText' => 'View All', 'dark' => false])

<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-3xl font-bold {{ $dark ? 'text-white' : 'text-gray-800' }} mb-2">{{ $title }}</h2>
        @if($subtitle)
            <p class="{{ $dark ? 'text-purple-200' : 'text-gray-600' }}">{{ $subtitle }}</p>
        @endif
    </div>
    @if($link)
        <a href="{{ $link }}" class="{{ $dark ? 'text-white hover:text-purple-200' : 'text-purple-600 hover:text-purple-800' }} font-semibold flex items-center">
            {{ $linkText }} <i class="fas fa-arrow-right ml-2"></i>
        </a>
    @endif
</div>