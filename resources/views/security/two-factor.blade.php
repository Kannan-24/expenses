<x-app-layout>
    <x-slot name="title">
        {{ __('Security - Two Factor') }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Two-Factor Authentication</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-2">
                                    <li>
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-200 hover:text-white">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Security</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @if(session('success'))
                    <div class="p-3 bg-green-100 text-green-800 rounded-xl shadow">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="p-3 bg-red-100 text-red-800 rounded-xl shadow">{{ $errors->first() }}</div>
                @endif

                @if(!$user->two_factor_enabled && !$pendingSecret)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <form method="POST" action="{{ route('security.2fa.start') }}" class="space-y-4">
                            @csrf
                            <p class="text-gray-700 dark:text-gray-300">Enable two-factor authentication to protect your account.</p>
                            <div>
                                <label class="block text-sm font-medium mb-1">Current Password</label>
                                <input type="password" name="password" required class="w-full border rounded px-3 py-2" />
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold shadow hover:bg-blue-700 transition">Generate QR Code</button>
                        </form>
                    </div>
                @endif

                @if($pendingSecret)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300">Scan this QR code in Google Authenticator then enter the 6-digit code to confirm.</p>
                        <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-4">
                            @php $qr = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data='.urlencode($qrUrl); @endphp
                            <img src="{{ $qr }}" alt="QR Code" class="rounded-xl shadow" />
                        </div>
                        <p class="break-all text-xs bg-gray-100 dark:bg-gray-800 p-2 rounded-xl text-gray-700 dark:text-gray-300 text-center">Secret: {{ $pendingSecret }}</p>
                        <form method="POST" action="{{ route('security.2fa.confirm') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium mb-1">Authenticator Code</label>
                                <input type="text" name="otp" inputmode="numeric" pattern="[0-9]*" required class="w-full border rounded px-3 py-2 tracking-widest" />
                            </div>
                            <button class="px-4 py-2 bg-green-600 text-white rounded-xl font-semibold shadow hover:bg-green-700 transition">Confirm & Enable</button>
                        </form>
                    </div>
                @endif

                @if($user->two_factor_enabled)
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                        <h2 class="font-semibold">Status: <span class="text-green-600">Enabled</span></h2>
                        <form method="POST" action="{{ route('security.2fa.disable') }}" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium mb-1">Current Password</label>
                                <input type="password" name="password" required class="w-full border rounded px-3 py-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Authenticator Code</label>
                                <input type="text" name="otp" inputmode="numeric" pattern="[0-9]*" required class="w-full border rounded px-3 py-2 tracking-widest text-center" />
                            </div>
                            <button class="px-4 py-2 bg-red-600 text-white rounded-xl font-semibold shadow hover:bg-red-700 transition">Disable 2FA</button>
                        </form>
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 space-y-4">
                        <h3 class="font-semibold">Trusted Devices</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Devices marked trusted skip OTP challenge.</p>
                        @if(isset($isCurrentTrusted) && !$isCurrentTrusted)
                            <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 text-blue-800 dark:text-blue-200 text-xs p-3 rounded-xl">
                                <p class="mb-2 font-medium">Trust This Device?</p>
                                <p class="mb-3">Enter a current authenticator code to mark this browser as trusted and skip future OTP prompts here.</p>
                                <form method="POST" action="{{ route('security.device.trust') }}" class="flex items-center space-x-2">
                                    @csrf
                                    <input type="text" name="otp" inputmode="numeric" pattern="[0-9]*" required placeholder="123456" class="w-28 border rounded px-2 py-1 text-center tracking-widest" />
                                    <button class="px-3 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-semibold shadow hover:bg-blue-700 transition">Trust Device</button>
                                </form>
                            </div>
                        @elseif(isset($isCurrentTrusted) && $isCurrentTrusted)
                            <div class="bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 text-xs p-3 rounded-xl flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>This device is trusted.</span>
                            </div>
                        @endif
                        <ul class="divide-y">
                            @forelse($user->trustedDevices as $device)
                                <li class="py-2 flex justify-between items-center text-sm">
                                    <div>
                                        <p class="font-medium">{{ $device->display_name }} <span class="text-xs text-gray-500">{{ $device->ip }}</span></p>
                                        <p class="text-xs text-gray-500">Last used {{ optional($device->last_used_at)->diffForHumans() }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('security.device.remove',$device) }}" onsubmit="return confirm('Remove device?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline text-xs">Remove</button>
                                    </form>
                                </li>
                            @empty
                                <li class="py-2 text-xs text-gray-500">No trusted devices yet.</li>
                            @endforelse
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
