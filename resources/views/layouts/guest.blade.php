<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Duo Dev Expenses - Professional personal finance management tool. Track expenses, manage budgets, and build better financial habits with our intuitive platform.">
    <meta name="keywords"
        content="expense tracker, budget management, personal finance, money management, financial planning">
    <meta name="author" content="Duo Dev Technologies">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Duo Dev Expenses - Take Control of Your Money">
    <meta property="og:description"
        content="The most intuitive way to track expenses, manage budgets, and build better financial habits.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Duo Dev Expenses">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Duo Dev Expenses - Take Control of Your Money">
    <meta name="twitter:description"
        content="The most intuitive way to track expenses, manage budgets, and build better financial habits.">

    <title>
        {{ $title ?? 'Duo Dev Expenses - Professional Personal Finance Management | Track, Manage & Save Money' }}
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Enhanced Navigation Styles */
        .nav-link {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3B82F6, #8B5CF6);
            border-radius: 1px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            width: 24px;
        }

        .nav-link:hover {
            color: #3B82F6;
            transform: translateY(-1px);
        }

        /* Mobile navigation styles */
        @media (max-width: 768px) {
            .nav-link::before {
                display: none;
            }

            .mobile-nav-item {
                border-left: 3px solid transparent;
                transition: all 0.3s ease;
            }

            .mobile-nav-item:hover,
            .mobile-nav-item.active {
                border-left-color: #3B82F6;
                background-color: #F8FAFC;
            }
        }

        /* Navbar scroll effect */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.8);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #3B82F6, #8B5CF6);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #2563EB, #7C3AED);
        }

        /* Loading animation */
        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Smooth animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Focus styles for accessibility */
        .focus-visible:focus {
            outline: 2px solid #3B82F6;
            outline-offset: 2px;
        }
    </style>

    <!-- Google One Tap Script -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

    <!-- Analytics -->
    <x-google-analytics-head />
</head>

