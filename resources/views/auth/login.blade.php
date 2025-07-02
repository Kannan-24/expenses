<x-auth-layout>
    <x-slot name="title">
        {{ __('Sign In') }} - {{ config('app.name', 'Duo Dev Expenses') }}
    </x-slot>
    
    <!-- Enhanced Left Panel (Illustration) -->
    <div class="flex-1 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 relative hidden lg:flex items-start justify-center overflow-hidden">
        <!-- Enhanced Background Effects -->
        <div class="absolute inset-0">
            <!-- Animated gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600/80 via-indigo-700/90 to-purple-800/80"></div>
            
            <!-- Floating geometric shapes -->
            <div class="absolute top-20 left-20 w-32 h-32 bg-white/10 rounded-full blur-xl animate-pulse"></div>
            <div class="absolute bottom-32 right-32 w-24 h-24 bg-white/5 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-10 w-16 h-16 bg-white/15 rounded-full blur-lg animate-pulse" style="animation-delay: 4s;"></div>
            
            <!-- Grid pattern overlay -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <!-- Enhanced Content -->
        <div class="relative z-10 w-full max-w-lg px-8 pt-10 pb-16 h-[calc(100vh - 2rem)]">
            <!-- Main heading -->
            <div class="text-center mb-10">
                <h1 class="text-5xl font-bold text-white mb-4 leading-tight">
                    Welcome to Your
                    <span class="block bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">
                        Financial Journey
                    </span>
                </h1>
                <p class="text-xl text-blue-100 leading-relaxed">
                    Take control of your money with powerful insights and smart tracking
                </p>
            </div>

            <!-- Enhanced floating cards container -->
            <div class="relative h-96">
                <!-- Balance Card -->
                <div class="absolute -top-5 right-0 w-72 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 shadow-2xl animate-float" style="animation-delay: 0s;">

                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="text-sm opacity-80 mb-1">Total Balance</div>
                            <div class="text-3xl font-bold">₹1,24,856</div>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Mini chart -->
                    <div class="h-12 bg-white/10 rounded-lg relative overflow-hidden flex items-end justify-center space-x-1 p-2">
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 20%; animation-delay: 0.1s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 40%; animation-delay: 0.2s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 70%; animation-delay: 0.3s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 90%; animation-delay: 0.4s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 60%; animation-delay: 0.5s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 100%; animation-delay: 0.6s;"></div>
                        <div class="w-2 bg-gradient-to-t from-green-500 to-emerald-400 rounded-sm animate-grow-bar" style="height: 80%; animation-delay: 0.7s;"></div>
                    </div>
                    
                    <div class="mt-3 text-sm opacity-90 flex items-center">
                        <span class="text-green-400 font-semibold mr-2">+12.5%</span>
                        vs last month
                    </div>
                </div>

                <!-- Expense Categories Card -->
                <div class="absolute bottom-2 left-0 w-80 bg-white/15 backdrop-blur-xl rounded-3xl p-6 text-white border border-white/20 shadow-2xl animate-float" style="animation-delay: 1s;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Recent Expenses</h3>
                        <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                                    <span class="text-red-400 text-xs font-bold">🛒</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">Groceries</div>
                                    <div class="text-xs opacity-70">Today</div>
                                </div>
                            </div>
                            <div class="text-sm font-semibold">-₹1,275</div>
                        </div>
                        
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-400 text-xs font-bold">⛽</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium">Fuel</div>
                                    <div class="text-xs opacity-70">Yesterday</div>
                                </div>
                            </div>
                            <div class="text-sm font-semibold">-₹652</div>
                        </div>
                    </div>
                </div>

                <!-- Welcome Message Card -->
                <div class="absolute top-10 left-0 w-64 bg-white/10 backdrop-blur-xl rounded-2xl p-5 text-white border border-white/20 shadow-xl animate-float" style="animation-delay: 2s;">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2">Smart Insights</h4>
                        <p class="text-sm opacity-90 leading-relaxed">
                            Get personalized recommendations to improve your financial health
                        </p>
                    </div>
                </div>
            </div>

            <!-- Feature highlights -->
            <div class="absolute bottom-1 left-8 right-8">
                <div class="flex items-center justify-center space-x-8 text-white/80">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-sm font-medium">Bank-level Security</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span class="text-sm font-medium">Real-time Sync</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="text-sm font-medium">Smart Analytics</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Right Panel (Form) -->
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
                <span class="text-gray-500 text-sm block">New here?</span>
                <a href="{{ route('register') }}" 
                   class="text-blue-600 font-semibold text-sm hover:text-blue-700 transition-colors">
                    Create Account →
                </a>
            </div>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Main Content Container -->
        <div class="w-full max-w-md mx-auto mt-16 lg:mt-8">
            
            <!-- Enhanced Header -->
            <div class="text-center lg:text-left mb-8">
                <!-- Brand Logo/Icon -->
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6 shadow-lg">
                    <x-application-logo class="w-10 h-10 text-white" />
                </div>
                
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-3">Welcome Back!</h1>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Sign in to continue your financial journey and track your progress.
                </p>
            </div>

            <!-- Enhanced Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="loginForm()" @submit="handleSubmit">
                @csrf

                <!-- Email Field -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-semibold text-gray-900">
                        Email Address
                    </label>
                    <div class="relative">
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               autofocus
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
                        Password
                    </label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" 
                               name="password" 
                               id="password" 
                               autocomplete="current-password"
                               placeholder="Enter your password"
                               required
                               x-model="password"
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
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <input type="checkbox" 
                               name="remember"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-colors">
                        <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors">
                            Remember me
                        </span>
                    </label>
                    
                    <a href="{{ route('password.request') }}" 
                       class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Enhanced Submit Button -->
                <button type="submit" 
                        :disabled="loading"
                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 hover:from-blue-700 hover:to-purple-700 hover:shadow-xl hover:shadow-blue-500/25 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-200 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none group relative overflow-hidden">
                    
                    <!-- Button shine effect -->
                    <span class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-all duration-500 group-hover:left-full"></span>
                    
                    <!-- Button content -->
                    <span x-show="!loading" class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Sign In to Account</span>
                    </span>
                    
                    <span x-show="loading" class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Signing In...</span>
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

            <!-- Enhanced Google Sign In -->
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

            <!-- Footer Links -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-center space-y-3">
                <p class="text-sm text-gray-600">
                    By signing in, you agree to our 
                    <a href="/terms-of-service" class="text-blue-600 hover:text-blue-700 font-medium">Terms of Service</a>
                    and 
                    <a href="/privacy-policy" class="text-blue-600 hover:text-blue-700 font-medium">Privacy Policy</a>
                </p>
                
                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                    <a href="/help" class="hover:text-gray-700 transition-colors">Help Center</a>
                    <span>•</span>
                    <a href="/contact" class="hover:text-gray-700 transition-colors">Contact Support</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Mobile Optimization -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 z-20" x-data="{ dismissed: false }" x-show="!dismissed">
        <div class="flex items-center justify-between">
            <div>
                <div class="font-semibold text-sm">New to Duo Dev Expenses?</div>
                <div class="text-xs opacity-90">Join thousands managing their finances</div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('register') }}" 
                   class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-100 transition-colors">
                    Sign Up Free
                </a>
                <button @click="dismissed = true" class="text-white/80 hover:text-white p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Styles -->
    <style>
        @keyframes float {
            0%, 100%{ transform: translateY(0px) rotate(1deg); }
            50% { transform: translateY(0px) rotate(-1deg); }
        }
        
        @keyframes grow-bar {
            0% { height: 0%; }
            100% { height: var(--height); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-grow-bar {
            animation: grow-bar 2s ease-out forwards;
        }
        
        /* Custom scrollbar for mobile */
        ::-webkit-scrollbar {
            width: 4px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
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
        function loginForm() {
            return {
                email: '{{ old('email') }}',
                password: '',
                showPassword: false,
                loading: false,
                emailValid: false,
                
                validateEmail() {
                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    this.emailValid = emailPattern.test(this.email);
                },
                
                handleSubmit(event) {
                    this.loading = true;
                    
                    // Add a small delay to show loading state
                    setTimeout(() => {
                        // The form will submit normally
                    }, 100);
                },
                
                init() {
                    this.validateEmail();
                    
                    // Focus on email field if it's empty
                    if (!this.email) {
                        document.getElementById('email').focus();
                    }
                }
            }
        }

        // Enhanced form handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            // Validate form before submission
            form.addEventListener('submit', function(e) {
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();
                
                // Basic client-side validation
                if (!email || !password) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                    return false;
                }
                
                // Email validation
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address.');
                    emailInput.focus();
                    return false;
                }
                
                // Password validation (minimum length)
                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long.');
                    passwordInput.focus();
                    return false;
                }
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
                
                input.addEventListener('blur', () => {
                    if (mobileCTA && window.innerWidth < 1024) {
                        setTimeout(() => {
                            mobileCTA.style.transform = 'translateY(0)';
                        }, 500);
                    }
                });
            });

            // Enhanced keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.tagName === 'INPUT') {
                    const currentInput = e.target;
                    const form = currentInput.closest('form');
                    
                    if (form) {
                        const inputs = Array.from(form.querySelectorAll('input[type="email"], input[type="password"]'));
                        const currentIndex = inputs.indexOf(currentInput);
                        const nextInput = inputs[currentIndex + 1];
                        
                        if (nextInput) {
                            e.preventDefault();
                            nextInput.focus();
                        } else {
                            // Submit the form if this is the last input
                            form.submit();
                        }
                    }
                }
            });

            // Handle authentication errors
            @if ($errors->any())
                const errorMessages = @json($errors->all());
                let errorText = 'Please fix the following errors:\n';
                errorMessages.forEach(message => {
                    errorText += '• ' + message + '\n';
                });
                
                setTimeout(() => {
                    console.log('Authentication errors:', errorMessages);
                }, 100);
            @endif

            // Handle success messages
            @if (session('status'))
                setTimeout(() => {
                    const message = "{{ session('status') }}";
                    console.log('Status:', message);
                }, 100);
            @endif
        });
    </script>
</x-auth-layout>