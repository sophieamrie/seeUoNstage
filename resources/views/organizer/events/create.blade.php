@extends('layouts.organizer')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    <h1 class="text-2xl font-bold mb-5">Create Event</h1>

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

    <!-- Success Message Display -->
    @if (session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    <!-- Error Message Display -->
    @if (session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
        <i class="fas fa-times-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Event Details Section -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 space-y-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Event Details</h2>

            <div>
                <label class="font-semibold">Title *</label>
                <input type="text" name="title" class="w-full border p-2 rounded @error('title') border-red-500 @enderror"
                       value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="font-semibold">Description *</label>
                <textarea name="description" class="w-full border p-2 rounded @error('description') border-red-500 @enderror" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Category</label>
                    <input type="text" name="category" class="w-full border p-2 rounded @error('category') border-red-500 @enderror"
                           value="{{ old('category') }}">
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Artist</label>
                    <input type="text" name="artist" class="w-full border p-2 rounded @error('artist') border-red-500 @enderror"
                           value="{{ old('artist') }}">
                    @error('artist')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="font-semibold">Location *</label>
                <input type="text" name="location" class="w-full border p-2 rounded @error('location') border-red-500 @enderror"
                       value="{{ old('location') }}" required>
                @error('location')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Start Datetime *</label>
                    <input type="datetime-local" name="start_datetime" class="w-full border p-2 rounded @error('start_datetime') border-red-500 @enderror"
                           value="{{ old('start_datetime') }}" required>
                    @error('start_datetime')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">End Datetime</label>
                    <input type="datetime-local" name="end_datetime" class="w-full border p-2 rounded @error('end_datetime') border-red-500 @enderror"
                           value="{{ old('end_datetime') }}">
                    @error('end_datetime')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="font-semibold">Event Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Ticket Types Section -->
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Ticket Types *</h2>
            <p class="text-sm text-gray-600 mb-4">Add at least one ticket type for this event (VIP, Regular, Early Bird, etc.)</p>
            
            @error('ticket_types')
                <div class="bg-red-50 border border-red-200 text-red-800 px-3 py-2 rounded mb-4 text-sm">
                    {{ $message }}
                </div>
            @enderror

            <div id="ticket-types-container" class="space-y-4">
                <!-- Ticket Type 1 (default) -->
                <div class="ticket-type-row bg-white p-4 rounded-lg border border-gray-300">
                    <h4 class="font-semibold text-gray-700 mb-3">Ticket Type 1</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name *</label>
                            <input type="text" name="ticket_types[0][name]" placeholder="e.g., VIP, Regular" class="w-full px-3 py-2 border rounded-lg" value="{{ old('ticket_types.0.name') }}" required>
                            @error('ticket_types.0.name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                            <input type="number" name="ticket_types[0][price]" placeholder="500000" min="0" class="w-full px-3 py-2 border rounded-lg" value="{{ old('ticket_types.0.price') }}" required>
                            @error('ticket_types.0.price')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quota *</label>
                            <input type="number" name="ticket_types[0][quota]" placeholder="100" min="1" class="w-full px-3 py-2 border rounded-lg" value="{{ old('ticket_types.0.quota') }}" required>
                            @error('ticket_types.0.quota')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                            <input type="text" name="ticket_types[0][description]" placeholder="Includes backstage pass" class="w-full px-3 py-2 border rounded-lg" value="{{ old('ticket_types.0.description') }}">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="addTicketType()" class="mt-4 text-purple-600 hover:text-purple-700 font-semibold flex items-center">
                <i class="fas fa-plus mr-2"></i>Add Another Ticket Type
            </button>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition">
                <i class="fas fa-check mr-2"></i>Create Event
            </button>
            <a href="{{ route('organizer.events.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-semibold transition">
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
        <div class="ticket-type-row bg-white p-4 rounded-lg border border-gray-300">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-semibold text-gray-700">Ticket Type ${ticketTypeIndex + 1}</h4>
                <button type="button" onclick="this.closest('.ticket-type-row').remove()" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name *</label>
                    <input type="text" name="ticket_types[${ticketTypeIndex}][name]" placeholder="e.g., VIP, Regular" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                    <input type="number" name="ticket_types[${ticketTypeIndex}][price]" placeholder="500000" min="0" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quota *</label>
                    <input type="number" name="ticket_types[${ticketTypeIndex}][quota]" placeholder="100" min="1" class="w-full px-3 py-2 border rounded-lg" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description (Optional)</label>
                    <input type="text" name="ticket_types[${ticketTypeIndex}][description]" placeholder="Includes backstage pass" class="w-full px-3 py-2 border rounded-lg">
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newRow);
    ticketTypeIndex++;
}
</script>
@endsection