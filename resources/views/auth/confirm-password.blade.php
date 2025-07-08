<x-app-layout>
    <x-slot name="title">
        {{ __('Secure Access Verification') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 ">
        
        <!-- Enhanced Container -->
        <div class="w-full max-w-7xl">
            
            <!-- Enhanced Header Card -->
            <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-t-3xl p-8 text-white relative overflow-hidden">
                <!-- Background Decorations -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 dark:opacity-20 rounded-full transform translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 dark:opacity-10 rounded-full transform -translate-x-12 translate-y-12"></div>
                
                <div class="relative text-center">
                    <!-- Security Icon -->
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 backdrop-blur-sm rounded-full mb-6 border border-white border-opacity-30 dark:border-opacity-50">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Security Verification</h1>
                    <p class="text-xl text-blue-100 dark:text-blue-200 max-w-lg mx-auto">
                        Please confirm your password to access this secure area
                    </p>
                    
                    <!-- Session Info -->
                    <div class="mt-6 inline-flex items-center bg-white bg-opacity-15 dark:bg-white dark:bg-opacity-25 backdrop-blur-sm rounded-full px-6 py-3 border border-white border-opacity-20 dark:border-opacity-30">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-600 dark:from-blue-500 dark:to-purple-700 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="text-left">
                            <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-blue-200 dark:text-blue-300 text-xs">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Card -->
            <div class="bg-white dark:bg-gray-900 rounded-b-3xl shadow-2xl p-8 lg:p-12 border-t-0">  

                <!-- Enhanced Form -->
                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8" x-data="passwordConfirm()">
                    @csrf

                    <!-- Password Field -->
                    <div class="space-y-3">
                        <label for="password" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                            <svg class="w-5 h-5 mr-3 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.83 1M9 7a2 2 0 012-2m0 0a2 2 0 012-2 6 6 0 011.83 3M9 7h4m-4 0a2 2 0 00-2 2M9 7h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2M9 15v-4m4 4v-4"></path>
                            </svg>
                            Current Password
                            <span class="text-red-500 dark:text-red-400 ml-1">*</span>
                        </label>
                        
                        <div class="relative">
                            <input id="password" 
                                   name="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter your current password"
                                   x-model="password"
                                   class="w-full px-4 py-4 pr-12 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-600 dark:focus:border-indigo-400 transition-all duration-200 text-gray-900 dark:text-white font-medium text-lg shadow-sm bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400"
                                   @input="clearErrors">
                            
                            <!-- Password Visibility Toggle -->
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Enhanced Error Display -->
                        @if($errors->has('password'))
                            <div class="flex items-center space-x-2 text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-sm">{{ $errors->first('password') }}</span>
                            </div>
                        @endif

                        <!-- Password Strength Hint -->
                        <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-3">
                            <div class="flex items-start space-x-2">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="text-xs text-blue-700 dark:text-blue-300">
                                    <p class="font-medium">Security Tip:</p>
                                    <p>Enter the same password you use to log into your account.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Submit Button -->
                    <div class="space-y-4">
                        <button type="submit" 
                                :disabled="!password || isSubmitting"
                                :class="(!password || isSubmitting) ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-purple-700 dark:from-indigo-500 dark:to-purple-600 hover:from-indigo-700 hover:to-purple-800 dark:hover:from-indigo-600 dark:hover:to-purple-700 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                class="w-full py-4 px-6 text-white font-bold text-lg rounded-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-800 disabled:transform-none disabled:shadow-none"
                                @click="isSubmitting = true">
                            <span x-show="!isSubmitting" class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Confirm & Continue
                            </span>
                            <span x-show="isSubmitting" class="flex items-center justify-center">
                                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Verifying...
                            </span>
                        </button>

                        <!-- Alternative Actions -->
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 text-center">
                            <a href="{{ route('dashboard') }}" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 text-gray-600 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                            <a href="{{ route('password.request') }}" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.83 1M9 7a2 2 0 012-2m0 0a2 2 0 012-2 6 6 0 011.83 3M9 7h4m-4 0a2 2 0 00-2 2M9 7h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2M9 15v-4m4 4v-4"></path>
                                </svg>
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                </form>

            </div>

           
        </div>
    </div>

    <script>
        function passwordConfirm() {
            return {
                password: '',
                showPassword: false,
                isSubmitting: false,
                
                clearErrors() {
                    // Clear any existing error messages
                    const errorElements = document.querySelectorAll('.text-red-700, .dark\\:text-red-400');
                    errorElements.forEach(element => {
                        if (element.closest('.bg-red-50') || element.closest('.dark\\:bg-red-900')) {
                            element.closest('.bg-red-50, .dark\\:bg-red-900').style.display = 'none';
                        }
                    });
                }
            }
        }

        // Auto-focus password field
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            if (passwordField) {
                passwordField.focus();
            }
            
            console.log('Password confirmation page loaded');
            console.log('User: harithelord47');
            console.log('Session: Jul 07, 2025 at 16:01:06 UTC');
        });

        // Handle keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Enter key to submit form
            if (e.key === 'Enter' && e.target.id === 'password') {
                const form = e.target.closest('form');
                if (form && e.target.value.trim()) {
                    form.submit();
                }
            }
            
            // Escape key to go back
            if (e.key === 'Escape') {
                window.location.href = "{{ route('dashboard') }}";
            }
        });

        // Security monitoring
        let attemptCount = 0;
        const maxAttempts = 3;

        document.querySelector('form').addEventListener('submit', function(e) {
            attemptCount++;
            
            if (attemptCount >= maxAttempts) {
                console.warn('Multiple password confirmation attempts detected');
                // In a real app, you might want to implement additional security measures
            }
        });

        // Session timeout warning
        let sessionTimer;
        function resetSessionTimer() {
            clearTimeout(sessionTimer);
            sessionTimer = setTimeout(() => {
                alert('Your session will expire soon. Please complete the verification or return to the dashboard.');
            }, 10 * 60 * 1000); // 10 minutes
        }

        // Reset timer on user activity
        ['click', 'keypress', 'mousemove'].forEach(event => {
            document.addEventListener(event, resetSessionTimer);
        });

        resetSessionTimer();
    </script>
</x-app-layout>