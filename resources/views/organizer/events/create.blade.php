@extends('layouts.organizer')

@section('title', 'Create Event')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-white mb-2">Create New Event</h1>
        <p class="text-gray-400">Fill in the details below to create an amazing event</p>
    </div>

    <!-- Error Messages Display -->
    @if ($errors->any())
    <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm text-red-300 px-4 py-3 rounded-xl">
        <p class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Event Details Section -->
        <div class="glass p-6 rounded-2xl border border-white/10 space-y-6">
            <h2 class="text-2xl font-bold text-white mb-4 flex items-center">
                <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-info-circle text-purple-400"></i>
                </div>
                Event Details
            </h2>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Title *</label>
                <input type="text" name="title" 
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('title') border-red-500 @enderror"
                       value="{{ old('title') }}" 
                       placeholder="Enter event title"
                       required>
                @error('title')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Description *</label>
                <textarea name="description" 
                          class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('description') border-red-500 @enderror" 
                          rows="5" 
                          placeholder="Describe your event in detail..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-300 mb-2">Category</label>
                    <select id="category" name="category" 
                        class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('category') border-red-500 @enderror">
                        <option value="">Select category...</option>
                        <option value="Concert" {{ old('category') == 'Concert' ? 'selected' : '' }}>Concert</option>
                        <option value="Festival" {{ old('category') == 'Festival' ? 'selected' : '' }}>Festival</option>
                        <option value="Comedy" {{ old('category') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
                        <option value="Theater" {{ old('category') == 'Theater' ? 'selected' : '' }}>Theater</option>
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Artist</label>
                    <input type="text" name="artist" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('artist') border-red-500 @enderror"
                           value="{{ old('artist') }}"
                           placeholder="Performing artist name">
                    @error('artist')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Location *</label>
                <input type="text" name="location" 
                       class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('location') border-red-500 @enderror"
                       value="{{ old('location') }}" 
                       placeholder="Event venue location"
                       required>
                @error('location')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">Start Datetime *</label>
                    <input type="datetime-local" name="start_datetime" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('start_datetime') border-red-500 @enderror"
                           value="{{ old('start_datetime') }}" 
                           required>
                    @error('start_datetime')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-white mb-2">End Datetime</label>
                    <input type="datetime-local" name="end_datetime" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('end_datetime') border-red-500 @enderror"
                           value="{{ old('end_datetime') }}">
                    @error('end_datetime')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-white mb-2">Event Image</label>
                <div class="relative">
                    <input type="file" name="image" accept="image/*" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 focus:outline-none @error('image') border-red-500 @enderror">
                </div>
                <p class="text-gray-400 text-xs mt-2">Recommended: 1920x1080px, JPG or PNG, max 2MB</p>
                @error('image')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Ticket Types Section -->
        <div class="glass p-6 rounded-2xl border border-white/10">
            <h2 class="text-2xl font-bold text-white mb-2 flex items-center">
                <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-ticket-alt text-green-400"></i>
                </div>
                Ticket Types *
            </h2>
            <p class="text-sm text-gray-400 mb-6">Add at least one ticket type for this event (VIP, Regular, Early Bird, etc.)</p>
            
            @error('ticket_types')
                <div class="bg-red-500/20 border border-red-500/50 backdrop-blur-sm text-red-300 px-3 py-2 rounded-lg mb-4 text-sm">
                    {{ $message }}
                </div>
            @enderror

            <div id="ticket-types-container" class="space-y-4">
                <!-- Ticket Type 1 (default) -->
                <div class="ticket-type-row bg-white/5 p-6 rounded-xl border border-white/10">
                    <h4 class="font-semibold text-white mb-4 flex items-center">
                        <span class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-2 text-purple-400 text-sm">1</span>
                        Ticket Type 1
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Ticket Name *</label>
                            <input type="text" name="ticket_types[0][name]" placeholder="e.g., VIP, Regular" 
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                                   value="{{ old('ticket_types.0.name') }}" required>
                            @error('ticket_types.0.name')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Price (Rp) *</label>
                            <input type="number" name="ticket_types[0][price]" placeholder="500000" min="0" 
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                                   value="{{ old('ticket_types.0.price') }}" required>
                            @error('ticket_types.0.price')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Quota *</label>
                            <input type="number" name="ticket_types[0][quota]" placeholder="100" min="1" 
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                                   value="{{ old('ticket_types.0.quota') }}" required>
                            @error('ticket_types.0.quota')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Description (Optional)</label>
                            <input type="text" name="ticket_types[0][description]" placeholder="Includes backstage pass" 
                                   class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" 
                                   value="{{ old('ticket_types.0.description') }}">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addTicketType()" class="mt-4 text-purple-400 hover:text-purple-300 font-semibold flex items-center transition">
                <i class="fas fa-plus-circle mr-2"></i>Add Another Ticket Type
            </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex space-x-4">
            <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 hover:shadow-lg hover:shadow-purple-500/50 text-white px-6 py-3 rounded-full font-semibold transition flex items-center justify-center">
                <i class="fas fa-check mr-2"></i>Create Event
            </button>
            <a href="{{ route('organizer.events.index') }}" class="flex-1 glass hover:bg-white/10 text-white px-6 py-3 rounded-full font-semibold transition flex items-center justify-center">
                <i class="fas fa-times mr-2"></i>Cancel
            </a>
        </div>
    </form>

</div>

<script>
let ticketTypeIndex = 1;

function addTicketType() {
    const container = document.getElementById('ticket-types-container');
    const newRow = `
        <div class="ticket-type-row bg-white/5 p-6 rounded-xl border border-white/10">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-white flex items-center">
                    <span class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-2 text-purple-400 text-sm">${ticketTypeIndex + 1}</span>
                    Ticket Type ${ticketTypeIndex + 1}
                </h4>
                <button type="button" onclick="this.closest('.ticket-type-row').remove()" class="text-red-400 hover:text-red-300 transition">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Ticket Name *</label>
                    <input type="text" name="ticket_types[${ticketTypeIndex}][name]" placeholder="e.g., VIP, Regular" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Price (Rp) *</label>
                    <input type="number" name="ticket_types[${ticketTypeIndex}][price]" placeholder="500000" min="0" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Quota *</label>
                    <input type="number" name="ticket_types[${ticketTypeIndex}][quota]" placeholder="100" min="1" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description (Optional)</label>
                    <input type="text" name="ticket_types[${ticketTypeIndex}][description]" placeholder="Includes backstage pass" 
                           class="w-full bg-white/5 border border-white/10 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newRow);
    ticketTypeIndex++;
}
</script>
@endsection