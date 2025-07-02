<x-app-layout>
    <x-slot name="title">
        {{ __('Secure Access Verification') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen flex items-center justify-center ">
        
        <!-- Enhanced Container -->
        <div class="w-full max-w-7xl">
            
            <!-- Enhanced Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 via-blue-700 to-purple-800 rounded-t-3xl p-8 text-white relative overflow-hidden">
                <!-- Background Decorations -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full transform translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-5 rounded-full transform -translate-x-12 translate-y-12"></div>
                
                <div class="relative text-center">
                    <!-- Security Icon -->
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full mb-6 border border-white border-opacity-30">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4">Security Verification</h1>
                    <p class="text-xl text-blue-100 max-w-lg mx-auto">
                        Please confirm your password to access this secure area
                    </p>
                    
                    <!-- User Info -->
                    <div class="mt-6 inline-flex items-center bg-white bg-opacity-15 backdrop-blur-sm rounded-full px-6 py-3 border border-white border-opacity-20">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="text-left">
                            <p class="text-white font-semibold text-sm">{{ auth()->user()->name }}</p>
                            <p class="text-blue-200 text-xs">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Form Card -->
            <div class="bg-white rounded-b-3xl shadow-2xl p-8 lg:p-12 border-t-0">
                
                <!-- Security Notice -->
                <div class="bg-amber-50 border-l-4 border-amber-400 rounded-lg p-6 mb-8">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-amber-500 mt-0.5 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <div>
                            <h4 class="font-bold text-amber-900 mb-2">Secure Area Access</h4>
                            <p class="text-amber-800 text-sm font-medium">
                                This section contains sensitive information. For your security, please re-enter your password to continue.
                            </p>
                            <div class="mt-3 text-xs text-amber-700">
                                <p>• Your session remains secure throughout this process</p>
                                <p>• Password verification expires after inactivity</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Form -->
                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-8" x-data="passwordConfirm()">
                    @csrf

                    <!-- Password Field -->
                    <div class="space-y-3">
                        <label for="password" class="flex items-center text-sm font-bold text-gray-900">
                            <svg class="w-5 h-5 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.83 1M9 7a2 2 0 012-2m0 0a2 2 0 012-2 6 6 0 011.83 3M9 7h4m-4 0a2 2 0 00-2 2M9 7h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2M9 15v-4m4 4v-4"></path>
                            </svg>
                            Current Password
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        
                        <div class="relative">
                            <input id="password" 
                                   name="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter your current password"
                                   x-model="password"
                                   class="w-full px-4 py-4 pr-12 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-indigo-200 focus:border-indigo-600 transition-all duration-200 text-gray-900 font-medium text-lg shadow-sm"
                                   @input="clearErrors">
                            
                            <!-- Password Visibility Toggle -->
                            <button type="button" 
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-gray-700 transition-colors">
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
                            <div class="flex items-center space-x-2 text-red-700 bg-red-50 border border-red-200 rounded-lg p-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold text-sm">{{ $errors->first('password') }}</span>
                            </div>
                        @endif
                    </div>

                    

                    <!-- Enhanced Submit Button -->
                    <div class="space-y-4">
                        <button type="submit" 
                                :disabled="!password || isSubmitting"
                                :class="(!password || isSubmitting) ? 'bg-gray-400 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                class="w-full py-4 px-6 text-white font-bold text-lg rounded-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:transform-none disabled:shadow-none"
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
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                            <a href="{{ route('password.request') }}" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-11.83 1M9 7a2 2 0 012-2m0 0a2 2 0 012-2 6 6 0 011.83 3M9 7h4m-4 0a2 2 0 00-2 2M9 7h4m-4 0v8a2 2 0 002 2h4a2 2 0 002-2M9 15v-4m4 4v-4"></path>
                                </svg>
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Footer -->
            <div class="mt-6 text-center">
                <div class="inline-flex items-center bg-white rounded-full px-6 py-3 shadow-lg border border-gray-200">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Secured by 256-bit SSL encryption</span>
                </div>
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
                    const errorElements = document.querySelectorAll('.text-red-700');
                    errorElements.forEach(element => {
                        if (element.closest('.bg-red-50')) {
                            element.closest('.bg-red-50').style.display = 'none';
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
        });

        // Handle keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Enter key to submit form
            if (e.key === 'Enter' && e.target.id === 'password') {
                e.target.closest('form').submit();
            }
            
            // Escape key to go back
            if (e.key === 'Escape') {
                window.location.href = "{{ route('dashboard') }}";
            }
        });
    </script>
</x-app-layout>