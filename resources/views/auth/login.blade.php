<x-guest-layout>
    <x-slot name="title">
        {{ __('Login') }} - {{ config('app.name', 'Expense Manager') }}
    </x-slot>

    <div class="flex items-center justify-center min-h-screen px-6">
        <div class="grid w-full max-w-6xl overflow-hidden bg-white rounded-lg shadow-lg">
            <!-- Right Section: Login Form -->
            <div class="max-w-md p-8 mx-auto">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-gray-800">Welcome Back</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Log in to manage your expenses, track spending, and view your financial records.
                    </p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Email</label>
                        <input id="email" name="email" type="email" required
                            class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                            placeholder="Enter your email" value="{{ old('email') }}" autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative mt-4" x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                        <input
                            class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                            id="password" x-bind:type="show ? 'text' : 'password'" name="password" required
                            autocomplete="current-password" placeholder="Enter your password">
                        <span class="absolute w-5 h-5" id="password-toggle" @click="show = !show"
                            style="top: 50%; right: 15px;">
                            <!-- eye icon toggle -->
                        </span>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <label class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-800">Remember me</span>
                        </label>

                        <div class="text-sm">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Sign In Button -->
                    <div class="!mt-8">
                        <button type="submit"
                            class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            Sign in
                        </button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 text-gray-500 bg-white">OR</span>
                    </div>
                </div>

                <!-- Google Login Button -->
                <div class="text-center">
                    <div class="text-center">
                        <a href="{{ route('google.login') }}"
                            class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-full bg-white text-sm font-medium text-gray-700 hover:bg-gray-100 transition duration-150">
                            <span class="w-5 h-5 mr-3 inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 100">
                                    <path fill="#4285F4" d="M95.833 51.021c0-3.77-.312-6.52-.983-9.375H50.933V58.66h25.775c-.516 4.225-3.32 10.592-9.558 14.87l-.088.567 13.884 10.542.958.092c8.842-7.992 13.93-19.759 13.93-33.709"/>
                                    <path fill="#34A853" d="M50.938 95.833c12.625 0 23.225-4.076 30.97-11.105l-14.758-11.2c-3.95 2.7-9.25 4.584-16.212 4.584a28.1 28.1 0 0 1-26.609-19.05l-.55.046-14.437 10.95-.188.516c7.692 14.971 23.492 25.258 41.784 25.258"/>
                                    <path fill="#FBBC05" d="M24.333 59.062a27.7 27.7 0 0 1-1.57-9.063c0-3.158.574-6.212 1.504-9.062l-.025-.613L9.625 29.2l-.48.225A45.1 45.1 0 0 0 4.168 50c0 7.384 1.816 14.363 4.987 20.575z"/>
                                    <path fill="#EB4335" d="M50.938 21.888c8.783 0 14.704 3.716 18.083 6.824l13.196-12.629C74.113 8.7 63.563 4.167 50.937 4.167c-18.295 0-34.091 10.287-41.783 25.258L24.28 40.938a28.21 28.21 0 0 1 26.659-19.05"/>
                                </svg>
                            </span>
                            Sign in with Google
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
