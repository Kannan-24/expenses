<x-guest-layout>
    <x-slot name="title">Privacy Policy | Duo Dev Expenses - Protecting Your Financial Data Privacy</x-slot>

    <!-- Enhanced Hero Section -->
    <section class="relative bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50 pt-12 pb-16">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-green-400 to-teal-500 opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-gradient-to-tr from-emerald-400 to-cyan-400 opacity-10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <!-- Breadcrumb -->
                <nav class="flex justify-center mb-8" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/80 backdrop-blur-sm rounded-full px-6 py-3 shadow-lg border border-gray-200">
                        <li class="inline-flex items-center">
                            <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z"></path>
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-gray-900">Privacy Policy</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Header Content -->
                <div class="mb-12">
                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold mb-6">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Privacy & Security
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Privacy <span class="bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">Policy</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        Your privacy is our priority. Learn how we collect, use, and protect your personal and financial information.
                    </p>
                    <div class="mt-6 inline-flex items-center text-sm text-gray-600 bg-white/70 backdrop-blur-sm rounded-full px-4 py-2 border border-gray-200">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                        </svg>
                        Last updated: {{ \Carbon\Carbon::parse('2025-07-02')->format('F j, Y') }}
                    </div>
                </div>

                <!-- Privacy Commitment Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-6xl mx-auto">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Data Protection</h3>
                        <p class="text-sm text-gray-600">Bank-level security to protect your financial information</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">No Selling</h3>
                        <p class="text-sm text-gray-600">We never sell your data to third parties or advertisers</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Transparency</h3>
                        <p class="text-sm text-gray-600">Clear policies with no hidden data collection practices</p>
                    </div>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-lg border border-gray-200">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2">Your Control</h3>
                        <p class="text-sm text-gray-600">Full control over your data with easy access and deletion</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Privacy Content -->
    <section class="py-16 lg:py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Quick Summary -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 mb-12 border-l-4 border-green-500">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 mb-3">Privacy Policy Summary</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            This Privacy Policy explains how <strong>Duo Dev Technologies</strong> ("we", "our", or "us") collects, uses, and
                            protects your personal information when you use our financial management services through 
                            <a href="https://duodev.in" class="text-green-600 hover:text-green-800 underline font-medium">https://duodev.in</a>.
                        </p>
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-gray-700">
                                <strong class="text-gray-900">Key Point:</strong> We only collect essential information needed to provide our services and protect it with industry-standard security measures.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table of Contents -->
            <div class="bg-gradient-to-br from-gray-50 to-green-50 rounded-2xl p-8 mb-12 border border-gray-200 shadow-sm" x-data="{ open: false }">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        What's Covered
                    </h2>
                    <button @click="open = !open" class="lg:hidden p-2 text-gray-600 hover:text-green-600 transition-colors">
                        <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <div :class="open ? 'block' : 'hidden lg:block'" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $sections = [
                            ['id' => 'information-collection', 'title' => '1. Information We Collect', 'desc' => 'What data we gather and why', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['id' => 'google-signin', 'title' => '2. Google Sign-In Usage', 'desc' => 'How we use Google authentication', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['id' => 'data-usage', 'title' => '3. How We Use Information', 'desc' => 'Purpose and processing of your data', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                            ['id' => 'data-sharing', 'title' => '4. Data Sharing Policy', 'desc' => 'When and how we share information', 'icon' => 'M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z'],
                            ['id' => 'data-retention', 'title' => '5. Data Retention', 'desc' => 'How long we keep your information', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['id' => 'user-rights', 'title' => '6. Your Privacy Rights', 'desc' => 'Control over your personal data', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['id' => 'cookies', 'title' => '7. Cookies & Tracking', 'desc' => 'How we use cookies and analytics', 'icon' => 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122'],
                            ['id' => 'data-security', 'title' => '8. Data Security', 'desc' => 'How we protect your information', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                            ['id' => 'third-party', 'title' => '9. Third-Party Services', 'desc' => 'External services and integrations', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                            ['id' => 'policy-changes', 'title' => '10. Policy Updates', 'desc' => 'How we handle privacy policy changes', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                            ['id' => 'contact-privacy', 'title' => '11. Privacy Questions', 'desc' => 'How to contact us about privacy', 'icon' => 'M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                        ];
                    @endphp
                    
                    @foreach ($sections as $section)
                        <a href="#{{ $section['id'] }}" class="block p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-200 group border border-gray-200 hover:border-green-300">
                            <div class="flex items-start space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-green-200 transition-colors">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $section['icon'] }}"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 text-sm group-hover:text-green-600 transition-colors">{{ $section['title'] }}</h3>
                                    <p class="text-xs text-gray-600 mt-1">{{ $section['desc'] }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Privacy Sections -->
            <div class="space-y-12">
                
                <!-- Section 1: Information Collection -->
                <section id="information-collection" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-blue-600">1</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Information We Collect</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-6">
                                When you use our services, we may collect the following personal information to provide you with the best financial management experience:
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                    <h4 class="font-bold text-blue-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Account Information
                                    </h4>
                                    <ul class="text-blue-800 space-y-2 text-sm">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Name (via Google Sign-In only)
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Email address (via Google Sign-In only)
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                                    <h4 class="font-bold text-purple-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Usage Analytics
                                    </h4>
                                    <ul class="text-purple-800 space-y-2 text-sm">
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Access times and frequency
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Pages visited and features used
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Performance and error data
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-green-800 mb-1">Minimal Data Collection</h4>
                                        <p class="text-green-700 text-sm">We follow the principle of data minimization - collecting only what's necessary to provide our financial management services effectively.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 2: Google Sign-In -->
                <section id="google-signin" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-red-600">2</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Google Sign-In Usage</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-6">
                                We use Google Sign-In as our secure authentication method for account creation and login. This provides you with a safe, convenient way to access your financial data without creating additional passwords.
                            </p>
                            
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6 border border-blue-200">
                                <h4 class="font-bold text-blue-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    What We Access Through Google
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 border border-blue-300">
                                        <h5 class="font-semibold text-blue-800 mb-2">✓ We Access:</h5>
                                        <ul class="text-blue-700 text-sm space-y-1">
                                            <li>• Your full name</li>
                                            <li>• Your email address</li>
                                            <li>• Basic profile information</li>
                                        </ul>
                                    </div>
                                    <div class="bg-white rounded-lg p-4 border border-green-300">
                                        <h5 class="font-semibold text-green-800 mb-2">✗ We Never Access:</h5>
                                        <ul class="text-green-700 text-sm space-y-1">
                                            <li>• Your Google password</li>
                                            <li>• Your Gmail or Drive content</li>
                                            <li>• Other Google services data</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                <div class="flex items-start space-x-3">
                                    <svg class="w-5 h-5 text-amber-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-amber-800 mb-1">Secure Authentication</h4>
                                        <p class="text-amber-700 text-sm">This information is stored securely and used only to personalize your experience and manage your account within our financial management platform.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Data Usage -->
                <section id="data-usage" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-green-600">3</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">How We Use Your Information</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-6">
                                We use the collected information exclusively to provide, improve, and secure our financial management services. Here's exactly how:
                            </p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Service Provision
                                        </h4>
                                        <ul class="text-blue-700 text-sm space-y-1">
                                            <li>• Operate and maintain our platform</li>
                                            <li>• Process your financial transactions</li>
                                            <li>• Generate expense reports and insights</li>
                                        </ul>
                                    </div>

                                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-purple-800 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            Communication
                                        </h4>
                                        <ul class="text-purple-700 text-sm space-y-1">
                                            <li>• Send account-related notifications</li>
                                            <li>• Provide customer support</li>
                                            <li>• Share important service updates</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-green-800 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Improvement
                                        </h4>
                                        <ul class="text-green-700 text-sm space-y-1">
                                            <li>• Enhance user experience</li>
                                            <li>• Develop new features</li>
                                            <li>• Optimize platform performance</li>
                                        </ul>
                                    </div>

                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <h4 class="font-semibold text-red-800 mb-2 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Security
                                        </h4>
                                        <ul class="text-red-700 text-sm space-y-1">
                                            <li>• Prevent fraud and abuse</li>
                                            <li>• Monitor for suspicious activity</li>
                                            <li>• Maintain data integrity</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Data Sharing -->
                <section id="data-sharing" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-red-600">4</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Data Sharing and Disclosure</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center space-x-3 mb-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <h4 class="text-xl font-bold text-green-800">Our Commitment: We Never Sell Your Data</h4>
                                </div>
                                <p class="text-green-700 font-medium">
                                    We do not sell, rent, or trade your personal information with third parties, advertisers, or data brokers. Your financial data stays private and secure.
                                </p>
                            </div>

                            <p class="text-gray-700 leading-relaxed mb-6">
                                We only share your personal information in the following limited circumstances:
                            </p>
                            
                            <div class="space-y-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                        </svg>
                                        Legal Compliance
                                    </h4>
                                    <p class="text-blue-700 text-sm">When required by law, court order, or government regulation to comply with legal obligations or law enforcement requests.</p>
                                </div>

                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                    <h4 class="font-semibold text-purple-800 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                        Service Providers
                                    </h4>
                                    <p class="text-purple-700 text-sm">With trusted service providers who help us operate the application (such as hosting, email delivery, and analytics) under strict confidentiality agreements.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 5: Data Retention -->
                <section id="data-retention" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-amber-600">5</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Data Retention</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-4">
                                We retain your data only for as long as necessary to fulfill the purposes outlined in this policy, or as required by law. When you delete your account, we remove your personal data within 30 days.
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Section 6: User Rights -->
                <section id="user-rights" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-indigo-600">6</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Your Privacy Rights</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-6">You have complete control over your personal data. Here are your rights:</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <h4 class="font-bold text-blue-800 mb-2">Access</h4>
                                    <p class="text-blue-700 text-sm">Request a copy of all personal data we hold about you</p>
                                </div>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <h4 class="font-bold text-green-800 mb-2">Correction</h4>
                                    <p class="text-green-700 text-sm">Update or correct any inaccurate personal information</p>
                                </div>
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 text-red-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <h4 class="font-bold text-red-800 mb-2">Deletion</h4>
                                    <p class="text-red-700 text-sm">Request complete deletion of your account and data</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 11: Contact -->
                <section id="contact-privacy" class="scroll-mt-24">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-8 py-6 border-b border-gray-200 rounded-t-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <span class="text-lg font-bold text-green-600">11</span>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Privacy Questions & Contact</h3>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-gray-700 leading-relaxed mb-6">
                                If you have any questions about this Privacy Policy or how we handle your data, we're here to help:
                            </p>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-green-800 mb-1">Privacy Support Team</h4>
                                        <a href="mailto:support@duodev.in" class="text-green-700 hover:text-green-800 underline font-medium text-lg">
                                            support@duodev.in
                                        </a>
                                        <p class="text-green-600 text-sm mt-1">We respond to privacy inquiries within 24 hours</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Footer Information -->
            <div class="mt-16 pt-8 border-t border-gray-200">
                <div class="bg-gradient-to-r from-gray-50 to-green-50 rounded-2xl p-8 text-center">
                    <div class="flex items-center justify-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h4a1 1 0 011 1v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Privacy Policy Information</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                        <div>
                            <p class="font-medium text-gray-900">Last Updated</p>
                            <p>{{ \Carbon\Carbon::parse('2025-07-02')->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Effective Date</p>
                            <p>{{ \Carbon\Carbon::parse('2025-07-02')->format('F j, Y') }}</p>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Version</p>
                            <p>2.0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-12 text-center">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Your Privacy is Protected</h3>
                    <p class="text-green-100 mb-6 max-w-2xl mx-auto">
                        Start managing your finances with confidence, knowing your data is secure and private.
                    </p>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-8 py-4 bg-white text-green-600 font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Start Securely Today
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for table of contents links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Enhanced scroll spy functionality
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('a[href^="#"]');

            window.addEventListener('scroll', () => {
                let currentSection = '';
                sections.forEach(section => {
                    const sectionTop = section.getBoundingClientRect().top;
                    if (sectionTop <= 100) {
                        currentSection = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('bg-green-100', 'border-green-300');
                    if (link.getAttribute('href') === '#' + currentSection) {
                        link.classList.add('bg-green-100', 'border-green-300');
                    }
                });
            });

            // Reading progress indicator
            const progressBar = document.createElement('div');
            progressBar.className = 'fixed top-0 left-0 h-1 bg-gradient-to-r from-green-500 to-emerald-500 z-50 transition-all duration-300';
            document.body.appendChild(progressBar);

            window.addEventListener('scroll', () => {
                const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                progressBar.style.width = `${Math.min(scrolled, 100)}%`;
            });
        });
    </script>
</x-guest-layout>