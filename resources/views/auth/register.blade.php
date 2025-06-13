<x-guest-layout>
    <x-slot name="title">
        {{ __('Register') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="flex items-center justify-center min-h-screen px-6">
        <div class="grid w-full max-w-6xl overflow-hidden bg-white rounded-lg shadow-lg">
            <div class="max-w-md p-8 mx-auto">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-gray-800">Create an Account</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Register to manage your expenses, track spending, and view financial reports.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Full Name</label>
                        <div class="relative flex items-center">
                            <input id="name" name="name" type="text" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your full name" value="{{ old('name') }}" autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Email</label>
                        <div class="relative flex items-center">
                            <input id="email" name="email" type="email" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your email" value="{{ old('email') }}" autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Password</label>
                        <div class="relative flex items-center">
                            <input id="password" name="password" type="password" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Confirm Password</label>
                        <div class="relative flex items-center">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Confirm password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Already registered link -->
                    <div class="flex items-center justify-between">
                        <a class="text-sm text-gray-600 transition hover:text-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                            class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            {{ __('Sign Up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
