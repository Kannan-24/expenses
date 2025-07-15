<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'expenses') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTqe75FO2hSi_RMgpZ5ULQ60-hKIGulio&libraries=places,marker&loading=async"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-google-analytics-head />

    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 50%, #111827 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .step-line-active {
            background: linear-gradient(90deg, #1d4ed8 0%, #7c3aed 100%);
        }
        
        .floating-animation {
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(5deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .scale-in {
            animation: scaleIn 0.3s ease-out;
        }
        
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }


        /* Enhanced text contrast */
        .text-enhanced-contrast {
            color: #111827 !important;
        }

        .text-muted-enhanced {
            color: #374151 !important;
        }
    </style>
</head>

<body class="font-sans antialiased gradient-bg min-h-screen">
    <!-- Enhanced Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400 to-purple-500 opacity-20 rounded-full floating-animation blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[32rem] h-[32rem] bg-gradient-to-tr from-indigo-400 to-cyan-400 opacity-15 rounded-full floating-animation blur-3xl" style="animation-delay: -4s;"></div>
        <div class="absolute top-1/3 left-1/4 w-80 h-80 bg-gradient-to-bl from-purple-400 to-pink-400 opacity-10 rounded-full floating-animation blur-3xl" style="animation-delay: -2s;"></div>
    </div>

    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-5xl mx-auto">
            
            <!-- Enhanced Welcome Header -->
            <div class="text-center mb-8 lg:mb-12">
                <div class="mb-8">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white bg-opacity-25 backdrop-blur-sm rounded-full mb-6 border border-white border-opacity-30">
                        <svg class="w-12 h-12 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6 drop-shadow-lg">
                    Welcome, {{ auth()->user()->name }}! 
                </h1>
                <p class="text-2xl lg:text-3xl text-white font-medium max-w-3xl mx-auto mb-4 drop-shadow-md">
                    Let's set up your financial management system
                </p>
                <p class="text-lg text-white text-opacity-90 max-w-2xl mx-auto drop-shadow-sm">
                    Just a few quick steps to get you started
                </p>
                <div class="mt-8 text-white text-opacity-80">
                    <div class="inline-flex items-center bg-white bg-opacity-20 backdrop-blur-sm rounded-full px-6 py-3 border border-white border-opacity-30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-semibold">Takes only 2-3 minutes</span>
                    </div>
                </div>
            </div>

            <!-- Enhanced Main Onboarding Card -->
            <div x-data="onboardingWizard()" class="glass-effect rounded-3xl p-8 lg:p-12 shadow-2xl border border-white border-opacity-20">

                <!-- Enhanced Progress Header -->
                <div class="mb-10 lg:mb-14">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <p class="text-sm font-bold text-gray-800 mb-2">Step <span x-text="step" class="text-blue-600"></span> of 4</p>
                            <div class="w-40 bg-gray-300 rounded-full h-3 shadow-inner">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-3 rounded-full transition-all duration-700 shadow-sm" 
                                     :style="`width: ${(step / 4) * 100}%`"></div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-semibold text-gray-700 uppercase tracking-wider">Time Remaining</p>
                            <p class="text-lg font-bold text-gray-900" x-text="`${4 - step} ${4 - step === 1 ? 'minute' : 'minutes'}`"></p>
                        </div>
                    </div>

                    <!-- Enhanced Step Indicators -->
                    <div class="relative">
                        <!-- Connection Lines -->
                        <div class="absolute top-7 left-0 w-full h-1 bg-gray-300 rounded-full"></div>
                        <div class="absolute top-7 left-0 h-1 step-line-active rounded-full transition-all duration-1000 shadow-sm" 
                             :style="`width: ${((step - 1) / 3) * 100}%`"></div>

                        <!-- Enhanced Step Circles -->
                        <div class="relative flex justify-between">
                            <template x-for="(stepData, index) in steps" :key="index">
                                <div class="flex flex-col items-center">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center transition-all duration-500 shadow-lg border-2"
                                         :class="step > index + 1 ? 'bg-green-600 text-white border-green-600 shadow-green-200' : 
                                                 step === index + 1 ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white border-transparent ring-4 ring-blue-200 shadow-blue-200' : 
                                                 'bg-white text-gray-500 border-gray-300 shadow-gray-200'">
                                        <svg x-show="step > index + 1" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span x-show="step <= index + 1" class="font-bold text-lg" x-text="index + 1"></span>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <p class="text-sm font-bold transition-colors"
                                           :class="step >= index + 1 ? 'text-gray-900' : 'text-gray-600'"
                                           x-text="stepData.title"></p>
                                        <p class="text-xs text-gray-600 mt-1 hidden sm:block font-medium" x-text="stepData.subtitle"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Error Messages -->
                @if ($errors->any())
                    <div class="mb-8 p-5 bg-red-50 border-2 border-red-200 rounded-xl shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 mt-0.5 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold text-red-900 mb-3 text-lg">Please fix the following errors:</h3>
                                <ul class="list-disc pl-6 space-y-2">
                                    @foreach ($errors->all() as $error)
                                        <li class="text-red-800 text-sm font-medium">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form id="onboardingForm" method="POST" action="{{ route('onboarding.complete') }}">
                    @csrf

                    <!-- Step Content Container -->
                    <div class="min-h-[500px] lg:min-h-[600px]">

                        <!-- STEP 1: Wallets -->
                        <div x-show="step === 1" x-transition:enter="fade-in" class="space-y-8">
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Create Your First Wallet</h2>
                                <p class="text-lg text-gray-700 max-w-lg mx-auto font-medium">Set up your primary wallet to start tracking your finances. You can add more wallets later.</p>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label for="wallet_type_id" class="flex items-center text-sm font-bold text-gray-900">
                                        Wallet Type<span class="text-red-500">*</span>
                                    </label>
                                    <select name="wallet_type_id" id="wallet_type_id" required
                                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all bg-white text-gray-900 font-medium text-lg shadow-sm">
                                        <option value="">Choose wallet type</option>
                                        @foreach ($walletTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('wallet_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('wallet_type_id')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="wallet_name" class="flex items-center text-sm font-bold text-gray-900">
                                        Wallet Name<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="wallet_name" id="wallet_name" value="{{ old('wallet_name') }}" required
                                           placeholder="e.g., Main Checking Account"
                                           class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all text-gray-900 font-medium text-lg shadow-sm">
                                    @error('wallet_name')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="balance" class="flex items-center text-sm font-bold text-gray-900">
                                        Initial Balance<span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="balance" id="balance" value="{{ old('balance', 0) }}" required
                                           min="0" step="0.01" placeholder="0.00"
                                           class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all text-gray-900 font-medium text-lg shadow-sm">
                                    @error('balance')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="currency_id" class="flex items-center text-sm font-bold text-gray-900">
                                        Currency<span class="text-red-500">*</span>
                                    </label>
                                    <select name="currency_id" id="currency_id" required
                                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all bg-white text-gray-900 font-medium text-lg shadow-sm">
                                        <option value="">Select currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('currency_id') == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name }} ({{ $currency->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency_id')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6 mt-8">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="font-bold text-blue-900 mb-2 text-lg">Pro Tip</h4>
                                        <p class="text-blue-800 font-medium">You can add multiple wallets later for different accounts like savings, credit cards, or cash.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: Categories -->
                        <div x-show="step === 2" x-transition:enter="fade-in" class="space-y-8">
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-600 to-emerald-700 rounded-full mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Create Your First Category</h2>
                                <p class="text-lg text-gray-700 max-w-lg mx-auto font-medium">Categories help you organize and track your expenses by type.</p>
                            </div>

                            <div class="max-w-lg mx-auto space-y-8">
                                <div class="space-y-3">
                                    <label for="category_name" class="flex items-center text-sm font-bold text-gray-900">
                                        Category Name<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name') }}" required
                                           placeholder="e.g., Groceries, Transportation, Entertainment"
                                           class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1  transition-all text-gray-900 font-medium text-lg shadow-sm">
                                    @error('category_name')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Enhanced Popular Categories Suggestions -->
                                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 shadow-sm">
                                    <h4 class="font-bold text-green-900 mb-4 text-lg">Popular Categories</h4>
                                    <div class="grid grid-cols-2 gap-3">
                                        <button type="button" onclick="document.getElementById('category_name').value = 'Groceries'" 
                                                class="text-left px-4 py-3 text-sm text-green-800 bg-green-100 rounded-xl hover:bg-green-200 transition-all font-semibold border-2 border-transparent hover:border-green-300 shadow-sm">
                                            Groceries
                                        </button>
                                        <button type="button" onclick="document.getElementById('category_name').value = 'Food'" 
                                                class="text-left px-4 py-3 text-sm text-green-800 bg-green-100 rounded-xl hover:bg-green-200 transition-all font-semibold border-2 border-transparent hover:border-green-300 shadow-sm">
                                            Food
                                        </button>
                                        <button type="button" onclick="document.getElementById('category_name').value = 'Transportation'" 
                                                class="text-left px-4 py-3 text-sm text-green-800 bg-green-100 rounded-xl hover:bg-green-200 transition-all font-semibold border-2 border-transparent hover:border-green-300 shadow-sm">
                                            Transportation
                                        </button>
                                        <button type="button" onclick="document.getElementById('category_name').value = 'Entertainment'" 
                                                class="text-left px-4 py-3 text-sm text-green-800 bg-green-100 rounded-xl hover:bg-green-200 transition-all font-semibold border-2 border-transparent hover:border-green-300 shadow-sm">
                                            Entertainment
                                        </button>
                                        <button type="button" onclick="document.getElementById('category_name').value = 'Utilities'" 
                                                class="text-left px-4 py-3 text-sm text-green-800 bg-green-100 rounded-xl hover:bg-green-200 transition-all font-semibold border-2 border-transparent hover:border-green-300 shadow-sm">
                                            Utilities
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-6 shadow-sm">
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 text-amber-600 mt-0.5 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="font-bold text-amber-900 mb-2 text-lg">Quick Start</h4>
                                            <p class="text-amber-800 font-medium">Start with one category now. You can easily add more categories later as you use the system.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: Expense People -->
                        <div x-show="step === 3" x-transition:enter="fade-in" class="space-y-8">
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-purple-600 to-pink-700 rounded-full mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Add an Expense Person</h2>
                                <p class="text-lg text-gray-700 max-w-lg mx-auto font-medium">Track expenses for family members, friends, or anyone you share costs with.</p>
                            </div>

                            <div class="max-w-lg mx-auto space-y-8">
                                <div class="space-y-3">
                                    <label for="expense_person_name" class="flex items-center text-sm font-bold text-gray-900">
                                        Person Name<span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="expense_person_name" id="expense_person_name" value="{{ old('expense_person_name') }}" required
                                           placeholder="e.g., John Doe, My Spouse, Roommate"
                                           class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all text-gray-900 font-medium text-lg shadow-sm">
                                    @error('expense_person_name')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Enhanced Quick Suggestions -->
                                <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-6 shadow-sm">
                                    <h4 class="font-bold text-purple-900 mb-4 text-lg">Quick Suggestions</h4>
                                    <div class="space-y-3">
                                        <button type="button" onclick="document.getElementById('expense_person_name').value = 'Myself'" 
                                                class="w-full text-left px-4 py-3 text-sm text-purple-800 bg-purple-100 rounded-xl hover:bg-purple-200 transition-all font-semibold border-2 border-transparent hover:border-purple-300 shadow-sm">
                                            Myself
                                        </button>
                                        <button type="button" onclick="document.getElementById('expense_person_name').value = 'Spouse/Partner'" 
                                                class="w-full text-left px-4 py-3 text-sm text-purple-800 bg-purple-100 rounded-xl hover:bg-purple-200 transition-all font-semibold border-2 border-transparent hover:border-purple-300 shadow-sm">
                                            Spouse/Partner
                                        </button>
                                        <button type="button" onclick="document.getElementById('expense_person_name').value = 'Family Member'" 
                                                class="w-full text-left px-4 py-3 text-sm text-purple-800 bg-purple-100 rounded-xl hover:bg-purple-200 transition-all font-semibold border-2 border-transparent hover:border-purple-300 shadow-sm">
                                            Family Member
                                        </button>
                                    </div>
                                </div>

                                <div class="bg-indigo-50 border-2 border-indigo-200 rounded-xl p-6 shadow-sm">
                                    <div class="flex items-start">
                                        <svg class="w-6 h-6 text-indigo-600 mt-0.5 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <h4 class="font-bold text-indigo-900 mb-2 text-lg">Why Add People?</h4>
                                            <p class="text-indigo-800 font-medium">Track who expenses are for, making it easier to manage shared costs and personal budgets.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 4: Preferences -->
                        <div x-show="step === 4" x-transition:enter="fade-in" class="space-y-8">
                            <div class="text-center mb-10">
                                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-orange-600 to-red-700 rounded-full mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Final Preferences</h2>
                                <p class="text-lg text-gray-700 max-w-lg mx-auto font-medium">Set your default currency and timezone to personalize your experience.</p>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-3xl mx-auto">
                                <div class="space-y-3">
                                    <label for="default_currency_id" class="flex items-center text-sm font-bold text-gray-900">
                                        Default Currency<span class="text-red-500">*</span>
                                    </label>
                                    <select name="default_currency_id" id="default_currency_id" required
                                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all bg-white text-gray-900 font-medium text-lg shadow-sm">
                                        <option value="">Select default currency</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ old('default_currency_id') == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name }} ({{ $currency->code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('default_currency_id')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="default_timezone" class="flex items-center text-sm font-bold text-gray-900">
                                        Timezone<span class="text-red-500">*</span>
                                    </label>
                                    <select name="default_timezone" id="default_timezone" required
                                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-1 transition-all bg-white text-gray-900 font-medium text-lg shadow-sm">
                                        <option value="">Select your timezone</option>
                                        @foreach ($timezones as $timezone)
                                            <option value="{{ $timezone }}" {{ old('default_timezone') == $timezone ? 'selected' : '' }}>
                                                {{ $timezone }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('default_timezone')
                                        <p class="text-sm text-red-700 flex items-center mt-2 font-semibold">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-300 rounded-xl p-8 max-w-3xl mx-auto shadow-sm">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-green-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h4 class="font-bold text-gray-900 mb-3 text-2xl">Almost Done!</h4>
                                    <p class="text-gray-800 font-medium text-lg">Click finish to complete your setup and start managing your finances.</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Enhanced Navigation Buttons -->
                    <div class="flex justify-between items-center mt-12 lg:mt-16 pt-8 border-t-2 border-gray-200">
                        <button type="button" @click="prev" :disabled="step === 1"
                                class="inline-flex items-center px-8 py-4 border-2 border-gray-400 rounded-xl text-gray-800 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-xl disabled:shadow-none">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back
                        </button>

                       

                        <template x-if="step < 4">
                            <button type="button" @click="next" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-700 text-white rounded-xl hover:from-blue-700 hover:to-purple-800 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                                Next
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </template>

                        <template x-if="step === 4">
                            <button type="button" @click="complete" x-ref="finishButton"
                                    class="inline-flex items-center px-10 py-4 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl hover:from-green-700 hover:to-emerald-800 transition-all duration-200 font-bold text-lg shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Finish Setup
                            </button>
                        </template>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function onboardingWizard() {
            return {
                step: {{ $step ?? 1 }},
                steps: [
                    { title: 'Wallet', subtitle: 'Set up your primary wallet' },
                    { title: 'Categories', subtitle: 'Create expense categories' },
                    { title: 'People', subtitle: 'Add expense people' },
                    { title: 'Preferences', subtitle: 'Configure your settings' }
                ],
                
                next() {
                    if (this.step < 4) {
                        this.step++;
                        this.scrollToTop();
                    }
                },
                
                prev() {
                    if (this.step > 1) {
                        this.step--;
                        this.scrollToTop();
                    }
                },
                
                complete() {
                    // Add loading state
                    const button = this.$refs.finishButton;
                    const originalText = button.innerHTML;
                    button.innerHTML = `
                        <svg class="animate-spin w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Setting up your account...
                    `;
                    button.disabled = true;
                    
                    // Submit form
                    setTimeout(() => {
                        document.getElementById('onboardingForm').submit();
                    }, 1000);
                },
                
                scrollToTop() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize TomSelect with enhanced styling
            new TomSelect('#currency_id', {
                create: false,
                sortField: { field: "text", direction: "asc" },
                controlInput: '<input class="form-control" tabindex="-1">',
                dropdownClass: 'ts-dropdown enhanced-dropdown'
            });

            new TomSelect('#default_currency_id', {
                create: false,
                sortField: { field: "text", direction: "asc" },
                controlInput: '<input class="form-control" tabindex="-1">',
                dropdownClass: 'ts-dropdown enhanced-dropdown'
            });

            new TomSelect('#default_timezone', {
                create: false,
                sortField: { field: "text", direction: "asc" },
                controlInput: '<input class="form-control" tabindex="-1">',
                dropdownClass: 'ts-dropdown enhanced-dropdown'
            });

            // Auto-detect timezone with better UX
            if (Intl.DateTimeFormat().resolvedOptions().timeZone) {
                const detectedTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                const timezoneSelect = document.getElementById('default_timezone');
                if (timezoneSelect && !timezoneSelect.value) {
                    for (let option of timezoneSelect.options) {
                        if (option.value === detectedTimezone) {
                            option.selected = true;
                            // Show a subtle notification
                            const notification = document.createElement('div');
                            notification.className = 'fixed top-4 right-4 bg-blue-100 border border-blue-300 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium z-50';
                            notification.innerHTML = '🌍 Auto-detected your timezone!';
                            document.body.appendChild(notification);
                            setTimeout(() => notification.remove(), 3000);
                            break;
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>