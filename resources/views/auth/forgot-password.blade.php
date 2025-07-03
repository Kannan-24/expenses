<x-auth-layout>
    <x-slot name="title">
        {{ __('Forgot Password') }} - {{ config('app.name', 'Duo Dev expenses') }}
    </x-slot>

    <div class="w-full min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4 sm:py-6">
                    <div class="flex items-center">
                        <!-- Brand Logo/Icon -->
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-2xl shadow-lg">
                            <x-application-logo class="w-10 h-10 text-white" />
                        </div>
                        <span class="ml-3 text-lg sm:text-xl font-bold text-gray-900">{{ config('app.name', 'Duo Dev Expenses') }}</span>
                    </div>
                    <a href="{{ route('login') }}" class="text-sm sm:text-base text-blue-600 hover:text-blue-500 font-medium transition-colors">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="w-full max-w-lg">
                <!-- Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 sm:px-8 py-6 sm:py-8">
                        <div class="text-center">
                            <div class="mx-auto w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">
                                Reset Password
                            </h1>
                            <p class="text-blue-100 text-sm sm:text-base">
                                Enter your email to receive reset instructions
                            </p>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="px-6 sm:px-8 py-6 sm:py-8">
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                            @csrf

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        required
                                        autocomplete="username"
                                        autofocus
                                        value="{{ old('email') }}"
                                        class="w-full px-4 py-3 sm:py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm sm:text-base @error('email') border-red-500 @enderror"
                                        placeholder="your@company.com"
                                    />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 sm:py-4 px-4 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:translate-y-[-1px] hover:shadow-lg text-sm sm:text-base"
                            >
                                Send Reset Instructions
                            </button>
                        </form>

                        <!-- Additional Info -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="text-center space-y-3">
                                <p class="text-sm text-gray-600">
                                    <svg class="inline w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Check your spam folder if you don't see the email
                                </p>
                                <div class="flex items-center justify-center space-x-4 text-sm">
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 font-medium transition-colors">
                                        ← Back to Login
                                    </a>
                                    <span class="text-gray-300">|</span>
                                    <a href="mailto:support@duodev.in" class="text-gray-600 hover:text-gray-500 transition-colors">
                                        Need Help?
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 text-center">
                    <p class="text-xs sm:text-sm text-gray-500 max-w-md mx-auto">
                        For security reasons, we'll only send reset instructions to registered email addresses. 
                        The reset link will expire in 60 minutes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>