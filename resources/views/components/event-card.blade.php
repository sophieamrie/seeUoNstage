{{-- resources/views/components/event-card.blade.php --}}
@props(['event', 'size' => 'large'])

<a href="{{ route('events.show', $event) }}" 
   class="bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl shadow-xl overflow-hidden group hover:scale-105 transition-transform duration-300 {{ $size === 'large' ? 'h-96' : 'h-64' }}">
    @if($event->image_url)
        <div class="h-full w-full relative">
            <img src="{{ asset('storage/' . $event->image_url) }}" 
                 alt="{{ $event->title }}" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                <h2 class="{{ $size === 'large' ? 'text-3xl' : 'text-2xl' }} font-bold mb-2">{{ $event->title }}</h2>
                @if($event->artist)
                    <p class="{{ $size === 'large' ? 'text-xl' : 'text-lg' }} mb-2 text-purple-200">{{ $event->artist }}</p>
                @endif
                <div class="flex items-center text-sm space-x-4">
                    <span><i class="fas fa-calendar mr-1"></i>{{ $event->start_datetime->format('M d, Y') }}</span>
                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ Str::limit($event->location, 20) }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="h-full flex items-center justify-center p-8">
            <div class="text-center text-white">
                <h2 class="{{ $size === 'large' ? 'text-4xl' : 'text-3xl' }} font-bold mb-4">{{ $event->title }}</h2>
                @if($event->artist)
                    <p class="{{ $size === 'large' ? 'text-2xl' : 'text-xl' }} mb-4 text-purple-100">{{ $event->artist }}</p>
                @endif
                <div class="flex flex-col items-center space-y-2 text-lg">
                    <span><i class="fas fa-calendar mr-2"></i>{{ $event->start_datetime->format('M d, Y') }}</span>
                    <span><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</span>
                </div>
            </div>
        </div>
    @endif
</a>