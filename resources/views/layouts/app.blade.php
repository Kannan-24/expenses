<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Cazhoo') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js-->
    <script src="//unpkg.com/alpinejs" defer></script>

    @isset($head)
        {{ $head }}
    @endisset

    <x-google-analytics-head />
</head>

<body class="font-sans antialiased bg-blue-200 dark:bg-slate-900 min-h-screen" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', value => localStorage.setItem('darkMode', value))" x-bind:class="{ 'dark': darkMode }" x-cloak>
    <x-google-analytics-body />

    <div class="pt-16 md:pt-0 bg-blue-200 dark:bg-slate-950">
        <div id="message-alert"
            class="fixed inset-x-2 bottom-5 right-2 left-2 sm:inset-x-0 sm:right-5 sm:left-auto z-50 transition-all ease-in-out duration-300 message-alert">
            <!-- Message Alert -->
            @if (session()->has('response'))
                @php
                    $message = session()->get('response') ?? [];
                    $status = match ($message['status'] ?? 'info') {
                        'success' => 'green',
                        'error' => 'red',
                        'warning' => 'yellow',
                        'info' => 'blue',
                        default => 'gray',
                    };
                @endphp

                <div class="bg-{{ $status }}-100 border border-{{ $status }}-400 text-{{ $status }}-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                    role="alert">
                    <span class="block sm:inline">{{ $message['message'] }}</span>
                </div>
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded relative w-full sm:w-72 ms-auto my-1 flex items-center text-sm sm:text-base"
                        role="alert">
                        <span class="block sm:inline">{{ $error }}</span>
                    </div>
                @endforeach
            @endif
        </div>

        @isset($header)
            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div
                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 py-4 sm:py-6 w-full sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div x-data="{
            sidebarOpen: false,
            notificationOpen: false,
            profileOpen: false,
        
            init() {
                // Close sidebar on route change (for mobile)
                this.$nextTick(() => {
                    document.addEventListener('click', (e) => {
                        if (e.target.closest('a[href]') && window.innerWidth < 1024) {
                            this.sidebarOpen = false;
                        }
                    });
                });
            },
        
            toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
            }
        }">

            @include('layouts.navigation')

            <!-- Main Content Area -->
            <div class="lg:ml-80 min-h-screen">
                <div class="p-4 lg:p-6">
                    <x-password-setup-banner />
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script>
        window.dataLayer = window.dataLayer || [];

        @if (request()->hasAny(['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content']))
            // Push UTM parameters to Data Layer
            window.dataLayer.push({
                'event': 'utm_tracking',
                'utm_source': '{{ request()->get('utm_source') }}',
                'utm_medium': '{{ request()->get('utm_medium') }}',
                'utm_campaign': '{{ request()->get('utm_campaign') }}',
                'utm_term': '{{ request()->get('utm_term') }}',
                'utm_content': '{{ request()->get('utm_content') }}',
                'referrer': '{{ request()->header('referer') }}',
                'landing_page': '{{ request()->fullUrl() }}',
                'tracking_timestamp': '{{ now()->format('Y-m-d H:i:s') }}'
            });
        @endif

        </script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-app.js";
        import { getAnalytics } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-analytics.js";
        import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/12.1.0/firebase-messaging.js";
        
        if ("serviceWorker" in navigator) {
            const swRegistration = await navigator.serviceWorker.register("/firebase-messaging-sw.js", {
                    type: "module"
                })
                .then((registration) => {
                    console.log("Service Worker registered with scope:", registration.scope);
                })
                .catch((err) => {
                    console.error("Service Worker registration failed:", err);
                });
        }
    
        // Your Firebase config
        const firebaseConfig = {
            apiKey: "AIzaSyC6DEyl86w_6NEtd6Wdtr1y27E1gWgeMNA",
            authDomain: "expences-464117.firebaseapp.com",
            projectId: "expences-464117",
            storageBucket: "expences-464117.firebasestorage.app",
            messagingSenderId: "216195529410",
            appId: "1:216195529410:web:f1b3683e8e0a70f5e5595b",
            measurementId: "G-P1YTSV6EVE"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const analytics = getAnalytics(app);
        const messaging = getMessaging(app);

        // Ask for notification permission + get token
        async function requestPermissionAndToken() {
            try {
                const permission = await Notification.requestPermission();

                if (permission === "granted") {
                    const token = await getToken(messaging, {
                        vapidKey: "{{ env('FCM_KEY_PAIR') }}",
                    });

                    if (token) {
                        console.log("FCM Token:", token);

                        // Send token to Laravel backend
                        await fetch("{{ route('store.token') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                token
                            })
                        });
                    } else {
                        console.warn("No registration token available. Request permission first.");
                    }
                } else {
                    console.log("User denied notifications.");
                }
            } catch (err) {
                console.error("Error getting permission or token:", err);
            }
        }

        requestPermissionAndToken();

        // Foreground message handling
        onMessage(messaging, (payload) => {
            console.log("Message received: ", payload);
            new Notification(payload.notification.title, {
                body: payload.notification.body,
                icon: payload.notification.image || "https://cazhoo.duodev.in/assets/Cazhoo Logo.png",
                data: {
                    url: payload.notification.action_url || "https://cazhoo.duodev.in"
                }
            });
        });
    </script>

</body>

</html>
