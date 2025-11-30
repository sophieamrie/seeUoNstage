{{-- resources/views/components/popular-event.blade.php --}}
@props(['event'])

<a href="{{ route('events.show', $event) }}" class="group">
    @if($event->image_url)
        <div class="w-24 h-24 rounded-full overflow-hidden mb-3 mx-auto border-4 border-white/20 group-hover:border-white/50 transition group-hover:scale-110 duration-300 shadow-lg">
            <img src="{{ asset('storage/' . $event->image_url) }}" 
                 alt="{{ $event->title }}" 
                 class="w-full h-full object-cover">
        </div>
    @else
        <div class="w-24 h-24 bg-gradient-to-br from-pink-500 to-purple-500 rounded-full flex items-center justify-center text-3xl font-bold mb-3 mx-auto border-4 border-white/20 group-hover:border-white/50 group-hover:scale-110 transition duration-300 shadow-lg">
            {{ substr($event->title, 0, 1) }}
        </div>
    @endif
    <p class="text-center text-sm font-semibold group-hover:text-purple-200 transition">
        {{ Str::limit($event->title, 20) }}
    </p>
    @if($event->artist)
        <p class="text-center text-xs text-purple-300">{{ Str::limit($event->artist, 15) }}</p>
    @endif
</a>