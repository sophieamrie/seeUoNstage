@extends('layouts.admin')

@section('title', 'Create Event')
@section('page-title', 'Create New Event')

@section('content')
<div class="max-w-4xl">
    <div class="bg-gray-800/50 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf

            <!-- Event Details Section -->
            <div>
                <h3 class="text-xl font-bold text-white mb-6 flex items-center">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-purple-400"></i>
                    </div>
                    Event Details
                </h3>

                <div class="space-y-5">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">
                            Event Title <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('title') border-red-500 @enderror"
                            placeholder="Enter event title">
                        @error('title')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">
                            Description <span class="text-red-400">*</span>
                        </label>
                        <textarea id="description" name="description" rows="4" required
                            class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition @error('description') border-red-500 @enderror"
                            placeholder="Describe your event...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category & Artist -->
                    <div class="grid grid-cols-2 gap-4">
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
                            <label for="artist" class="block text-sm font-semibold text-gray-300 mb-2">Artist / Performer</label>
                            <input type="text" id="artist" name="artist" value="{{ old('artist') }}"
                                class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                                placeholder="e.g., John Doe">
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-semibold text-gray-300 mb-2">
                            Location <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" required
                            class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition"
                            placeholder="e.g., Jakarta Convention Center">
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_datetime" class="block text-sm font-semibold text-gray-300 mb-2">
                                Start Date & Time <span class="text-red-400">*</span>
                            </label>
                            <input type="datetime-local" id="start_datetime" name="start_datetime" value="{{ old('start_datetime') }}" required
                                class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                        </div>

                        <div>
                            <label for="end_datetime" class="block text-sm font-semibold text-gray-300 mb-2">
                                End Date & Time <span class="text-red-400">*</span>
                            </label>
                            <input type="datetime-local" id="end_datetime" name="end_datetime" value="{{ old('end_datetime') }}" required
                                class="w-full px-4 py-3 bg-gray-900/50 border border-white/10 rounded-xl text-white focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition">
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Event Image</label>
                        <div class="relative border-2 border-dashed border-white/10 rounded-xl p-8 text-center hover:border-purple-500/50 transition cursor-pointer bg-gray-900/30" id="dropZone">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-500 mb-3"></i>
                            <p class="text-white font-medium mb-1">Click to upload or drag and drop</p>
                            <p class="text-gray-500 text-sm">PNG, JPG, GIF up to 2MB</p>
                            <input type="file" id="image_url" name="image_url" accept="image/*" class="hidden">
                        </div>
                    </div>

                    <!-- Publish Checkbox -->
                    <div class="bg-purple-500/10 border border-purple-500/30 rounded-xl p-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="is_published" name="is_published" value="1" class="w-4 h-4 text-purple-500 bg-gray-900/50 border-white/10 rounded focus:ring-purple-500/20">
                            <span class="ml-3 text-gray-300">Publish event immediately</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Ticket Types Section -->
            <div class="border-t border-white/10 pt-8">
                <h3 class="text-xl font-bold text-white mb-2 flex items-center">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-ticket-alt text-blue-400"></i>
                    </div>
                    Ticket Types <span class="text-red-400 ml-2">*</span>
                </h3>
                <p class="text-sm text-gray-400 mb-6">Add at least one ticket type (VIP, Regular, Early Bird, etc.)</p>
                
                @error('ticket_types')
                    <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-xl mb-6 text-sm">
                        {{ $message }}
                    </div>
                @enderror

                <div id="ticket-types-container" class="space-y-4">
                    <!-- Ticket Type 1 -->
                    <div class="ticket-type-row bg-gray-900/50 border border-white/10 p-5 rounded-xl">
                        <h4 class="font-semibold text-white mb-4">Ticket Type 1</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Name <span class="text-red-400">*</span></label>
                                <input type="text" name="ticket_types[0][name]" placeholder="e.g., VIP, Regular" 
                                    class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rp) <span class="text-red-400">*</span></label>
                                <input type="number" name="ticket_types[0][price]" placeholder="500000" min="0" 
                                    class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Quota <span class="text-red-400">*</span></label>
                                <input type="number" name="ticket_types[0][quota]" placeholder="100" min="1" 
                                    class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                                <input type="text" name="ticket_types[0][description]" placeholder="Optional" 
                                    class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addTicketType()" class="mt-4 text-purple-400 hover:text-purple-300 font-semibold flex items-center transition">
                    <i class="fas fa-plus-circle mr-2"></i>Add Another Ticket Type
                </button>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6 border-t border-white/10">
                <a href="{{ route('admin.events.index') }}" class="flex-1 px-6 py-3 border border-white/10 rounded-xl text-white font-semibold hover:bg-white/5 transition text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-white text-gray-900 rounded-xl font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-plus mr-2"></i>Create Event
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image upload
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('image_url');

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-purple-500');
    });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-purple-500'));
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-purple-500');
        if (e.dataTransfer.files.length > 0) fileInput.files = e.dataTransfer.files;
    });

    // Ticket types
    let ticketTypeIndex = 1;
    function addTicketType() {
        const container = document.getElementById('ticket-types-container');
        const newRow = `
            <div class="ticket-type-row bg-gray-900/50 border border-white/10 p-5 rounded-xl">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-semibold text-white">Ticket Type ${ticketTypeIndex + 1}</h4>
                    <button type="button" onclick="this.closest('.ticket-type-row').remove()" class="text-red-400 hover:text-red-300">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Name <span class="text-red-400">*</span></label>
                        <input type="text" name="ticket_types[${ticketTypeIndex}][name]" placeholder="e.g., VIP" 
                            class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Price (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="ticket_types[${ticketTypeIndex}][price]" placeholder="500000" min="0" 
                            class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Quota <span class="text-red-400">*</span></label>
                        <input type="number" name="ticket_types[${ticketTypeIndex}][quota]" placeholder="100" min="1" 
                            class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Description</label>
                        <input type="text" name="ticket_types[${ticketTypeIndex}][description]" placeholder="Optional" 
                            class="w-full px-4 py-2.5 bg-gray-800 border border-white/10 rounded-lg text-white placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newRow);
        ticketTypeIndex++;
    }
</script>
@endsection