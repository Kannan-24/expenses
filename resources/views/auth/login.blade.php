<x-guest-layout>
    <x-slot name="title">
        {{ __('Login') }} - {{ config('app.name', 'Expense Manager') }}
    </x-slot>

    <div class="flex items-center justify-center min-h-screen px-6">
        <div class="grid w-full max-w-6xl overflow-hidden bg-white rounded-lg shadow-lg ">
            <!-- Right Section: Login Form -->
            <div class="max-w-md p-8 mx-auto">
                <div class="mb-8 ">
                    <h3 class="text-3xl font-bold text-gray-800">Welcome Back</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Log in to manage your expenses, track spending, and view your financial records.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Email</label>
                        <div class="relative flex items-center">
                            <input id="email" name="email" type="email" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your email" value="{{ old('email') }}" autofocus
                                autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="relative mt-4" x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                        <input
                            class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                            id="password" x-bind:type="show ? 'text' : 'password'" name="password" required="required"
                            autocomplete="current-password" placeholder="Enter your password">
                        <span class="absolute w-5 h-5" id="password-toggle" @click="show = !show"
                            style="top: 50%; right: 15px;">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                :class="{ 'hidden': show }">
                                <path
                                    d="M3 14C3 9.02944 7.02944 5 12 5C16.9706 5 21 9.02944 21 14M17 14C17 16.7614 14.7614 19 12 19C9.23858 19 7 16.7614 7 14C7 11.2386 9.23858 9 12 9C14.7614 9 17 11.2386 17 14Z"
                                    stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                :class="{ 'hidden': !show }">
                                <path
                                    d="M9.60997 9.60714C8.05503 10.4549 7 12.1043 7 14C7 16.7614 9.23858 19 12 19C13.8966 19 15.5466 17.944 16.3941 16.3878M21 14C21 9.02944 16.9706 5 12 5C11.5582 5 11.1238 5.03184 10.699 5.09334M3 14C3 11.0069 4.46104 8.35513 6.70883 6.71886M3 3L21 21"
                                    stroke="#959595" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded shrink-0 focus:ring-blue-500"
                                name="remember">
                            <label for="remember_me" class="block ml-3 text-sm text-gray-800">Remember me</label>
                        </div>

                        <div class="text-sm">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="font-semibold text-blue-600 hover:underline">
                                    Forgot your password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="!mt-8">
                        <button type="submit"
                            class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('google.login') }}" class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48"><g><path fill="#4285F4" d="M44.5 20H24v8.5h11.7C34.7 32.9 30.1 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.5 6.5 29.6 4.5 24 4.5 12.7 4.5 3.5 13.7 3.5 25S12.7 45.5 24 45.5c10.5 0 19.5-8.5 19.5-19.5 0-1.3-.1-2.7-.3-4z"/><path fill="#34A853" d="M6.3 14.7l7 5.1C15.5 16.2 19.4 13.5 24 13.5c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.5 6.5 29.6 4.5 24 4.5c-7.2 0-13.3 4.1-16.7 10.2z"/><path fill="#FBBC05" d="M24 45.5c5.6 0 10.5-1.9 14.4-5.2l-6.6-5.4c-2.1 1.4-4.8 2.1-7.8 2.1-6.1 0-11.2-4.1-13-9.6l-7 5.4C7.1 41.1 14.9 45.5 24 45.5z"/><path fill="#EA4335" d="M44.5 20H24v8.5h11.7c-1.1 3.1-4.1 5.5-7.7 5.5-4.6 0-8.4-3.8-8.4-8.5s3.8-8.5 8.4-8.5c2.6 0 4.9 1.1 6.5 2.8l6.4-6.4C34.5 6.5 29.6 4.5 24 4.5c-7.2 0-13.3 4.1-16.7 10.2l7 5.1C15.5 16.2 19.4 13.5 24 13.5c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.5 6.5 29.6 4.5 24 4.5c-7.2 0-13.3 4.1-16.7 10.2z"/></g></svg>
                        Login with Google
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
