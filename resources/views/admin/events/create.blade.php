@extends('layouts.admin')

@section('title', 'Create Event')
@section('page-title', 'Create New Event')

@section('content')
<div class="max-w-3xl">
    <!-- Error Messages Display -->
    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
        <p class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <!-- Event Details Section -->
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Event Details</h3>

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Event Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('title') border-red-500 @enderror"
                        placeholder="Enter event title">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('description') border-red-500 @enderror"
                        placeholder="Enter event description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Artist -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('category') border-red-500 @enderror"
                            placeholder="e.g., Concert, Sports">
                        @error('category')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="artist" class="block text-sm font-semibold text-gray-700 mb-2">Artist / Performer</label>
                        <input type="text" id="artist" name="artist" value="{{ old('artist') }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('artist') border-red-500 @enderror"
                            placeholder="e.g., John Doe">
                        @error('artist')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('location') border-red-500 @enderror"
                        placeholder="e.g., Jakarta Convention Center">
                    @error('location')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date & Time -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="start_datetime" class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="start_datetime" name="start_datetime" value="{{ old('start_datetime') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('start_datetime') border-red-500 @enderror">
                        @error('start_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_datetime" class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time <span class="text-red-500">*</span></label>
                        <input type="datetime-local" id="end_datetime" name="end_datetime" value="{{ old('end_datetime') }}" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('end_datetime') border-red-500 @enderror">
                        @error('end_datetime')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Event Image</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 transition cursor-pointer" id="dropZone">
                        <div>
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-700 font-medium">Click to upload or drag and drop</p>
                            <p class="text-gray-500 text-sm">PNG, JPG, GIF up to 2MB</p>
                        </div>
                        <input type="file" id="image_url" name="image_url" accept="image/*" class="hidden">
                    </div>
                    @error('image_url')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Publish Checkbox -->
                <div>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="is_published" name="is_published" value="1" class="w-4 h-4 text-purple-600 rounded">
                        <span class="ml-2 text-gray-700">Publish event immediately</span>
                    </label>
                </div>
            </div>

            <!-- Ticket Types Section -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Ticket Types <span class="text-red-500">*</span></h3>
                <p class="text-sm text-gray-600 mb-4">Add at least one ticket type for this event (VIP, Regular, Early Bird, etc.)</p>
                
                @error('ticket_types')
                    <div class="bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded mb-4 text-sm">
                        {{ $message }}
                    </div>
                @enderror

                <div id="ticket-types-container" class="space-y-4">
                    <!-- Ticket Type 1 (default) -->
                    <div class="ticket-type-row bg-gray-50 p-4 rounded-lg border border-gray-300">
                        <h4 class="font-semibold text-gray-700 mb-3">Ticket Type 1</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name <span class="text-red-500">*</span></label>
                                <input type="text" name="ticket_types[0][name]" placeholder="e.g., VIP, Regular" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('ticket_types.0.name') }}" required>
                                @error('ticket_types.0.name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                                <input type="number" name="ticket_types[0][price]" placeholder="500000" min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('ticket_types.0.price') }}" required>
                                @error('ticket_types.0.price')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quota <span class="text-red-500">*</span></label>
                                <input type="number" name="ticket_types[0][quota]" placeholder="100" min="1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('ticket_types.0.quota') }}" required>
                                @error('ticket_types.0.quota')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                                <input type="text" name="ticket_types[0][description]" placeholder="Includes backstage pass" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" value="{{ old('ticket_types.0.description') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="addTicketType()" class="mt-4 text-purple-600 hover:text-purple-700 font-semibold flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i>Add Another Ticket Type
                </button>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6 border-t">
                <a href="{{ route('admin.events.index') }}" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">
                    <i class="fas fa-plus mr-2"></i>Create Event with Tickets
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image upload functionality
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('image_url');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-purple-500', 'bg-purple-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-purple-500', 'bg-purple-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-purple-500', 'bg-purple-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
        }
    });

    // Ticket type functionality
    let ticketTypeIndex = 1;

    function addTicketType() {
        const container = document.getElementById('ticket-types-container');
        const newRow = `
            <div class="ticket-type-row bg-gray-50 p-4 rounded-lg border border-gray-300">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700">Ticket Type ${ticketTypeIndex + 1}</h4>
                    <button type="button" onclick="this.closest('.ticket-type-row').remove()" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name <span class="text-red-500">*</span></label>
                        <input type="text" name="ticket_types[${ticketTypeIndex}][name]" placeholder="e.g., VIP, Regular" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="ticket_types[${ticketTypeIndex}][price]" placeholder="500000" min="0" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quota <span class="text-red-500">*</span></label>
                        <input type="number" name="ticket_types[${ticketTypeIndex}][quota]" placeholder="100" min="1" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                        <input type="text" name="ticket_types[${ticketTypeIndex}][description]" placeholder="Includes backstage pass" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newRow);
        ticketTypeIndex++;
    }
</script>
@endsection