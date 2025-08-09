<x-guest-layout>
    <x-slot name="title">
        Cazhoo - Professional Personal Finance Management | Track, Manage & Save Money
    </x-slot>

    <!-- Enhanced Hero Section -->
    <section id="home"
        class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400 to-purple-500 opacity-10 rounded-full blur-3xl animate-pulse">
            </div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-indigo-400 to-cyan-400 opacity-10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-bl from-purple-400 to-pink-400 opacity-5 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                <!-- Enhanced Left Content -->
                <div class="text-center lg:text-left space-y-8">
                    <!-- Badge -->
                    <div
                        class="inline-flex items-center px-4 py-2 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-gray-200">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm font-semibold text-gray-700">Trusted by 500+ users</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-4">
                        <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold leading-tight">
                            <span
                                class="bg-gradient-to-r from-gray-900 via-blue-900 to-purple-900 bg-clip-text text-transparent">
                                Take Control of
                            </span>
                            <br>
                            <span
                                class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                                Your Money
                            </span>
                        </h1>
                        <p class="text-xl lg:text-2xl text-gray-600 max-w-2xl leading-relaxed">
                            The most intuitive way to track expenses, manage budgets, and build better financial habits.
                            <span class="font-semibold text-blue-600">Start your journey to financial freedom
                                today.</span>
                        </p>
                    </div>

                    <!-- Feature Highlights -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center lg:text-left">
                        <div class="flex items-center justify-center lg:justify-start space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">100% Free</span>
                        </div>
                        <div class="flex items-center justify-center lg:justify-start space-x-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Secure & Private</span>
                        </div>
                        <div class="flex items-center justify-center lg:justify-start space-x-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Easy to Use</span>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div
                        class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            <span>Get Started Free</span>
                            <svg viewBox="0 0 24 24" class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2929 4.29289C12.6834 3.90237 13.3166 3.90237 13.7071 4.29289L20.7071 11.2929C21.0976 11.6834 21.0976 12.3166 20.7071 12.7071L13.7071 19.7071C13.3166 20.0976 12.6834 20.0976 12.2929 19.7071C11.9024 19.3166 11.9024 18.6834 12.2929 18.2929L17.5858 13H4C3.44772 13 3 12.5523 3 12C3 11.4477 3.44772 11 4 11H17.5858L12.2929 5.70711C11.9024 5.31658 11.9024 4.68342 12.2929 4.29289Z" fill="#ffffff"></path> </g></svg>
                        </a>
                        <a href="https://youtube.com/playlist?list=PLkkvp9tgkjw69LxSvc2Sbs1wM5CsOPM6N&si=Q5V74mkZfGV-YEyp" target="_blank"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-gray-700 font-semibold rounded-2xl shadow-lg hover:shadow-xl border-2 border-gray-200 hover:border-blue-300 transition-all duration-300">
                            <svg viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="10" stroke="#374151" stroke-width="1.5"></circle> <path d="M15.4137 10.941C16.1954 11.4026 16.1954 12.5974 15.4137 13.059L10.6935 15.8458C9.93371 16.2944 9 15.7105 9 14.7868L9 9.21316C9 8.28947 9.93371 7.70561 10.6935 8.15419L15.4137 10.941Z" stroke="#374151" stroke-width="1.5"></path> </g></svg>
                            Watch Demo
                        </a>
                    </div>

                    <!-- Social Proof -->
                    <div class="flex items-center justify-center lg:justify-start space-x-6 pt-4">
                        <div class="flex -space-x-2">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white font-bold text-sm">J</span>
                            </div>
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white font-bold text-sm">K</span>
                            </div>
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white font-bold text-sm">L</span>
                            </div>
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white font-bold text-sm">H</span>
                            </div>
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full border-2 border-white flex items-center justify-center">
                                <span class="text-white font-bold text-sm">K</span>
                            </div>

                        </div>
                        <div class="text-sm text-gray-600">
                            <div class="flex items-center space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                        </path>
                                    </svg>
                                @endfor
                            </div>
                            <span class="font-semibold">4.9/5</span> from 127+ reviews
                        </div>
                    </div>
                </div>

                <!-- Enhanced Right Image -->
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative">
                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-6 -left-6 w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-xl animate-bounce">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl animate-bounce"
                            style="animation-delay: 0.5s;">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="absolute -bottom-4 -left-8 w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl animate-bounce"
                            style="animation-delay: 1s;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-5-5.917V5a2 2 0 00-4 0v.083A6.002 6.002 0 004 11v3.159c0 .538-.214 1.055-.595 1.436L2 17h5m7 0v1a3 3 0 01-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </div>

                        <!-- Main Image -->
                        <div class="relative z-10 p-8">
                            <img src="{{ asset('assets/svg/landing.svg') }}"
                                alt="Financial Management Dashboard Illustration" class="w-full max-w-lg mx-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#features" class="block p-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </a>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section id="features" class="relative py-20 lg:py-32 bg-gradient-to-b from-gray-50 to-white">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 2px 2px, rgb(99 102 241) 1px, transparent 0); background-size: 40px 40px;">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 lg:mb-20">
                <div
                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Powerful Features
                </div>
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Why Choose <span
                        class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Cazhoo</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive financial management tools designed to help you take control of your money and build
                    lasting wealth.
                </p>
            </div>

            <!-- Enhanced Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                @php
                    $features = [
                        [
                            'icon' => 'money-bag.svg',
                            'gradient' => 'from-emerald-500 to-green-600',
                            'title' => 'Smart Expense Tracking',
                            'desc' =>
                                'Effortlessly track every transaction with intelligent categorization and automated insights for better financial decisions.',
                            'highlight' => 'AI-Powered',
                        ],
                        [
                            'icon' => 'insight.svg',
                            'gradient' => 'from-blue-500 to-indigo-600',
                            'title' => 'Visual Analytics',
                            'desc' =>
                                'Transform your financial data into beautiful, interactive charts and reports that reveal spending patterns and opportunities.',
                            'highlight' => 'Real-time',
                        ],
                        [
                            'icon' => 'wallet.svg',
                            'gradient' => 'from-cyan-500 to-blue-600',
                            'title' => 'Multi-Wallet Management',
                            'desc' =>
                                'Seamlessly manage cash, bank accounts, and digital wallets like GPay, Paytm, and PhonePe in one unified dashboard.',
                            'highlight' => 'All-in-One',
                        ],
                        [
                            'icon' => 'recurring.svg',
                            'gradient' => 'from-purple-500 to-indigo-600',
                            'title' => 'Smart Automation',
                            'desc' =>
                                'Set up recurring transactions, automated bill reminders, and intelligent budget alerts to never miss a payment.',
                            'highlight' => 'Automated',
                        ],
                        [
                            'icon' => 'receipt.svg',
                            'gradient' => 'from-gray-500 to-gray-700',
                            'title' => 'Digital Receipt Storage',
                            'desc' =>
                                'Organize and store all your receipts, bills, and invoices digitally with powerful search and categorization.',
                            'highlight' => 'Paperless',
                        ],
                        [
                            'icon' => 'alert.svg',
                            'gradient' => 'from-amber-500 to-orange-600',
                            'title' => 'Intelligent Alerts',
                            'desc' =>
                                'Get personalized notifications for budget limits, bill due dates, and savings opportunities to stay on track.',
                            'highlight' => 'Smart',
                        ],
                    ];
                @endphp

                @foreach ($features as $index => $feature)
                    <div class="group relative">
                        <!-- Feature Card -->
                        <div
                            class="relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 h-full border border-gray-100 hover:border-blue-200 transform hover:-translate-y-2">
                            <!-- Highlight Badge -->
                            <div class="absolute -top-3 right-6">
                                <span
                                    class="bg-gradient-to-r {{ $feature['gradient'] }} text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    {{ $feature['highlight'] }}
                                </span>
                            </div>

                            <!-- Icon -->
                            <div class="relative mb-6">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br {{ $feature['gradient'] }} rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <img src="{{ asset('assets/svg/' . $feature['icon']) }}"
                                        alt="{{ $feature['title'] }}" class="w-8 h-8 filter brightness-0 invert">
                                </div>
                                <!-- Glow Effect -->
                                <div
                                    class="absolute inset-0 w-16 h-16 bg-gradient-to-br {{ $feature['gradient'] }} rounded-2xl opacity-20 blur-lg group-hover:opacity-40 transition-opacity duration-300">
                                </div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-xl font-bold text-gray-900 mb-4 group-hover:text-blue-600 transition-colors">
                                {{ $feature['title'] }}
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $feature['desc'] }}
                            </p>

                            <!-- Learn More Link -->
                            <div class="mt-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="#"
                                    class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800">
                                    Learn more
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom CTA -->
            <div class="text-center mt-16">
                <a href="{{ route('register') }}"
                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Start Using These Features
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Enhanced How It Works Section -->
    <section id="how-it-works"
        class="relative py-20 lg:py-32 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16 lg:mb-20">
                <div
                    class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                    How It Works
                </div>
                <h2 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                    Get Started in <span
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">4 Simple
                        Steps</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Join thousands who've transformed their financial habits. Getting started takes less than 5 minutes.
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
                @php
                    $steps = [
                        [
                            'icon' => 'signup-step.svg',
                            'gradient' => 'from-emerald-500 to-green-600',
                            'step' => '01',
                            'title' => 'Quick Setup',
                            'desc' =>
                                'Create your account and configure your wallets (cash, bank, digital) in under 2 minutes.',
                            'time' => '2 min',
                        ],
                        [
                            'icon' => 'transaction-step.svg',
                            'gradient' => 'from-purple-500 to-indigo-600',
                            'step' => '02',
                            'title' => 'Track Expenses',
                            'desc' => 'Add transactions with smart categorization and automated receipt scanning.',
                            'time' => '30 sec',
                        ],
                        [
                            'icon' => 'report-step.svg',
                            'gradient' => 'from-amber-500 to-orange-600',
                            'step' => '03',
                            'title' => 'Get Insights',
                            'desc' =>
                                'View beautiful analytics, spending patterns, and personalized financial recommendations.',
                            'time' => 'Real-time',
                        ],
                        [
                            'icon' => 'alert-step.svg',
                            'gradient' => 'from-blue-500 to-indigo-600',
                            'step' => '04',
                            'title' => 'Stay on Track',
                            'desc' =>
                                'Set smart budgets, receive alerts, and achieve your financial goals with AI assistance.',
                            'time' => 'Ongoing',
                        ],
                    ];
                @endphp

                @foreach ($steps as $index => $step)
                    <div class="relative group">
                        <!-- Connection Line (Desktop) -->
                        @if ($index < 3)
                            <div
                                class="hidden lg:block absolute top-20 left-full w-full h-0.5 bg-gradient-to-r from-gray-300 to-transparent z-0">
                            </div>
                        @endif

                        <!-- Step Card -->
                        <div
                            class="relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 p-8 text-center group-hover:-translate-y-2 border border-gray-100 hover:border-indigo-200">
                            <!-- Step Number -->
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r {{ $step['gradient'] }} rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ $step['step'] }}
                                </div>
                            </div>

                            <!-- Time Badge -->
                            <div class="absolute -top-2 -right-2">
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $step['time'] }}
                                </span>
                            </div>

                            <!-- Icon -->
                            <div class="relative mb-6 mt-4">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br {{ $step['gradient'] }} rounded-2xl flex items-center justify-center mx-auto shadow-xl group-hover:scale-110 transition-transform duration-300">
                                    <img src="{{ asset('assets/svg/' . $step['icon']) }}" alt="{{ $step['title'] }}"
                                        class="w-10 h-10 filter brightness-0 invert">
                                </div>
                                <!-- Glow Effect -->
                                <div
                                    class="absolute inset-0 w-20 h-20 bg-gradient-to-br {{ $step['gradient'] }} rounded-2xl opacity-20 blur-lg mx-auto group-hover:opacity-40 transition-opacity duration-300">
                                </div>
                            </div>

                            <!-- Content -->
                            <h3
                                class="text-xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom CTA -->
            <div class="text-center mt-16">
                <div class="bg-white rounded-3xl shadow-xl p-8 max-w-2xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Transform Your Finances?</h3>
                    <p class="text-gray-600 mb-6">Join 10,000+ users who've already taken control of their money</p>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                        Start Your Free Journey
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced FAQ Section -->
    <section id="faq" class="relative py-20 lg:py-32 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    Frequently Asked Questions
                </div>
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Got <span
                        class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Questions?</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Everything you need to know about Cazhoo and getting started with better financial
                    management.
                </p>
            </div>

            <!-- Enhanced FAQ Items -->
            @php
                $faqs = [
                    [
                        'question' => 'What is Cazhoo?',
                        'answer' =>
                            'Cazhoo is a simple and powerful tool to help you manage your personal finances. You can track daily spending, set budgets, manage wallets, and get insights — all in one place.',
                    ],
                    [
                        'question' => 'Is Cazhoo free to use?',
                        'answer' =>
                            'Yes! Cazhoo is completely free to use. We’re focused on helping individuals build better financial habits without cost.',
                    ],
                    [
                        'question' => 'Do I need to create an account?',
                        'answer' =>
                            'Yes, you’ll need to sign up to securely store your data and access features like wallet management, reports, and transaction history.',
                    ],
                    [
                        'question' => 'What types of expenses can I track?',
                        'answer' =>
                            'You can track any type of spending or income — groceries, rent, salary, digital wallet transfers, etc. You can also categorize them and add notes or receipts.',
                    ],
                    [
                        'question' => 'Can I manage both cash and bank transactions?',
                        'answer' =>
                            'Absolutely. You can manage multiple payment methods — cash, bank, and even digital wallets like GPay or Paytm — and keep track of their balances separately.',
                    ],
                    [
                        'question' => 'Is my data secure?',
                        'answer' =>
                            'Yes, your data is stored securely and is only accessible by you. We follow best practices to ensure privacy and data protection.',
                    ],
                    [
                        'question' => 'Can I add recurring expenses like subscriptions?',
                        'answer' =>
                            'Yes! You can set up recurring transactions for monthly bills, rent, or subscriptions, so you don’t have to enter them every time.',
                    ],
                    [
                        'question' => 'Can I upload bills or receipts?',
                        'answer' =>
                            'Yes, you can attach images of bills, invoices, or receipts to each transaction for future reference.',
                    ],
                    [
                        'question' => 'Is there a mobile app available?',
                        'answer' =>
                            'Not yet. We’re working on it! For now, you can use the web version on any device. Stay tuned for app updates.',
                    ],
                    [
                        'question' => 'Who built Cazhoo?',
                        'answer' =>
                            'Cazhoo is proudly built by Duo Dev Technologies, with the goal of making personal finance simple and accessible for everyone.',
                    ],
                ];
            @endphp
            <div class="space-y-4" x-data="{ open: null }">
                @foreach ($faqs as $i => $faq)
                    <div
                        class="bg-gray-50 rounded-2xl border border-gray-200 hover:border-purple-200 transition-colors overflow-hidden">
                        <button @click="open === {{ $i + 1 }} ? open = null : open = {{ $i + 1 }}"
                            class="w-full flex justify-between items-center text-left p-6 font-semibold text-lg hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-inset">
                            <span class="flex-1 pr-4 text-gray-900">{{ $faq['question'] }}</span>
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center transition-transform duration-200"
                                    :class="open === {{ $i + 1 }} ? 'rotate-180 bg-purple-200' : ''">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </button>
                        <div x-show="open === {{ $i + 1 }}" x-collapse class="px-6 pb-6">
                            <div class="text-gray-600 leading-relaxed border-t border-gray-200 pt-4">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Final CTA -->
            <div class="mt-16 text-center">
                <div
                    class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-3xl shadow-2xl p-8 lg:p-12 text-white">
                    <h3 class="text-3xl lg:text-4xl font-bold mb-4">Ready to Take Control of Your Finances?</h3>
                    <p class="text-xl mb-8 text-purple-100">Join thousands of users who've transformed their financial
                        habits with Cazhoo.</p>

                    <div
                        class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-8 py-4 bg-white text-purple-700 font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
                            Start Tracking Your Expenses Today
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>

                        <div class="flex items-center space-x-2 text-purple-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span class="text-sm">No credit card required • 100% Free • Secure & Private</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Trusted by Thousands</h3>
                <p class="text-gray-600">Join our growing community of financially savvy users</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2">
                    <div class="text-3xl font-bold text-blue-600">500+</div>
                    <div class="text-sm text-gray-600">Active Users</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl font-bold text-green-600">{{ $totalTracked }}+</div>
                    <div class="text-sm text-gray-600">Money Tracked</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl font-bold text-purple-600">4.7/5</div>
                    <div class="text-sm text-gray-600">User Rating</div>
                </div>
                <div class="space-y-2">
                    <div class="text-3xl font-bold text-indigo-600">99.9%</div>
                    <div class="text-sm text-gray-600">Uptime</div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-float-delay {
            animation: float 3s ease-in-out infinite 1s;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom gradient animations */
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reading progress indicator
            const progressBar = document.createElement('div');
            progressBar.className =
                'fixed top-0 left-0 h-1 z-50 transition-all duration-300 bg-gradient-to-r from-blue-500 to-purple-600';
            document.body.appendChild(progressBar);

            window.addEventListener('scroll', () => {
                const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window
                    .innerHeight)) * 100;
                progressBar.style.width = `${Math.min(scrolled, 100)}%`;
            });
        });
    </script>
</x-guest-layout>
