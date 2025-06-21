<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .nav-link::after {
            content: '';
            display: block;
            height: 2px;
            width: 60%;
            margin: 0 auto;
            background: #2563eb;
            transform: scaleX(0);
            transition: transform 0.3s;
            transform-origin: center;
        }

        .nav-link:hover::after,
        .nav-link.text-blue-600::after {
            transform: scaleX(1);
        }

        @media (max-width: 768px) {
            .nav-link::after {
                width: 70%;
                height: 1.5px;
                margin: 0;
                /* Remove auto margin */
                margin-left: 0;
                /* Align to left */
                left: 0;
                right: auto;
                transform-origin: left;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">
    <!-- Navbar -->
    <header id="main-navbar"
        class="flex justify-between items-center p-4 shadow-sm bg-white z-50 transition-all duration-300 fixed top-0 left-0 w-full"
        x-data="{ openNav: false }">
        <h1 class="text-lg font-bold ml-2 md:ml-0">Expense Tracker</h1>
        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
            <button @click="openNav = !openNav" class="focus:outline-none p-1 ml-0">
                <svg x-show="!openNav" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="openNav" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Mobile menu -->
            <div x-show="openNav" x-transition
                class="absolute top-full left-0 w-full bg-white shadow-lg flex flex-col items-start py-4 space-y-2 md:hidden z-50 pl-4">
                @php
                    $nav = [
                        ['href' => '#home', 'label' => 'Home'],
                        ['href' => '#features', 'label' => 'Features'],
                        ['href' => '#how-it-works', 'label' => 'How It Works'],
                        ['href' => '#faq', 'label' => 'FAQ'],
                    ];
                @endphp
                @foreach ($nav as $item)
                    <a href="{{ $item['href'] }}"
                        class="nav-link px-3 py-1 rounded transition block text-left text-base w-auto
                            @if (request()->get('section') === ltrim($item['href'], '#')) text-blue-600 font-semibold @endif"
                        @click="openNav = false">
                        {{ $item['label'] }}
                    </a>
                @endforeach
                <a href="{{ route('login') }}"
                    class="nav-link px-3 py-1 rounded transition block text-left text-base w-auto
                        @if (Route::currentRouteName() === 'login') text-blue-600 font-semibold @endif"
                    @click="openNav = false">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-4 py-1 rounded-full hover:bg-blue-700 transition font-semibold shadow block text-left text-base w-auto
                        @if (Route::currentRouteName() === 'register') ring-2 ring-blue-400 @endif"
                    @click="openNav = false">
                    Sign Up
                </a>
            </div>
        </div>
        <!-- Desktop nav -->
        <nav class="hidden md:flex items-center gap-2 md:gap-4">
            @foreach ($nav as $item)
                <a href="{{ $item['href'] }}"
                    class="relative nav-link flex flex-col items-center px-3 py-1 rounded transition
                        @if (request()->get('section') === ltrim($item['href'], '#')) text-blue-600 font-semibold @endif">
                    <span class="z-10">{{ $item['label'] }}</span>
                </a>
            @endforeach
            @auth
                <a href="{{ route('dashboard') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-full ml-2 hover:bg-blue-700 transition font-semibold shadow">
                    <span class="z-10">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="relative nav-link flex flex-col items-center px-3 py-1 rounded transition bg-red-600 text-white hover:bg-red-700">
                        <span class="z-10">Logout</span>
                    </button>
                </form>
            @endauth
            @if (!auth()->check())
                <a href="{{ route('login') }}"
                    class="relative nav-link flex flex-col items-center px-3 py-1 rounded transition
                    @if (Route::currentRouteName() === 'login') text-blue-600 font-semibold @endif">
                    <span class="z-10">Sign In</span>
                </a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-5 py-2 rounded-full ml-2 hover:bg-blue-700 transition font-semibold shadow
                    @if (Route::currentRouteName() === 'register') ring-2 ring-blue-400 @endif">
                    Sign Up
                </a>
            @endif
        </nav>
    </header>

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
            <img src="{{ asset('assets/landing.svg') }}" alt="Illustration"
                class="w-4/5 max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
        </div>
    </section>


    <!-- Features -->
    <section id="features" class="text-center py-16 relative"
        style="background: url('{{ asset('assets/Features_BG.png') }}') center center / cover no-repeat; min-height: 100vh; box-shadow: 0 -30px 40px -20px rgba(0,0,0,0.08) inset, 0 30px 40px -20px rgba(0,0,0,0.08) inset;">
        <div class="relative z-10 mx-auto max-w-[58rem] px-2 sm:px-6">
            <h2 class="text-3xl sm:text-4xl font-bold mb-8">Why Use Expense Tracker</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-10 px-2 sm:px-10">
                @php
                    $features = [
                        [
                            'icon' => 'money-bag.svg',
                            'color' => 'linear-gradient(135deg, #059669 0%, #34D399 100%)',
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
                                <img src="{{ asset('assets/' . $feature['icon']) }}" alt="{{ $feature['title'] }}"
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
                            'icon' => 'transaction-icon.svg',
                            'color' => 'from-green-500 to-emerald-400',
                            'step' => 'STEP 1',
                            'title' => 'Sign Up & Set Up Your Wallets',
                            'desc' =>
                                'Create your free account and add your cash, bank, or digital wallets like GPay or Paytm.',
                        ],
                        [
                            'icon' => 'wallet-icon.svg',
                            'color' => 'from-purple-500 to-violet-400',
                            'step' => 'STEP 2',
                            'title' => 'Log Your Income & Spending',
                            'desc' =>
                                'Enter your daily expenses and incomes by selecting the category, type, and payment method.',
                        ],
                        [
                            'icon' => 'graph-icon.svg',
                            'color' => 'from-yellow-400 to-orange-500',
                            'step' => 'STEP 3',
                            'title' => 'Understand Where Your Money Goes',
                            'desc' =>
                                'Get visual insights with bar charts, monthly summaries, and category-wise breakdowns.',
                        ],
                        [
                            'icon' => 'alert-icon.svg',
                            'color' => 'from-blue-400 to-sky-500',
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
                        <div class="bg-gradient-to-br {{ $step['color'] }} p-4 rounded-full mb-4 mt-2 sm:mt-4">
                            <img src="{{ asset('assets/' . $step['icon']) }}" alt="Icon" class="w-8 h-8" />
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
            <p class="text-center text-gray-500 mb-8 sm:mb-12 text-sm sm:text-base">Everything you need to know about
                Expense Tracker</p>

            @php
                $faqs = [
                    [
                        'question' => 'What is Expense Tracker?',
                        'answer' =>
                            'Expense Tracker is a simple and powerful tool to help you manage your personal finances. You can track daily spending, set budgets, manage wallets, and get insights — all in one place.',
                    ],
                    [
                        'question' => 'Is Expense Tracker free to use?',
                        'answer' =>
                            'Yes! Expense Tracker is completely free to use. We’re focused on helping individuals build better financial habits without cost.',
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
                        'question' => 'Who built Expense Tracker?',
                        'answer' =>
                            'Expense Tracker is proudly built by Duo Dev Technologies, with the goal of making personal finance simple and accessible for everyone.',
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

    <!-- Footer -->
    <footer class="bg-[#0F172A] text-white py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
            <!-- Quick Links -->
            <div>
                <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#faq" class="hover:text-white">FAQ</a></li>
                    <li><a href="#terms" class="hover:text-white">Terms of Service</a></li>
                    <li><a href="#privacy" class="hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="mt-4 md:mt-0"> <!-- decreased mt for mobile -->
                <h3 class="font-semibold text-lg mb-3">Contact</h3>
                <div class="flex items-center space-x-2 text-gray-300 text-sm">
                    <svg width="22" height="22" viewBox="0 0 30 30" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M25 5C27.0711 5 28.75 6.67894 28.75 8.75V21.25C28.75 23.3211 27.0711 25 25 25H5C2.92894 25 1.25 23.3211 1.25 21.25V8.75C1.25 6.67894 2.92894 5 5 5H25ZM24.0661 7.5H5.93398L14.2255 14.0459C14.6796 14.4045 15.3204 14.4045 15.7746 14.0459L24.0661 7.5ZM3.75 8.961V21.25C3.75 21.9404 4.30965 22.5 5 22.5H25C25.6904 22.5 26.25 21.9404 26.25 21.25V8.96102L17.3236 16.0081C15.9613 17.0838 14.0387 17.0838 12.6764 16.0081L3.75 8.961Z"
                            fill="white" />
                    </svg>
                    <span class="break-all">contact@duodev.in</span>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="mt-4 md:mt-0"> <!-- decreased mt for mobile -->
                <h3 class="font-semibold text-lg mb-3">Subscribe to our newsletter</h3>
                <p class="text-xs text-gray-300 mb-3">Get product updates & tips in your inbox</p>
                <form class="flex flex-row items-stretch max-w-sm w-full gap-1">
                    <input type="email" placeholder="Your Email"
                        class="flex-1 px-3 py-2 rounded-l-full text-gray-800 text-sm focus:outline-none" />
                    <button type="submit"
                        class="px-3 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-r-full text-sm font-semibold">Subscribe</button>
                </form>
            </div>
        </div>
        </div>

        <!-- Bottom Text -->
        <div class="text-center text-sm text-gray-400 mt-10 px-4">
            <strong class="text-white">Expense Tracker</strong> — A personal finance management product by
            <strong class="text-white">Duo Dev Technologies</strong>.
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Active nav on scroll and click
        function setActiveNav() {
            const sections = ['home', 'features', 'how-it-works', 'faq'];
            let scrollPos = window.scrollY + 10 + document.getElementById('main-navbar').offsetHeight;
            let found = false;
            for (let i = sections.length - 1; i >= 0; i--) {
                const el = document.getElementById(sections[i]) || document.querySelector(`[id='${sections[i]}']`);
                if (el && el.offsetTop <= scrollPos) {
                    document.querySelectorAll('.nav-link').forEach(a => a.classList.remove('text-blue-600',
                        'font-semibold'));
                    document.querySelectorAll('.nav-link').forEach(a => {
                        if (a.getAttribute('href') === '#' + sections[i]) {
                            a.classList.add('text-blue-600', 'font-semibold');
                        }
                    });
                    found = true;
                    break;
                }
            }
            if (!found) {
                document.querySelectorAll('.nav-link').forEach(a => a.classList.remove('text-blue-600', 'font-semibold'));
            }
        }
        window.addEventListener('scroll', setActiveNav);
        window.addEventListener('DOMContentLoaded', setActiveNav);

        // Smooth scroll and offset for navbar height
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        const navbarHeight = document.getElementById('main-navbar').offsetHeight;
                        const top = target.getBoundingClientRect().top + window.scrollY - navbarHeight + 1;
                        window.scrollTo({
                            top,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>
</body>

</html>
