<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms of Service | Expense Tracker - An Personal Finance Tracking App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .nav-link {
            position: relative;
        }

        .nav-link::after {
            content: '';
            display: block;
            height: 2px;
            width: 0;
            margin: 0 auto;
            position: absolute;
            bottom: -2px;
            background: #2563eb;
            transition: width 0.3s ease-in-out;
        }

        .nav-link:hover::after,
        .nav-link.text-blue-600::after {
            width: 20px;
        }

        @media (max-width: 768px) {
            .nav-link::after {
                width: 20px;
                height: 1.5px;
                margin: 0;
                margin-left: 0;
                left: 0;
                right: auto;
            }
        }
    </style>

    <x-google-analytics-head />
</head>

<body class="bg-white text-gray-800 font-sans">
    <x-google-analytics-body />

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
                        ['href' => '/#home', 'label' => 'Home'],
                        ['href' => '/#features', 'label' => 'Features'],
                        ['href' => '/#how-it-works', 'label' => 'How It Works'],
                        ['href' => '/#faq', 'label' => 'FAQ'],
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


    <div class="mt-24">
        <div class="w-full mx-auto max-w-4xl sm:px-6 lg:px-8 p-6 m-4">
            <h3 class="text-3xl text-center font-bold mb-6 text-gray-800">Terms of Service</h3>

            <p class="mb-4 text-gray-700">
                These Terms of Service ("Terms") govern your access to and use of all services, products, and websites
                (collectively, the "Services") provided by Duo Dev Technologies ("we", "our", or "us") through
                https://duodev.in.
                By using our Services, you agree to these Terms in full. If you do not agree to these Terms, you must
                not access or use the Services.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">1. Eligibility</h4>
            <p class="mb-4 text-gray-700">
                You must be at least 18 years of age to use our Services. By using our Services, you represent and
                warrant that you are at least 18 years old and have the legal capacity to enter into a binding
                agreement.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">2. Account Registration</h4>
            <p class="mb-4 text-gray-700">
                You may be required to create an account to access certain features. You agree to provide accurate and
                complete information when creating your account and to keep it up to date. You are responsible for
                maintaining the confidentiality of your account credentials and for all activities that occur under your
                account.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">3. Use of Services</h4>
            <p class="mb-4 text-gray-700">
                You agree to use the Services only for lawful purposes and in accordance with these Terms. You must not
                use the Services to violate any applicable laws or regulations, infringe intellectual property rights,
                or transmit harmful or malicious content.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">4. Payment and Subscriptions</h4>
            <p class="mb-4 text-gray-700">
                Some parts of the Services may require payment or subscription. You agree to pay all fees and charges
                associated with your use of paid Services. All payments are non-refundable except as required by law.
                Subscriptions may auto-renew unless cancelled before the billing cycle.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">5. Intellectual Property</h4>
            <p class="mb-4 text-gray-700">
                All content, trademarks, logos, and intellectual property on the Services are owned by Duo Dev
                Technologies or our licensors. You may not reproduce, modify, or distribute any content without our
                prior written consent.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">6. Termination</h4>
            <p class="mb-4 text-gray-700">
                We may suspend or terminate your access to the Services at any time, with or without cause or notice.
                Upon termination, all licenses and rights granted to you under these Terms will immediately cease.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">7. Disclaimer of Warranties</h4>
            <p class="mb-4 text-gray-700">
                The Services are provided "as is" and "as available" without warranties of any kind, either express or
                implied. We do not guarantee that the Services will be uninterrupted, error-free, or free from viruses
                or other harmful components.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">8. Limitation of Liability</h4>
            <p class="mb-4 text-gray-700">
                To the maximum extent permitted by law, Duo Dev Technologies shall not be liable for any indirect,
                incidental, consequential, or punitive damages, or any loss of data, revenue, or profits arising out of
                or in connection with your use of the Services.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">9. Privacy Policy</h4>
            <p class="mb-4 text-gray-700">
                Your use of the Services is also governed by our Privacy Policy, which is available at <a
                    href="https://duodev.in/privacy" class="text-blue-600 underline">https://duodev.in/privacy</a>.
                Please review it to understand how we collect, use, and protect your data.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">10. Changes to the Terms</h4>
            <p class="mb-4 text-gray-700">
                We may update these Terms from time to time. When we do, we will revise the "Last updated" date at the
                bottom. Continued use of the Services after changes constitutes your acceptance of the updated Terms.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">11. Governing Law</h4>
            <p class="mb-4 text-gray-700">
                These Terms are governed by and construed in accordance with the laws of India. You agree to submit to
                the exclusive jurisdiction of the courts located in Tamil Nadu, India.
            </p>

            <h4 class="text-2xl font-semibold mt-6 mb-2">12. Contact Us</h4>
            <p class="mb-4 text-gray-700">
                If you have any questions about these Terms, please contact us at <a href="mailto:support@duodev.in"
                    class="text-blue-600 underline">support@duodev.in</a>.
            </p>

            <p class="mt-6 text-sm text-gray-500">
                Last updated: {{ now()->format('F j, Y') }}
            </p>
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-[#0F172A] text-white py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-4">
            <!-- Quick Links -->
            <div>
                <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="/#faq" class="hover:text-white">FAQ</a></li>
                    <li><a href="/terms-of-service" class="hover:text-white">Terms of Service</a></li>
                    <li><a href="/privacy-policy" class="hover:text-white">Privacy Policy</a></li>
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
                    <a href="mailto:support@duodev.in" class="break-all hover:underline">support@duodev.in</a>
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
            <a href="https://duodev.in" target="_blank" rel="noopener"
                class="text-white font-bold hover:underline">Duo Dev Technologies</a>.
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
