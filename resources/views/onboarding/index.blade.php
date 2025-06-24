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


    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTqe75FO2hSi_RMgpZ5ULQ60-hKIGulio&libraries=places,marker&loading=async">
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-google-analytics-head />
</head>

<body class="font-sans antialiased bg-blue-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-2xl mx-auto px-4 py-5">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">Welcome! Let's Set Things Up</h2>

        <div x-data="{ step: {{ $step ?? 1 }}, next() { if (this.step < 4) this.step++ }, prev() { if (this.step > 1) this.step-- }, complete() { document.getElementById('onboardingForm').submit(); } }" class="bg-white rounded-xl shadow-lg p-8">

            <!-- Step Indicators -->
            <div class="relative flex items-center justify-between mb-10">
                <!-- Connecting Lines -->
                <div class="absolute top-4 left-0 w-full flex justify-evenly z-0">
                    <div class="">
                        <div class="h-0.5 bg-gray-400 mx-auto w-10"></div>
                    </div>
                    <div class="">
                        <div class="h-0.5 bg-gray-400 mx-auto w-10"></div>
                    </div>
                    <div class="">
                        <div class="h-0.5 bg-gray-400 mx-auto w-10"></div>
                    </div>
                </div>

                <!-- Step Indicators -->
                <template x-for="i in 4">
                    <div class="relative z-10 flex-1">
                        <div class="flex flex-col items-center">
                            <div :class="step === i ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-600'"
                                class="w-8 h-8 flex items-center justify-center rounded-full font-semibold transition">
                                <span x-text="i"></span>
                            </div>
                            <div class="text-xs mt-2 text-center text-gray-500"
                                x-text="['Wallets', 'Categories', 'People', 'Preferences'][i-1]"></div>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    <h3 class="font-semibold">Please fix the following errors:</h3>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="onboardingForm" method="POST" action="{{ route('onboarding.complete') }}">
                @csrf

                <!-- STEP 1: Wallets -->
                <div x-show="step === 1">
                    <h3 class="text-xl font-semibold mb-6">Step 1: Create Wallets</h3>

                    <!-- Wallet Type -->
                    <div class="mb-4">
                        <label for="wallet_type_id" class="block text-sm font-medium text-gray-700">Wallet Type</label>
                        <select name="wallet_type_id" id="wallet_type_id" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                            <option value="">Select Type</option>
                            @foreach ($walletTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('wallet_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('wallet_type_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="wallet_name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="wallet_name" id="wallet_name" value="{{ old('wallet_name') }}"
                            required class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                        @error('wallet_name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Balance -->
                    <div class="mb-4">
                        <label for="balance" class="block text-sm font-medium text-gray-700">Balance</label>
                        <input type="number" name="balance" id="balance" value="{{ old('balance', 0) }}" required
                            min="0" step="0.01" class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                        @error('balance')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Currency -->
                    <div class="mb-4">
                        <label for="currency_id" class="block text-sm font-medium text-gray-700">Currency</label>
                        <select name="currency_id" id="currency_id" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                            <option value="">Select Currency</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    {{ old('currency_id') == $currency->id ? 'selected' : '' }}>{{ $currency->name }}
                                    ({{ $currency->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('currency_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- STEP 2: Categories -->
                <div x-show="step === 2">
                    <h3 class="text-xl font-semibold mb-6">Step 2: Create Categories</h3>
                    <div class="mb-4">
                        <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                        <input type="text" name="category_name" id="category_name"
                            value="{{ old('category_name') }}" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                        @error('category_name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- STEP 3: Expense People -->
                <div x-show="step === 3">
                    <h3 class="text-xl font-semibold mb-6">Step 3: Add Expense People</h3>
                    <div class="mb-4">
                        <label for="expense_person_name" class="block text-sm font-medium text-gray-700">Person
                            Name</label>
                        <input type="text" name="expense_person_name" id="expense_person_name"
                            value="{{ old('expense_person_name') }}" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                        @error('expense_person_name')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- STEP 4: Preferences -->
                <div x-show="step === 4">
                    <h3 class="text-xl font-semibold mb-6">Step 4: Preferences</h3>
                    <div class="mb-4">
                        <label for="default_currency_id" class="block text-sm font-medium text-gray-700">Default
                            Currency</label>
                        <select name="default_currency_id" id="default_currency_id" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                            <option value="">Select Default Currency</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}"
                                    {{ old('default_currency_id') == $currency->id ? 'selected' : '' }}>
                                    {{ $currency->name }} ({{ $currency->code }})</option>
                            @endforeach
                        </select>
                        @error('default_currency_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="default_timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                        <select name="default_timezone" id="default_timezone" required
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg">
                            <option value="">Select Timezone</option>
                            @foreach ($timezones as $timezone)
                                <option value="{{ $timezone }}"
                                    {{ old('default_timezone') == $timezone ? 'selected' : '' }}>{{ $timezone }}
                                </option>
                            @endforeach
                        </select>
                        @error('default_timezone')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-8 flex justify-between">
                    <button type="button" @click="prev" :disabled="step === 1"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">Back</button>

                    <template x-if="step < 4">
                        <button type="button" @click="next" id="nextButton"
                            class="px-6 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white">Next</button>
                    </template>

                    <template x-if="step === 4">
                        <button type="button" @click="complete"
                            class="px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white">Finish</button>
                    </template>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#currency_id', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });

            new TomSelect('#default_currency_id', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });

            new TomSelect('#timezone', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        });
    </script>

</body>

</html>
