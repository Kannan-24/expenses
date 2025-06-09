<x-guest-layout>

    <x-slot name="title">
        {{ __('Confirm Password') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="max-w-md p-8 mx-auto mt-6 bg-white shadow-xl sm:rounded-lg">
        <div class="mb-8 text-center">
            <h3 class="text-3xl font-bold text-gray-800">{{ __('Confirm Your Password') }}</h3>
            <p class="mt-2 text-sm text-gray-500">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <!-- Password -->
            <div>
                <label for="password" class="block mb-2 text-sm text-gray-800">{{ __('Password') }}</label>
                <div class="relative flex items-center">
                    <input id="password" name="password" type="password" required
                        class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <!-- Submit Button -->
            <div class="!mt-8">
                <button type="submit"
                    class="w-full py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
