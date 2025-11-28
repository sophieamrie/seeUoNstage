@extends('layouts.admin')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Event Title <span class="text-red-500">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('title') border-red-500 @enderror"
                    placeholder="Enter event title">
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="4" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('description') border-red-500 @enderror"
                    placeholder="Enter event description">{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category & Artist -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category', $event->category) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('category') border-red-500 @enderror"
                        placeholder="e.g., Concert, Sports">
                    @error('category')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="artist" class="block text-sm font-semibold text-gray-700 mb-2">Artist / Performer</label>
                    <input type="text" id="artist" name="artist" value="{{ old('artist', $event->artist) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('artist') border-red-500 @enderror"
                        placeholder="e.g., John Doe">
                    @error('artist')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location -->
            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location <span class="text-red-500">*</span></label>
                <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('location') border-red-500 @enderror"
                    placeholder="e.g., Jakarta Convention Center">
                @error('location')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_datetime" class="block text-sm font-semibold text-gray-700 mb-2">Start Date & Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="start_datetime" name="start_datetime" value="{{ old('start_datetime', $event->start_datetime->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('start_datetime') border-red-500 @enderror">
                    @error('start_datetime')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_datetime" class="block text-sm font-semibold text-gray-700 mb-2">End Date & Time <span class="text-red-500">*</span></label>
                    <input type="datetime-local" id="end_datetime" name="end_datetime" value="{{ old('end_datetime', $event->end_datetime->format('Y-m-d\TH:i')) }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('end_datetime') border-red-500 @enderror">
                    @error('end_datetime')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Event Image</label>
                
                @if($event->image_url)
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                    <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="w-32 h-32 object-cover rounded-lg">
                </div>
                @endif

                <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-purple-500 transition cursor-pointer" id="dropZone">
                    <div>
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                        <p class="text-gray-700 font-medium">Click to upload or drag and drop</p>
                        <p class="text-gray-500 text-sm">PNG, JPG, GIF up to 2MB (leave empty to keep current image)</p>
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
                    <input type="checkbox" id="is_published" name="is_published" value="1" @if($event->is_published) checked @endif class="w-4 h-4 text-purple-600 rounded">
                    <span class="ml-2 text-gray-700">Publish event</span>
                </label>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-4 pt-6 border-t">
                <a href="{{ route('admin.events.index') }}" class="flex-1 px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition text-center">
                    Cancel
                </a>
                <button type="submit" class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-lg font-medium hover:bg-purple-700 transition">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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
</script>
@endsection