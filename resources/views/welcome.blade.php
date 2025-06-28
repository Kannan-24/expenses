<x-guest-layout>

    <x-slot name="title">
        Duo Dev Expenses - An Personal Expense Tracking App by Duo Dev Technologies
    </x-slot>

    <!-- Hero Section -->
    <section id="home"
        class="flex flex-col md:flex-row justify-between items-center px-4 sm:px-6 md:px-10 py-10 md:py-20 bg-gray-50 min-h-screen"
        style="font-family: 'Poppins', 'Roboto', sans-serif;">

        <!-- Left Content -->
        <div class="flex-1 flex flex-col justify-center items-start text-left md:pr-12 pl-0 md:pl-20 mt-16 md:mt-24">
            <h2 class="text-3xl sm:text-4xl md:text-6xl font-bold mb-4 leading-tight text-black">
                Take control of<br>
                <span class="text-black">Your money</span>
            </h2>
            <p class="mb-4 text-gray-500 text-base sm:text-lg max-w-xs sm:max-w-md">
                Track your income, spending, and savings with ease.
            </p>
            <a href="{{ route('register') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold shadow hover:bg-blue-700 transition w-auto text-center">
                Get Started
            </a>
        </div>

        <!-- Right Image -->
        <div class="flex-1 flex justify-center items-center mt-4 md:mt-0 w-full">
            <img src="{{ asset('assets/svg/landing.svg') }}" alt="Illustration"
                class="w-4/5 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="text-center py-16 relative"
        style="background: url('{{ asset('assets/Features_BG.png') }}') center center / cover no-repeat; min-height: 100vh; box-shadow: 0 -30px 40px -20px rgba(0,0,0,0.08) inset, 0 30px 40px -20px rgba(0,0,0,0.08) inset;">
        <div class="relative z-10 mx-auto w-full px-2 sm:px-6">
            <h2 class="text-3xl sm:text-4xl font-bold mb-8">Why Use Duo Dev Expenses</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-10 px-2 sm:px-10 w-max mx-auto">
                @php
                    $features = [
                        [
                            'icon' => 'money-bag.svg',
                            'color' => 'linear-gradient(135deg, #34D399 0%, #059669 100%)',
                            'hr' => '#34D399',
                            'title' => 'Track Every Rupee',
                            'desc' => 'Add your daily expenses with category and payment method.',
                        ],
                        [
                            'icon' => 'insight.svg',
                            'color' => 'linear-gradient(135deg, #2563eb 0%, #60a5fa 100%)',
                            'hr' => '#2563eb',
                            'title' => 'Visual Insights',
                            'desc' => 'Understand your habits with graphs and reports.',
                        ],
                        [
                            'icon' => 'wallet.svg',
                            'color' => 'linear-gradient(135deg, #60A5FA 0%, #0891B2 100%)',
                            'hr' => '#60A5FA',
                            'title' => 'Manage Wallets',
                            'desc' => 'Support for cash, bank, digital wallets like GPay or Paytm.',
                        ],
                        [
                            'icon' => 'recurring.svg',
                            'color' => 'linear-gradient(135deg, #A78BFA 0%, #7C3AED 100%)',
                            'hr' => '#A78BFA',
                            'title' => 'Recurring Transactions',
                            'desc' => 'Set monthly bills once and forget.',
                        ],
                        [
                            'icon' => 'receipt.svg',
                            'color' => 'linear-gradient(135deg, #9CA3AF 0%, #4B5563 100%)',
                            'hr' => '#9CA3AF',
                            'title' => 'Upload Receipts',
                            'desc' => 'Attach bills, invoices, or images.',
                        ],
                        [
                            'icon' => 'alert.svg',
                            'color' => 'linear-gradient(135deg, #FBBF24 0%, #F97316 100%)',
                            'hr' => '#FBBF24',
                            'title' => 'Smart Alerts',
                            'desc' => 'Budgets, due bills, and savings reminders.',
                        ],
                    ];
                @endphp

                @foreach ($features as $feature)
                    <div
                        class="bg-white rounded-3xl shadow-2xl p-6 sm:p-10 flex flex-col items-center justify-center relative w-full h-[320px] sm:h-[320px] md:w-[260px]">
                        <div class="items-start w-full">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center rounded-full mb-4 sm:mb-5"
                                style="background: {{ $feature['color'] }};">
                                <img src="{{ asset('assets/svg/' . $feature['icon']) }}" alt="{{ $feature['title'] }}"
                                    class="w-8 h-8 sm:w-10 sm:h-10">
                            </div>
                            <p class="font-semibold mb-3 sm:mb-5 text-lg sm:text-xl text-gray-900 text-left w-full">
                                {{ $feature['title'] }}
                            </p>
                            <hr class="w-16 sm:w-24 my-2 ml-0"
                                style="border-top: 4px solid {{ $feature['hr'] }}; border-radius: 50px;">
                            <p class="text-gray-600 text-sm text-left mt-3 sm:mt-5 w-full">
                                {{ $feature['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works"
        class="py-16 sm:py-20 text-center shadow-[0_30px_40px_-20px_rgba(0,0,0,0.08)_inset] bg-gradient-to-b from-white to-blue-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <h2 class="text-2xl sm:text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">
                Getting started is easy. In just a few steps, you'll be tracking your expenses and building better
                financial habits.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 sm:gap-10">

                @php
                    $steps = [
                        [
                            'icon' => 'signup-step.svg',
                            'color' => 'from-emerald-400 to-emerald-600',
                            'step' => 'STEP 1',
                            'title' => 'Sign Up & Set Up Your Wallets',
                            'desc' =>
                                'Create your free account and add your cash, bank, or digital wallets like GPay or Paytm.',
                        ],
                        [
                            'icon' => 'transaction-step.svg',
                            'color' => 'from-violet-400 to-purple-600',
                            'step' => 'STEP 2',
                            'title' => 'Log Your Income & Spending',
                            'desc' =>
                                'Enter your daily expenses and incomes by selecting the category, type, and payment method.',
                        ],
                        [
                            'icon' => 'report-step.svg',
                            'color' => 'from-amber-400 to-orange-500',
                            'step' => 'STEP 3',
                            'title' => 'Understand Where Your Money Goes',
                            'desc' =>
                                'Get visual insights with bar charts, monthly summaries, and category-wise breakdowns.',
                        ],
                        [
                            'icon' => 'alert-step.svg',
                            'color' => 'from-indigo-400 to-indigo-700',
                            'step' => 'STEP 4',
                            'title' => 'Set Budgets and Get Alerts',
                            'desc' =>
                                'Add budget goals and receive alerts before overspending. Build savings with smart reminders.',
                        ],
                    ];
                @endphp
                @foreach ($steps as $step)
                    <div
                        class="bg-white rounded-3xl shadow-lg p-6 flex flex-col items-start justify-start text-left h-auto sm:h-[330px]">
                        <div class="bg-gradient-to-br {{ $step['color'] }} p-4 rounded-full mb-4 mt-2 sm:mt-4"
                            style="box-shadow: inset 0 4px 10px rgba(0, 0, 0, 0.25);">
                            <img src="{{ asset('assets/svg/' . $step['icon']) }}" alt="Icon" class="w-8 h-8"
                                style="filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.25));" />
                        </div>
                        <span
                            class="text-xs bg-indigo-600 text-white px-3 py-1 rounded-full font-semibold mb-3 inline-block">
                            {{ $step['step'] }}
                        </span>
                        <h3 class="text-md font-bold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                        <p class="text-sm text-gray-600">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- FAQ -->
    <section id="faq" class="py-16 sm:py-20 bg-white text-gray-800">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-2xl sm:text-4xl font-bold text-center mb-4 sm:mb-6">Frequently Asked Questions</h2>
            <p class="text-center text-gray-500 mb-8 sm:mb-12 text-sm sm:text-base">Everything you need to know
                about
                Duo Dev Expenses</p>

            @php
                $faqs = [
                    [
                        'question' => 'What is Duo Dev Expenses?',
                        'answer' =>
                            'Duo Dev Expenses is a simple and powerful tool to help you manage your personal finances. You can track daily spending, set budgets, manage wallets, and get insights — all in one place.',
                    ],
                    [
                        'question' => 'Is Duo Dev Expenses free to use?',
                        'answer' =>
                            'Yes! Duo Dev Expenses is completely free to use. We’re focused on helping individuals build better financial habits without cost.',
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
                        'question' => 'Who built Duo Dev Expenses?',
                        'answer' =>
                            'Duo Dev Expenses is proudly built by Duo Dev Technologies, with the goal of making personal finance simple and accessible for everyone.',
                    ],
                ];
            @endphp

            <div class="space-y-2 sm:space-y-4" x-data="{ open: null }">
                @foreach ($faqs as $i => $faq)
                    <div class="border-b">
                        <button @click="open === {{ $i + 1 }} ? open = null : open = {{ $i + 1 }}"
                            class="w-full flex justify-between items-center text-left py-3 sm:py-4 font-semibold text-base sm:text-lg">
                            <span class="flex-1 pr-2">{{ $faq['question'] }}</span>
                            <span x-show="open !== {{ $i + 1 }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <span x-show="open === {{ $i + 1 }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="open === {{ $i + 1 }}" x-collapse
                            class="pb-3 sm:pb-4 text-sm text-gray-600">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-10 sm:mt-16 flex justify-center">
                <a href="{{ route('register') }}"
                    class="bg-[#4F46E5] text-white w-full max-w-xs sm:max-w-4xl px-4 sm:px-8 py-2 sm:py-3 rounded-full text-sm sm:text-lg font-semibold shadow hover:bg-indigo-700 transition text-center">
                    Start Tracking Your Expenses Today
                </a>
            </div>
            <p class="text-xs sm:text-sm text-gray-500 text-center mt-3">No ads. No credit card required.</p>
        </div>
    </section>

</x-guest-layout>
