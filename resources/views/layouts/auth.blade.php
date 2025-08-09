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

    <script src="https://accounts.google.com/gsi/client" async></script>

    <x-google-analytics-head />
</head>

<body class="font-sans antialiased bg-blue-200 min-h-screen">
    <x-google-analytics-body />

    <main class="flex w-full bg-white relative z-10 ">
        {{ $slot }}
    </main>

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

        @guest
        window.onload = function() {
            google.accounts.id.initialize({
                client_id: "{{ config('services.google.client_id') }}",
                callback: handleCredentialResponse
            });

            google.accounts.id.prompt();
        };

        function handleCredentialResponse(response) {
            // Send the JWT ID token to your Laravel backend
            fetch('/google-onetap-login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        token: response.credential
                    })
                }).then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/dashboard';
                    } else {
                        const toast = `<div class="fixed bottom-4 right-4 bg-red-600 text-white px-4 py-2 rounded shadow-lg">
                        ${data.message}
                        </div>`;
                        document.body.insertAdjacentHTML('beforeend', toast);
                        setTimeout(() => {
                            document.querySelector('.fixed.bottom-4.right-4').remove();
                        }, 4000);
                    }
                });
        }
        @endguest
    </script>
</body>

</html>
