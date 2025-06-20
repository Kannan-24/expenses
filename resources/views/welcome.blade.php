<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        body {
            padding-top: 84px;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 72px;
            }
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans">
    <!-- Navbar -->
    <header id="main-navbar"
        class="flex justify-between items-center p-6 shadow-sm bg-white z-50 transition-all duration-300 fixed top-0 left-0 w-full ">
        <h1 class="text-lg font-bold">Expense Tracker</h1>
        <nav class="flex items-center gap-2 md:gap-4">
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
                    class="relative nav-link flex flex-col items-center px-3 py-1 rounded transition
                       @if (request()->get('section') === ltrim($item['href'], '#')) text-blue-600 font-semibold @endif">
                    <span class="z-10">{{ $item['label'] }}</span>
                </a>
            @endforeach
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
        </nav>
    </header>
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

    <!-- Hero Section -->
    <section id="home" class="flex flex-col md:flex-row justify-between items-center px-10 py-20 bg-gray-50"
        style="font-family: 'Poppins', 'Roboto', sans-serif;">
        <div class="flex-1 flex flex-col justify-center items-start md:pr-12 pl-2 md:pl-12">
            <h2 class="text-6xl md:text-7xl font-bold mb-4 leading-tight text-black"
                style="font-family: 'Poppins', 'Roboto', sans-serif;">
                Take control of<br>
                <span class="text-black">Your money</span>
            </h2>
            <p class="mb-4 text-gray-400 text-lg md:text-sm">Track your income, spending, and savings with ease.</p>
            <button
                class="bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold shadow hover:bg-blue-700 transition">Get
                Started</button>
        </div>
        <div class="flex-1 flex justify-center items-center mt-10 md:mt-0">
            <img src="{{ asset('assets/landing.svg') }}" alt="Illustration" class="w-full max-w-md">
        </div>
    </section>
    <!-- Google Fonts for Poppins/Roboto -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&family=Roboto:wght@700;900&display=swap"
        rel="stylesheet">

    <!-- Features -->
    <section id="features" class="text-center py-16 relative"
        style="background: url('{{ asset('assets/Features_BG.png') }}') center center / cover no-repeat; min-height: 100vh;">
        <div class="relative z-10 max-w-6xl mx-auto">
            <h2 class="text-5xl font-bold mb-8">Why Use Expense Tracker</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 px-10">
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #059669 0%, #34D399 100%);">
                        <img src="{{ asset('assets/money-bag.svg') }}" alt="Money Bag" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Track Every Rupee</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #34D399; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Add your daily expenses with category and
                        payment
                        method.</p>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #2563eb 0%, #60a5fa 100%);">
                        <img src="{{ asset('assets/insight.svg') }}" alt="Visual Insights" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Visual Insights</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #2563eb; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Understand your habits with graphs and
                        reports.</p>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #60A5FA 0%, #0891B2 100%);">
                        <img src="{{ asset('assets/wallet.svg') }}" alt="Manage Wallets" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Manage Wallets</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #60A5FA; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Support for cash, bank, digital wallets like
                        GPay
                        or Paytm.</p>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #A78BFA 0%, #7C3AED 100%);">
                        <img src="{{ asset('assets/recurring.svg') }}" alt="Recurring Transactions" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Recurring Transactions</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #A78BFA; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Set monthly bills once and forget.</p>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #9CA3AF 0%, #4B5563 100%);">
                        <img src="{{ asset('assets/receipt.svg') }}" alt="Upload Receipts" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Upload Receipts</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #9CA3AF; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Attach bills, invoices, or images.</p>
                </div>
                <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-start relative">
                    <div class="w-16 h-16 flex items-center justify-center rounded-full mb-4"
                        style="background: linear-gradient(135deg, #FBBF24 0%, #F97316 100%);">
                        <img src="{{ asset('assets/alert.svg') }}" alt="Smart Alerts" class="w-10 h-10">
                    </div>
                    <p class="font-semibold mb-3 text-xl text-gray-900 text-left w-full">Smart Alerts</p>
                    <hr class="w-24 my-2 ml-0" style="border-top: 4px solid #FBBF24; border-radius: 50px;">
                    <p class="text-gray-600 text-sm text-left mt-3 w-full">Budgets, due bills, and savings reminders.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-16 bg-white text-center">
        <h2 class="text-2xl font-bold mb-6">How It Works</h2>
        <p class="mb-12">Getting started is easy. In just a few steps, you'll be tracking your expenses and building
            better financial habits.</p>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 px-6">
            <div class="bg-blue-50 p-6 rounded shadow">
                <p class="text-sm font-bold mb-2">STEP 1</p>
                <p class="font-semibold mb-2">Sign Up & Set Up Your Wallets</p>
                <p>Create your free account and add cash, bank, or digital wallets like GPay or Paytm.</p>
            </div>
            <div class="bg-blue-50 p-6 rounded shadow">
                <p class="text-sm font-bold mb-2">STEP 2</p>
                <p class="font-semibold mb-2">Track Your Expenses</p>
                <p>Log daily expenses and categorize them easily.</p>
            </div>
            <div class="bg-blue-50 p-6 rounded shadow">
                <p class="text-sm font-bold mb-2">STEP 3</p>
                <p class="font-semibold mb-2">Understand Where Your Money Goes</p>
                <p>Get visual insights with bar charts, summaries, and breakdowns.</p>
            </div>
            <div class="bg-blue-50 p-6 rounded shadow">
                <p class="text-sm font-bold mb-2">STEP 4</p>
                <p class="font-semibold mb-2">Set Budgets and Get Alerts</p>
                <p>Add budget goals and get alerts before overspending.</p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="bg-gray-100 py-16">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold mb-8 text-center">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <details class="bg-white p-4 rounded shadow">
                    <summary class="cursor-pointer font-medium">What is Expense Tracker?</summary>
                    <p class="mt-2 text-sm">A tool to manage personal finances, track daily spending, set budgets, and
                        get insights.</p>
                </details>
                <details class="bg-white p-4 rounded shadow">
                    <summary class="cursor-pointer font-medium">Is Expense Tracker free to use?</summary>
                    <p class="mt-2 text-sm">Yes, it's completely free. No ads or credit card required.</p>
                </details>
                <details class="bg-white p-4 rounded shadow">
                    <summary class="cursor-pointer font-medium">Can I manage both cash and bank transactions?</summary>
                    <p class="mt-2 text-sm">Yes, you can add and track multiple wallet types.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="text-center py-10">
        <button class="bg-blue-600 text-white px-6 py-3 rounded-full text-lg">Start Tracking Your Expenses
            Today</button>
        <p class="text-sm text-gray-600 mt-2">No ads. No credit card required.</p>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-sm px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="font-semibold mb-2">Quick Links</h3>
                <ul>
                    <li><a href="#faq" class="hover:underline">FAQ</a></li>
                    <li><a href="#" class="hover:underline">Terms of Service</a></li>
                    <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Contact</h3>
                <p>contact@duodev.in</p>
            </div>
            <div>
                <h3 class="font-semibold mb-2">Subscribe to our newsletter</h3>
                <div class="flex">
                    <input type="email" placeholder="Your Email" class="p-2 rounded-l text-black">
                    <button class="bg-blue-600 px-4 py-2 rounded-r">Subscribe</button>
                </div>
            </div>
        </div>
        <p class="text-center mt-10">Expense Tracker — A personal finance management product by <span
                class="font-semibold">Duo Dev Technologies</span>.</p>
    </footer>
</body>

</html>
