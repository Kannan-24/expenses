<x-auth-layout>
    <x-slot name="title">
        {{ __('Create Account') }} - {{ config('app.name', 'Duo Dev Expenses') }}
    </x-slot>

    <!-- Enhanced Left Panel (Form) -->
    <div class="flex-1 flex flex-col justify-center px-6 sm:px-8 lg:px-16 py-8 lg:py-12 bg-white relative min-h-screen lg:min-h-0">
        
        <!-- Enhanced Top Navigation -->
        <div class="absolute top-4 sm:top-6 left-6 sm:left-8 lg:left-16 right-6 sm:right-8 lg:right-16 flex justify-between items-center z-10">
            <a href="{{ route('home') }}"
               class="inline-flex items-center space-x-2 text-gray-600 text-sm font-medium transition-all hover:text-blue-600 hover:-translate-x-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="hidden sm:inline">Back to Home</span>
                <span class="sm:hidden">Back</span>
            </a>
            
            <div class="text-right">
                <span class="text-gray-500 text-sm block">Already a member?</span>
                <a href="{{ route('login') }}" 
                   class="text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                    Sign In →
                </a>
            </div>
        </div>

        <!-- Session Status (for debugging) -->
        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Main Content Container -->
        <div class="w-full max-w-md mx-auto mt-16 lg:mt-8">
            
            <!-- Enhanced Header -->
            <div class="text-center lg:text-left mb-8">
                <!-- Brand Logo/Icon -->
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-blue-600 rounded-2xl mb-6 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Join Duo Dev Expenses</h1>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Create your account and start your journey to financial freedom today.
                </p>
                
                <!-- Social Proof -->
                <div class="mt-4 flex items-center justify-center lg:justify-start space-x-4 text-sm text-gray-500">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Free forever</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Secure & private</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Registration Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="registerForm()" @submit="handleSubmit">
                @csrf

                <!-- Debug Info (Remove in production) -->
                @if(app()->environment('local'))
                    <div class="text-xs text-gray-500 bg-gray-50 p-2 rounded">
                        Debug: Route = {{ route('register') }} | CSRF = {{ csrf_token() }}
                    </div>
                @endif

                <!-- Full Name Field -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-semibold text-gray-900">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}" 
                               autofocus
                               autocomplete="name"
                               placeholder="Enter your full name"
                               required
                               minlength="2"
                               x-model="name"
                               @input="validateName"
                               class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl transition-all duration-200 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder-gray-400">
                        
                        <!-- Name validation icon -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg x-show="nameValid" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-900">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               autocomplete="username"
                               placeholder="Enter your email address"
                               required
                               x-model="email"
                               @input="validateEmail"
                               class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl transition-all duration-200 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder-gray-400">
                        
                        <!-- Email validation icon -->
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg x-show="emailValid" class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-900">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               autocomplete="new-password"
                               placeholder="Create a strong password"
                               required
                               minlength="8"
                               x-model="password"
                               @input="validatePassword"
                               class="w-full px-4 py-4 pr-12 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl transition-all duration-200 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder-gray-400">
                        
                        <!-- Password toggle button -->
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div x-show="password.length > 0" class="space-y-2">
                        <div class="flex space-x-1">
                            <div class="h-2 flex-1 rounded-full transition-colors" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                            <div class="h-2 flex-1 rounded-full transition-colors" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                            <div class="h-2 flex-1 rounded-full transition-colors" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                        </div>
                        <p class="text-xs transition-colors" :class="getPasswordStrengthColor()">
                            <span x-text="getPasswordStrengthText()"></span>
                        </p>
                    </div>
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password Field -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-900">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               autocomplete="new-password"
                               placeholder="Confirm your password"
                               required
                               x-model="passwordConfirmation"
                               @input="validatePasswordMatch"
                               class="w-full px-4 py-4 pr-12 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl transition-all duration-200 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100 placeholder-gray-400"
                               :class="passwordConfirmation.length > 0 ? (passwordsMatch ? 'border-green-500 focus:border-green-500' : 'border-red-500 focus:border-red-500') : ''">
                        
                        <!-- Password toggle button -->
                        <button type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Password match indicator -->
                    <div x-show="passwordConfirmation.length > 0" class="transition-all">
                        <p x-show="passwordsMatch" class="text-xs text-green-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Passwords match
                        </p>
                        <p x-show="!passwordsMatch" class="text-xs text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Passwords don't match
                        </p>
                    </div>
                    
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Terms and Privacy Agreement -->
                <div class="space-y-3">
                    <label class="flex items-start space-x-3 cursor-pointer group">
                        <input type="checkbox" 
                               name="terms"
                               required
                               x-model="termsAccepted"
                               class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-colors mt-0.5">
                        <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors leading-relaxed">
                            I agree to the 
                            <a href="/terms-of-service" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium underline">Terms of Service</a>
                            and 
                            <a href="/privacy-policy" target="_blank" class="text-blue-600 hover:text-blue-700 font-medium underline">Privacy Policy</a>
                            <span class="text-red-500">*</span>
                        </span>
                    </label>
                    
                    <label class="flex items-start space-x-3 cursor-pointer group">
                        <input type="checkbox" 
                               name="newsletter"
                               x-model="newsletterOptIn"
                               class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-colors mt-0.5">
                        <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors leading-relaxed">
                            Send me helpful tips and product updates (optional)
                        </span>
                    </label>
                </div>

                <!-- Form Validation Status -->
                <div x-show="!canSubmit && (name.length > 0 || email.length > 0)" class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-red-700">
                            <p class="font-medium mb-1">Please complete the following:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li x-show="!nameValid">Enter a valid full name (minimum 2 characters)</li>
                                <li x-show="!emailValid">Enter a valid email address</li>
                                <li x-show="passwordStrength < 2">Create a stronger password</li>
                                <li x-show="!passwordsMatch && passwordConfirmation.length > 0">Make sure passwords match</li>
                                <li x-show="!termsAccepted">Accept the Terms of Service</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Submit Button -->
                <button type="submit" 
                        :disabled="!canSubmit || loading"
                        class="w-full bg-gradient-to-r from-green-500 to-blue-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-green-600 hover:to-blue-700 hover:shadow-xl hover:shadow-blue-500/25 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none group relative overflow-hidden">
                    
                    <!-- Button shine effect -->
                    <span class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                    
                    <!-- Button content -->
                    <span x-show="!loading" class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        <span>Create My Account</span>
                    </span>
                    
                    <span x-show="loading" class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Creating Account...</span>
                    </span>
                </button>
            </form>

            <!-- Enhanced Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500 font-medium">Or continue with</span>
                </div>
            </div>

            <!-- Enhanced Google Sign Up -->
            <div class="space-y-4">
                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center px-6 py-4 border-2 border-gray-200 rounded-xl bg-white text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 hover:shadow-lg group">
                    
                    <!-- Google Logo -->
                    <div class="w-6 h-6 mr-3">
                        <svg viewBox="0 0 24 24" class="w-full h-full">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                    </div>
                    
                    <span class="group-hover:text-gray-900 transition-colors">Continue with Google</span>
                </a>
            </div>

            <!-- Footer Information -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-center space-y-3">
                <p class="text-xs text-gray-500 leading-relaxed">
                    By creating an account, you agree to our terms and privacy policy. 
                    We'll never share your financial data with third parties.
                </p>
                
                <div class="flex items-center justify-center space-x-4 text-xs text-gray-400">
                    <div class="flex items-center space-x-1">
                        <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>256-bit SSL</span>
                    </div>
                    <span>•</span>
                    <div class="flex items-center space-x-1">
                        <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>GDPR Compliant</span>
                    </div>
                    <span>•</span>
                    <div class="flex items-center space-x-1">
                        <svg class="w-3 h-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        <span>No Ads Ever</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Right Panel (Illustration) -->
    <div class="flex-1 bg-gradient-to-br from-green-500 via-blue-600 to-purple-700 relative hidden lg:flex items-center justify-center overflow-hidden">
        <!-- Enhanced Background Effects -->
        <div class="absolute inset-0">
            <!-- Animated gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/80 via-blue-600/90 to-purple-700/80"></div>
            
            <!-- Floating geometric shapes -->
            <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-32 right-32 w-24 h-24 bg-white/5 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-10 w-16 h-16 bg-white/15 rounded-full blur-lg animate-pulse" style="animation-delay: 4s;"></div>
            
            <!-- Grid pattern overlay -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <!-- Enhanced Content -->
        <div class="relative z-10 w-full max-w-lg px-8">
            <!-- Main heading -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-white mb-4 leading-tight">
                    Start Your
                    <span class="block bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">
                        Financial Success
                    </span>
                </h1>
                <p class="text-xl text-green-100 leading-relaxed">
                    Join thousands who've transformed their money management with smart tracking and insights
                </p>
            </div>

            <!-- Enhanced floating cards container -->
            <div class="relative h-96">
                <!-- Expense Tracking Card -->
                <div class="absolute top-0 right-0 w-72 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 shadow-2xl animate-float" style="animation-delay: 0s;">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="text-sm opacity-80 mb-1">Monthly Budget</div>
                            <div class="text-3xl font-bold">₹25,000</div>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Mini spending categories -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="opacity-90">Spent this month</span>
                            <span class="font-semibold">₹18,470</span>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-400 to-blue-400 h-2 rounded-full" style="width: 74%"></div>
                        </div>
                        <div class="text-xs opacity-75">74% of budget used</div>
                    </div>
                </div>

                <!-- Security & Privacy Card -->
                <div class="absolute bottom-0 left-0 w-80 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 shadow-2xl animate-float" style="animation-delay: 1s;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Privacy First</h3>
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm opacity-90 leading-relaxed">
                        <p>Your financial data belongs to you. We use bank-level encryption to ensure only you can access your information.</p>
                        
                        <div class="flex items-center space-x-4 pt-2">
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-xs">256-bit SSL</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-xs">No data selling</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Smart Insights Card -->
                <div class="absolute top-20 left-20 w-64 bg-white/10 backdrop-blur-xl rounded-2xl p-5 text-white border border-white/20 shadow-xl animate-float" style="animation-delay: 2s;">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2">Smart Analytics</h4>
                        <p class="text-sm opacity-90 leading-relaxed">
                            Get AI-powered insights to optimize your spending and reach your financial goals faster
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature highlights -->
            <div class="absolute bottom-8 left-8 right-8">
                <div class="grid grid-cols-3 gap-4 text-white/80">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-400">10k+</div>
                        <div class="text-xs">Active Users</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-400">4.9★</div>
                        <div class="text-xs">User Rating</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-400">100%</div>
                        <div class="text-xs">Free Forever</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile Optimization -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-gradient-to-r from-green-500 to-blue-600 text-white p-4 z-20" x-data="{ dismissed: false }" x-show="!dismissed">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-semibold text-sm">Ready to take control?</div>
                <div class="text-xs opacity-90">Join 10,000+ users managing their money better</div>
            </div>
            <button @click="dismissed = true" class="text-white/80 hover:text-white transition-colors p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Enhanced Styles -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1deg); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Custom scrollbar for mobile */
        ::-webkit-scrollbar {
            width: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #10B981, #3B82F6);
            border-radius: 2px;
        }
        
        /* Enhanced focus states for accessibility */
        .focus-visible:focus {
            outline: 2px solid #3B82F6;
            outline-offset: 2px;
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        function registerForm() {
            return {
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                password: '',
                passwordConfirmation: '',
                showPassword: false,
                showConfirmPassword: false,
                loading: false,
                termsAccepted: false,
                newsletterOptIn: false,
                nameValid: false,
                emailValid: false,
                passwordStrength: 0,
                passwordsMatch: false,
                
                validateName() {
                    this.nameValid = this.name.trim().length >= 2;
                },
                
                validateEmail() {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    this.emailValid = emailPattern.test(this.email);
                },
                
                validatePassword() {
                    let strength = 0;
                    if (this.password.length >= 8) strength++;
                    if (/[A-Z]/.test(this.password)) strength++;
                    if (/[a-z]/.test(this.password)) strength++;
                    if (/[0-9]/.test(this.password)) strength++;
                    if (/[^A-Za-z0-9]/.test(this.password)) strength++;
                    
                    // Calculate strength out of 3
                    if (strength >= 5) this.passwordStrength = 3;
                    else if (strength >= 3) this.passwordStrength = 2;
                    else if (strength >= 1) this.passwordStrength = 1;
                    else this.passwordStrength = 0;
                    
                    this.validatePasswordMatch();
                },
                
                validatePasswordMatch() {
                    this.passwordsMatch = this.password === this.passwordConfirmation && this.passwordConfirmation.length > 0;
                },
                
                getPasswordStrengthText() {
                    const texts = ['', 'Weak password', 'Good password', 'Strong password'];
                    return texts[this.passwordStrength];
                },
                
                getPasswordStrengthColor() {
                    const colors = ['', 'text-red-600', 'text-yellow-600', 'text-green-600'];
                    return colors[this.passwordStrength];
                },
                
                get canSubmit() {
                    return this.nameValid && 
                           this.emailValid && 
                           this.passwordStrength >= 2 && 
                           this.passwordsMatch && 
                           this.termsAccepted;
                },
                
                handleSubmit(event) {
                    // Validate form before submission
                    if (!this.canSubmit) {
                        event.preventDefault();
                        alert('Please complete all required fields correctly.');
                        return false;
                    }
                    
                    this.loading = true;
                    
                    // Allow form to submit normally
                    return true;
                },
                
                init() {
                    this.validateName();
                    this.validateEmail();
                    
                    // Focus on name field if it's empty
                    if (!this.name) {
                        this.$nextTick(() => {
                            document.getElementById('name').focus();
                        });
                    }
                }
            }
        }

        // Enhanced form handling and debugging
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            
            // Enhanced form validation before submission
            form.addEventListener('submit', function(e) {
                const formData = new FormData(this);
                const data = Object.fromEntries(formData);
                
                console.log('Form submission attempt:', {
                    action: this.action,
                    method: this.method,
                    data: data,
                    timestamp: new Date().toISOString()
                });
                
                // Basic client-side validation
                const name = data.name?.trim();
                const email = data.email?.trim();
                const password = data.password;
                const passwordConfirmation = data.password_confirmation;
                const termsAccepted = data.terms;
                
                const errors = [];
                
                if (!name || name.length < 2) {
                    errors.push('Name must be at least 2 characters long');
                }
                
                if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    errors.push('Please enter a valid email address');
                }
                
                if (!password || password.length < 8) {
                    errors.push('Password must be at least 8 characters long');
                }
                
                if (password !== passwordConfirmation) {
                    errors.push('Passwords do not match');
                }
                
                if (!termsAccepted) {
                    errors.push('You must accept the Terms of Service');
                }
                
                if (errors.length > 0) {
                    e.preventDefault();
                    alert('Please fix the following errors:\n\n' + errors.join('\n'));
                    console.error('Form validation errors:', errors);
                    return false;
                }
                
                console.log('Form validation passed, submitting...');
            });

            // Enhanced keyboard navigation
            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach((input, index) => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && e.target.type !== 'submit') {
                        e.preventDefault();
                        const nextInput = inputs[index + 1];
                        
                        if (nextInput) {
                            nextInput.focus();
                        } else {
                            // Focus on submit button if it exists and is enabled
                            const submitButton = form.querySelector('button[type="submit"]');
                            if (submitButton && !submitButton.disabled) {
                                submitButton.focus();
                            }
                        }
                    }
                });
            });

            // Auto-hide mobile CTA after form interaction
            const formInputs = document.querySelectorAll('form input');
            const mobileCTA = document.querySelector('.lg\\:hidden.fixed.bottom-0');
            
            formInputs.forEach(input => {
                input.addEventListener('focus', () => {
                    if (mobileCTA && window.innerWidth < 1024) {
                        mobileCTA.style.transform = 'translateY(100%)';
                        mobileCTA.style.transition = 'transform 0.3s ease';
                    }
                });
            });

            // Handle registration errors
            @if ($errors->any())
                const errorMessages = @json($errors->all());
                console.error('Registration errors:', errorMessages);
                
                // Show errors in a user-friendly way
                setTimeout(() => {
                    let errorText = 'Registration failed. Please fix the following errors:\n\n';
                    errorMessages.forEach(message => {
                        errorText += '• ' + message + '\n';
                    });
                    alert(errorText);
                }, 100);
            @endif

            // Handle success messages
            @if (session('status'))
                const statusMessage = "{{ session('status') }}";
                console.log('Registration status:', statusMessage);
                setTimeout(() => {
                    alert(statusMessage);
                }, 100);
            @endif

            // Debugging information
            console.log('Registration page loaded at:', new Date().toISOString());
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'));
            console.log('Form action:', form?.getAttribute('action'));
            console.log('Current user login:', '{{ Auth::check() ? Auth::user()->email : "Guest" }}');
        });
    </script>
</x-auth-layout>