<body class="font-sans antialiased text-gray-900 bg-white">
    <x-google-analytics-body />

    <!-- Enhanced Navbar -->
    <header id="main-navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out"
        x-data="{
            openNav: false,
            scrolled: false,
            init() {
                this.updateNavbar();
                window.addEventListener('scroll', () => this.updateNavbar());
            },
            updateNavbar() {
                this.scrolled = window.scrollY > 20;
            },
            closeNav() {
                this.openNav = false;
            }
        }" :class="scrolled ? 'navbar-scrolled shadow-lg' : 'bg-white/90 backdrop-blur-sm'">

        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">

                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <img src="{{ asset('assets\logo.png') }}" alt="logo">
                    </div>
                    <div class="hidden sm:block">
                        <h1
                            class="text-xl lg:text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                            Duo Dev Expenses
                        </h1>
                        <p class="text-xs text-gray-500 -mt-1">Financial Freedom</p>
                    </div>
                    <div class="sm:hidden">
                        <h1 class="text-lg font-bold text-gray-900">Duo Dev</h1>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="openNav = !openNav"
                        class="relative p-2 rounded-lg text-gray-600 hover:text-blue-600 hover:bg-gray-100 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        :class="openNav ? 'text-blue-600 bg-blue-50' : ''">
                        <span class="sr-only">Toggle navigation menu</span>
                        <svg x-show="!openNav" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="openNav" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-6">
                    @php
                        $navItems = [
                            [
                                'href' => '/#home',
                                'label' => 'Home',
                                'icon' =>
                                    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                            ],
                            ['href' => '/#features', 'label' => 'Features', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            [
                                'href' => '/#how-it-works',
                                'label' => 'How It Works',
                                'icon' =>
                                    'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                            ],
                            [
                                'href' => '/#faq',
                                'label' => 'FAQ',
                                'icon' =>
                                    'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            ],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] }}"
                            class="nav-link group flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors focus-visible:focus"
                            @click="closeNav()">
                            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}"></path>
                            </svg>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                    <!-- Desktop Auth Buttons -->
                    <div class="hidden lg:flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="nav-link px-4 py-2 text-gray-700 font-medium hover:text-blue-600 transition-colors focus-visible:focus">
                                Sign In
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                    </path>
                                </svg>
                                Get Started
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </div>

        <!-- Enhanced Mobile Menu -->
        <div x-show="openNav" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4"
            class="lg:hidden absolute top-full left-0 w-full bg-white/95 backdrop-blur-lg shadow-xl border-t border-gray-200"
            @click.away="openNav = false">

            <div class="px-4 py-6 space-y-1">
                <!-- Navigation Items -->
                @foreach ($navItems as $item)
                    <a href="{{ $item['href'] }}"
                        class="mobile-nav-item flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                        @click="closeNav()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="{{ $item['icon'] }}"></path>
                        </svg>
                        <span class="font-medium">{{ $item['label'] }}</span>
                    </a>
                @endforeach

                <!-- Mobile Auth Buttons -->
                <div class="pt-4 border-t border-gray-200 space-y-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg"
                            @click="closeNav()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="mobile-nav-item flex items-center space-x-3 px-4 py-3 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                            @click="closeNav()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span class="font-medium">Sign In</span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center space-x-2 w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg"
                            @click="closeNav()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <span>Get Started Free</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-16 lg:pt-20">
        {{ $slot }}
    </main>

    <!-- Enhanced Footer -->
    <footer class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">

                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets\logo.png') }}" alt="logo">
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">Duo Dev Expenses</h3>
                            <p class="text-gray-400 text-sm">Financial Freedom Made Simple</p>
                        </div>
                    </div>
                    <p class="text-gray-300 text-lg leading-relaxed mb-6 max-w-md">
                        Take control of your finances with our intuitive expense tracking platform.
                        Build better money habits and achieve your financial goals.
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-gray-400 text-sm">4.9/5 from 1,200+ users</span>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-bold mb-6 flex items-center">

                        Quick Links
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $footerLinks = [
                                ['href' => '/#features', 'label' => 'Features'],
                                ['href' => '/#how-it-works', 'label' => 'How It Works'],
                                ['href' => '/#faq', 'label' => 'FAQ'],
                                ['href' => '/terms-of-service', 'label' => 'Terms of Service'],
                                ['href' => '/privacy-policy', 'label' => 'Privacy Policy'],
                            ];
                        @endphp
                        @foreach ($footerLinks as $link)
                            <li>
                                <a href="{{ $link['href'] }}"
                                    class="text-gray-300 hover:text-white transition-colors duration-200 flex items-center group">
                                    <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div>
                    <h3 class="text-lg font-bold mb-6 flex items-center">
                        Stay Connected
                    </h3>

                    <!-- Contact Info -->
                    <div class="mb-6">
                        <a href="mailto:support@duodev.in"
                            class="flex items-center space-x-3 text-gray-300 hover:text-white transition-colors group">
                            <div
                                class="w-10 h-10 bg-blue-600/20 rounded-lg flex items-center justify-center group-hover:bg-blue-600/40 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Email Support</p>
                                <p class="text-sm">support@duodev.in</p>
                            </div>
                        </a>
                    </div>

                    <!-- Newsletter Signup -->
                    <div>
                        <p class="text-gray-300 text-sm mb-4">Get product updates & financial tips</p>
                        <form class="space-y-3" x-data="{ email: '', loading: false }" @submit.prevent="subscribeNewsletter">
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                                <input type="email" x-model="email" placeholder="Enter your email" required
                                    class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                <button type="submit" :disabled="loading"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 flex items-center justify-center">
                                    <span x-show="!loading">Subscribe</span>
                                    <svg x-show="loading" class="loading-spinner w-5 h-5" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400">No spam, unsubscribe anytime.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="border-t border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                    <div class="flex items-center space-x-6 text-sm text-gray-400">
                        <p>&copy; {{ date('Y') }}
                            <a href="https://duodev.in" target="_blank" rel="noopener"
                                class="text-white font-semibold hover:text-blue-400 transition-colors">
                                Duo Dev Technologies
                            </a>. All rights reserved.
                        </p>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                        <span>Duo Dev Expenses — A personal finance management product by Duo Dev Technologies.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
        class="fixed bottom-6 right-6 w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 opacity-0 invisible z-40"
        onclick="scrollToTop()">
        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
            </path>
        </svg>
    </button>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed top-20 right-4 z-50 space-y-2"></div>

    <!-- Enhanced Scripts -->
    <script>
        // Enhanced Navigation with improved performance
        const navigationManager = {
            init() {
                this.setupSmoothScroll();
                this.setupActiveNavigation();
                this.setupBackToTop();
                this.setupToastNotifications();
            },

            setupSmoothScroll() {
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', (e) => {
                        const href = anchor.getAttribute('href');
                        if (href === '#') return;

                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            const navbar = document.getElementById('main-navbar');
                            const offset = navbar ? navbar.offsetHeight + 20 : 80;

                            window.scrollTo({
                                top: target.getBoundingClientRect().top + window.scrollY -
                                    offset,
                                behavior: 'smooth'
                            });

                            // Close mobile menu if open
                            if (window.innerWidth < 1024) {
                                const navData = Alpine.$data(document.getElementById('main-navbar'));
                                if (navData) navData.openNav = false;
                            }
                        }
                    });
                });
            },

            setupActiveNavigation() {
                const sections = ['home', 'features', 'how-it-works', 'faq'];
                let ticking = false;

                const updateActiveNav = () => {
                    if (!ticking) {
                        requestAnimationFrame(() => {
                            const navbar = document.getElementById('main-navbar');
                            const scrollPos = window.scrollY + (navbar ? navbar.offsetHeight : 80) + 50;

                            let activeSection = '';

                            for (let i = sections.length - 1; i >= 0; i--) {
                                const element = document.getElementById(sections[i]);
                                if (element && element.offsetTop <= scrollPos) {
                                    activeSection = sections[i];
                                    break;
                                }
                            }

                            // Update navigation links
                            document.querySelectorAll('.nav-link').forEach(link => {
                                const href = link.getAttribute('href');
                                if (href && href.includes('#')) {
                                    const sectionName = href.split('#')[1];
                                    if (sectionName === activeSection) {
                                        link.classList.add('active', 'text-blue-600');
                                        link.querySelector('svg').classList.remove('opacity-0');
                                        link.querySelector('svg').classList.add('opacity-100');
                                    } else {
                                        link.querySelector('svg').classList.add('opacity-0');
                                        link.querySelector('svg').classList.remove('opacity-100');
                                        link.classList.remove('active', 'text-blue-600');
                                    }
                                }
                            });

                            ticking = false;
                        });
                        ticking = true;
                    }
                };

                window.addEventListener('scroll', updateActiveNav, {
                    passive: true
                });
                window.addEventListener('DOMContentLoaded', updateActiveNav);
            },

            setupBackToTop() {
                const backToTopButton = document.getElementById('backToTop');

                window.addEventListener('scroll', () => {
                    if (window.scrollY > 300) {
                        backToTopButton.classList.remove('opacity-0', 'invisible');
                        backToTopButton.classList.add('opacity-100', 'visible');
                    } else {
                        backToTopButton.classList.add('opacity-0', 'invisible');
                        backToTopButton.classList.remove('opacity-100', 'visible');
                    }
                }, {
                    passive: true
                });
            },

            setupToastNotifications() {
                window.showToast = (message, type = 'info', duration = 4000) => {
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');

                    const colors = {
                        success: 'bg-green-600 border-green-500',
                        error: 'bg-red-600 border-red-500',
                        warning: 'bg-yellow-600 border-yellow-500',
                        info: 'bg-blue-600 border-blue-500'
                    };

                    const icons = {
                        success: 'M5 13l4 4L19 7',
                        error: 'M6 18L18 6M6 6l12 12',
                        warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z',
                        info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                    };

                    toast.className =
                        `${colors[type] || colors.info} text-white px-6 py-4 rounded-xl shadow-lg border-l-4 transform transition-all duration-300 max-w-sm fade-in`;
                    toast.innerHTML = `
                        <div class="flex items-start space-x-3">
                            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${icons[type] || icons.info}"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="font-medium">${message}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    `;

                    container.appendChild(toast);

                    setTimeout(() => {
                        toast.style.transform = 'translateX(100%)';
                        toast.style.opacity = '0';
                        setTimeout(() => toast.remove(), 300);
                    }, duration);
                };
            }
        };

        // Utility Functions
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function subscribeNewsletter() {
            // Newsletter subscription logic here
            showToast('Thank you for subscribing to our newsletter!', 'success');
        }

        // Google One Tap Integration (Enhanced)
        @guest
        window.addEventListener('load', () => {
            if (typeof google !== 'undefined' && google.accounts) {
                google.accounts.id.initialize({
                    client_id: "{{ config('services.google.client_id') }}",
                    callback: handleCredentialResponse,
                    auto_select: false,
                    cancel_on_tap_outside: true
                });

                // Show One Tap after a delay to improve UX
                setTimeout(() => {
                    google.accounts.id.prompt((notification) => {
                        if (notification.isNotDisplayed() || notification.isSkippedMoment()) {
                            console.log('One Tap not displayed or skipped');
                        }
                    });
                }, 1000);
            }
        });

        function handleCredentialResponse(response) {
            fetch('/google-onetap-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        token: response.credential
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Successfully signed in with Google!', 'success');
                        setTimeout(() => window.location.href = '/dashboard', 1000);
                    } else {
                        showToast(data.message || 'Authentication failed. Please try again.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Authentication error:', error);
                    showToast('An error occurred during authentication.', 'error');
                });
        }
        @endguest

        // Initialize everything when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            navigationManager.init();

            
        });
    </script>
</body>

</html>
