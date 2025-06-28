<x-guest-layout>
    <x-slot name="title">
        {{ __('Register') }} - {{ config('app.name', 'expenses') }}
    </x-slot>
    <div class="flex flex-col items-center min-h-screen pt-20 pb-2 bg-blue-200 sm:justify-center">
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
                                    placeholder="Enter your email" value="{{ old('email') }}"
                                    autocomplete="username" />
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
                            <a class="text-sm text-gray-600 transition hover:text-indigo-500"
                                href="{{ route('login') }}">
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

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 text-gray-500 bg-white">OR</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-center">
                            <a href="{{ route('google.login') }}"
                                class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-full bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 transition duration-150">
                                <span class="w-5 h-5 mr-3 inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100">
                                        <path fill="#4285F4"
                                            d="M95.833 51.021c0-3.77-.312-6.52-.983-9.375H50.933V58.66h25.775c-.516 4.225-3.32 10.592-9.558 14.87l-.088.567 13.884 10.542.958.092c8.842-7.992 13.93-19.759 13.93-33.709" />
                                        <path fill="#34A853"
                                            d="M50.938 95.833c12.625 0 23.225-4.076 30.97-11.105l-14.758-11.2c-3.95 2.7-9.25 4.584-16.212 4.584a28.1 28.1 0 0 1-26.609-19.05l-.55.046-14.437 10.95-.188.516c7.692 14.971 23.492 25.258 41.784 25.258" />
                                        <path fill="#FBBC05"
                                            d="M24.333 59.062a27.7 27.7 0 0 1-1.57-9.063c0-3.158.574-6.212 1.504-9.062l-.025-.613L9.625 29.2l-.48.225A45.1 45.1 0 0 0 4.168 50c0 7.384 1.816 14.363 4.987 20.575z" />
                                        <path fill="#EB4335"
                                            d="M50.938 21.888c8.783 0 14.704 3.716 18.083 6.824l13.196-12.629C74.113 8.7 63.563 4.167 50.937 4.167c-18.295 0-34.091 10.287-41.783 25.258L24.28 40.938a28.21 28.21 0 0 1 26.659-19.05" />
                                    </svg>
                                </span>
                                Sign in with Google
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
