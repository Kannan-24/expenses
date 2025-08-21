<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Cazhoo - Professional personal finance management tool. Track expenses, manage budgets, and build better financial habits with our intuitive platform.">
    <meta name="keywords"
        content="expense tracker, budget management, personal finance, money management, financial planning">
    <meta name="author" content="Duo Dev Technologies">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Cazhoo - Take Control of Your Money">
    <meta property="og:description"
        content="The most intuitive way to track expenses, manage budgets, and build better financial habits.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Cazhoo">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Cazhoo - Take Control of Your Money">
    <meta name="twitter:description"
        content="The most intuitive way to track expenses, manage budgets, and build better financial habits.">

    <title>
        {{ $title ?? 'Cazhoo - Professional Personal Finance Management | Track, Manage & Save Money' }}
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
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-blue-200">
    <div class="flex items-center justify-center min-h-screen">
        <div class="max-w-md w-full bg-white dark:bg-gray-900 p-6 rounded shadow space-y-6">
            <h1 class="text-xl font-bold text-center">Two-Factor Verification</h1>
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded text-sm">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('auth.2fa.challenge.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Authenticator Code</label>
                    <input type="text" name="otp" inputmode="numeric" pattern="[0-9]*" autofocus required
                        class="w-full border rounded px-3 py-2 tracking-widest text-center" />
                </div>
                <label class="flex items-center space-x-2 text-sm"><input type="checkbox" name="remember_device"
                        value="1" class="rounded" /><span>Trust this device (60 days)</span></label>
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded">Verify & Continue</button>
            </form>
        </div>
    </div>
</body>

</html>
