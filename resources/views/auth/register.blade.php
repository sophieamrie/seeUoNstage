<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full"
                          type="text" name="name"
                          :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-6">
            <x-input-label for="role" :value="__('Register as')" />

            <div class="mt-2 space-y-2">

                <!-- User -->
                <label class="flex items-center">
                    <input type="radio" name="role" value="user"
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                           {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                    <span class="ml-3 text-gray-700">User (Regular Account)</span>
                </label>

                <!-- Organizer -->
                <label class="flex items-center">
                    <input type="radio" name="role" value="organizer"
                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500"
                           {{ old('role') === 'organizer' ? 'checked' : '' }}>
                    <span class="ml-3 text-gray-700">Organizer (Event Creator)</span>
                </label>

            </div>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />

            <!-- Auto Hint -->
            <div id="organizer-hint"
                 class="hidden mt-3 text-sm text-yellow-600 bg-yellow-100 border border-yellow-300 rounded p-3">
                As an Organizer, your account must be reviewed and approved by an Administrator before you can access the Organizer Dashboard.
            </div>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Script for hint -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleInputs = document.querySelectorAll('input[name="role"]');
            const hint = document.getElementById('organizer-hint');

            function updateHint() {
                const selected = document.querySelector('input[name="role"]:checked')?.value;
                hint.classList.toggle('hidden', selected !== 'organizer');
            }

            roleInputs.forEach(input => input.addEventListener('change', updateHint));
            updateHint();
        });
    </script>
</x-guest-layout>
