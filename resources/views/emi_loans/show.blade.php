<x-app-layout>
    <x-slot name="title">
        {{ $emiLoan->name }} - {{ config('app.name', 'Expense Tracker') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Enhanced Header Section -->
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div
                    class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 dark:from-purple-800 dark:via-purple-900 dark:to-indigo-900 border-b border-purple-500 dark:border-purple-600 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">{{ $emiLoan->name }}</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}"
                                            class="inline-flex items-center text-purple-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-purple-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <a href="{{ route('emi-loans.index') }}"
                                            class="text-purple-200 hover:text-white transition-colors">EMI Loans</a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-purple-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-purple-100 font-medium">Details</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center space-x-3">
                            @if ($emiLoan->status !== 'closed')
                                <a href="{{ route('emi-loans.edit', $emiLoan) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-white/10 text-white font-medium rounded-lg hover:bg-white/20 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            @endif
                            <a href="{{ route('emi-loans.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-100 text-purple-700 dark:text-purple-800 font-semibold rounded-xl hover:bg-purple-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                <span class="hidden sm:inline">Back to EMI Loans</span>
                                <span class="sm:hidden">Back</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Loan Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Loan Information Card -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Loan Information
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Loan
                                        Name</label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $emiLoan->name }}
                                    </p>
                                </div>

                                @if ($emiLoan->category)
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Category</label>
                                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                                            {{ $emiLoan->category->name }}</p>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Loan
                                        Type</label>
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                        {{ $emiLoan->loan_type === 'fixed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ $emiLoan->loan_type === 'fixed' ? 'Fixed Rate' : 'Reducing Balance' }}
                                    </span>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    @if ($emiLoan->status === 'active')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                            Active
                                        </span>
                                    @elseif($emiLoan->status === 'closed')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>
                                            Closed
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                            Cancelled
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Start
                                        Date</label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $emiLoan->start_date->format('M d, Y') }}</p>
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tenure</label>
                                    <p class="text-lg font-medium text-gray-900 dark:text-white">
                                        {{ $emiLoan->tenure_months }} months</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Auto
                                        Deduction</label>
                                    @if ($emiLoan->is_auto_deduct)
                                        <span
                                            class="inline-flex items-center text-sm font-medium text-green-600 dark:text-green-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Enabled
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Disabled
                                        </span>
                                    @endif
                                </div>

                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created</label>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $emiLoan->created_at->format('M d, Y \a\t h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMI Schedule Table -->
                    @if ($emiLoan->emiSchedules->count() > 0)
                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    EMI Schedule
                                </h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Due Date</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                EMI Amount</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Principal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Interest</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($emiLoan->emiSchedules as $schedule)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    {{ $schedule->due_date->format('M d, Y') }}
                                                    @php
                                                        $daysUntilDue = now()->diffInDays($schedule->due_date, false);
                                                        $daysUntilDue = intval($daysUntilDue);
                                                        $notificationDays = env('EMI_NOTIFICATION_DAYS', 3);
                                                    @endphp
                                                    @if ($schedule->status === 'upcoming' && $daysUntilDue <= $notificationDays && $daysUntilDue >= 0)
                                                        <div class="flex items-center mt-1">
                                                            <svg class="w-4 h-4 text-amber-500 mr-1"
                                                                fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span
                                                                class="text-xs text-amber-600 dark:text-amber-400">Due
                                                                in {{ $daysUntilDue }}
                                                                day{{ $daysUntilDue != 1 ? 's' : '' }}</span>
                                                        </div>
                                                    @elseif($schedule->status === 'upcoming' && $daysUntilDue < 0)
                                                        <div class="flex items-center mt-1">
                                                            <svg class="w-4 h-4 text-red-500 mr-1" fill="currentColor"
                                                                viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span
                                                                class="text-xs text-red-600 dark:text-red-400">Overdue
                                                                by {{ abs($daysUntilDue) }}
                                                                day{{ abs($daysUntilDue) != 1 ? 's' : '' }}</span>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    ₹{{ number_format($schedule->emi_amount, 2) }}
                                                    @if ($schedule->paid_amount && $schedule->paid_amount != $schedule->emi_amount)
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            Paid: ₹{{ number_format($schedule->paid_amount, 2) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    ₹{{ number_format($schedule->principal_amount, 2) }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                    ₹{{ number_format($schedule->interest_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($schedule->status === 'paid')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                            Paid
                                                        </span>
                                                        @if ($schedule->paid_date)
                                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                {{ $schedule->paid_date->format('M d, Y') }}
                                                            </div>
                                                        @endif
                                                        @if ($schedule->wallet)
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                                via {{ $schedule->wallet->name }}
                                                            </div>
                                                        @endif
                                                    @elseif($schedule->status === 'missed')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                            Missed
                                                        </span>
                                                    @elseif($schedule->status === 'late')
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                            Late
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                            Upcoming
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if ($schedule->status !== 'paid')
                                                        <button type="button"
                                                            onclick="openPaymentModal({{ $schedule->id }}, '{{ $schedule->emi_amount }}', '{{ $schedule->due_date->format('Y-m-d') }}')"
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium rounded-lg hover:bg-green-200 dark:hover:bg-green-900/50 transition-colors">
                                                            <svg class="w-4 h-4 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Mark Paid
                                                        </button>
                                                    @else
                                                        <span
                                                            class="text-xs text-gray-500 dark:text-gray-400">Completed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Summary Cards -->
                <div class="space-y-6">
                    <!-- Financial Summary -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            Financial Summary
                        </h3>

                        <div class="space-y-4">
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                                <div class="text-sm font-medium text-blue-600 dark:text-blue-400 mb-1">Total Loan
                                    Amount</div>
                                <div class="text-2xl font-bold text-blue-700 dark:text-blue-300">
                                    ₹{{ number_format($emiLoan->total_amount, 2) }}</div>
                            </div>

                            <div
                                class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                <div class="text-sm font-medium text-purple-600 dark:text-purple-400 mb-1">Monthly EMI
                                </div>
                                <div class="text-2xl font-bold text-purple-700 dark:text-purple-300">
                                    ₹{{ number_format($emiLoan->monthly_emi, 2) }}</div>
                            </div>

                            <div
                                class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-700">
                                <div class="text-sm font-medium text-green-600 dark:text-green-400 mb-1">Interest Rate
                                </div>
                                <div class="text-2xl font-bold text-green-700 dark:text-green-300">
                                    {{ $emiLoan->interest_rate }}%</div>
                                <div class="text-xs text-green-600 dark:text-green-400">per annum</div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Summary -->
                    @if ($emiLoan->emiSchedules->count() > 0)
                        @php
                            $totalSchedules = $emiLoan->emiSchedules->count();
                            $paidSchedules = $emiLoan->emiSchedules->where('status', 'paid')->count();
                            $progressPercentage = $totalSchedules > 0 ? ($paidSchedules / $totalSchedules) * 100 : 0;
                            $totalPaid = $emiLoan->emiSchedules->where('status', 'paid')->sum('emi_amount');
                            $remainingAmount = $emiLoan->total_amount - $totalPaid;
                        @endphp

                        <div
                            class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Repayment Progress
                            </h3>

                            <div class="space-y-4">
                                <!-- Progress Bar -->
                                <div>
                                    <div
                                        class="flex justify-between text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span>Progress</span>
                                        <span>{{ round($progressPercentage, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-3 rounded-full transition-all duration-300"
                                            style="width: {{ $progressPercentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Statistics -->
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Paid EMIs</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $paidSchedules }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">of {{ $totalSchedules }}
                                        </div>
                                    </div>

                                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Remaining</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $totalSchedules - $paidSchedules }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">EMIs left</div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-500 dark:text-gray-400">Amount Paid</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">₹{{ number_format($totalPaid, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">Remaining Amount</span>
                                        <span
                                            class="font-medium text-gray-900 dark:text-white">₹{{ number_format($remainingAmount > 0 ? $remainingAmount : 0, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>

                        <div class="space-y-3">
                            @if ($emiLoan->status !== 'closed')
                                <a href="{{ route('emi-loans.edit', $emiLoan) }}"
                                    class="w-full flex items-center px-4 py-3 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Loan Details
                                </a>
                            @endif

                            <button onclick="window.print()"
                                class="w-full flex items-center px-4 py-3 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Details
                            </button>

                            <form method="POST" action="{{ route('emi-loans.destroy', $emiLoan) }}"
                                onsubmit="return confirm('Are you sure you want to delete this loan? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-3 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Loan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closePaymentModal()"></div>

            <!-- Modal panel -->
            <div
                class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/30 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Mark EMI Payment
                        </h3>

                        <form id="paymentForm" method="POST" class="mt-4 space-y-4">
                            @csrf

                            <!-- Wallet Selection -->
                            <div>
                                <label for="modal_wallet_id"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Select Wallet <span class="text-red-500">*</span>
                                </label>
                                <select name="wallet_id" id="modal_wallet_id" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="">Choose Wallet</option>
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}">
                                            {{ $wallet->name }} (₹{{ number_format($wallet->balance, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Paid Amount -->
                            <div>
                                <label for="modal_paid_amount"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Amount Paid <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="paid_amount" id="modal_paid_amount" required
                                        step="0.01" min="0"
                                        class="w-full pl-8 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                            </div>

                            <!-- Payment Date -->
                            <div>
                                <label for="modal_paid_date"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Payment Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="paid_date" id="modal_paid_date" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="modal_notes"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea name="notes" id="modal_notes" rows="3"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    placeholder="Add any notes about this payment..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="paymentForm"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Mark as Paid
                    </button>
                    <button type="button" onclick="closePaymentModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentScheduleId = null;

        function openPaymentModal(scheduleId, emiAmount, dueDate) {
            currentScheduleId = scheduleId;

            // Set form action URL
            document.getElementById('paymentForm').action =
                `{{ route('emi-loans.schedules.mark-paid', ['emiLoan' => $emiLoan->id, 'emiSchedule' => '__SCHEDULE_ID__']) }}`
                .replace('__SCHEDULE_ID__', scheduleId);

            // Pre-fill form values
            document.getElementById('modal_paid_amount').value = emiAmount;
            document.getElementById('modal_paid_date').value = new Date().toISOString().split('T')[0];

            // Show modal
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('paymentForm').reset();
            currentScheduleId = null;
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePaymentModal();
            }
        });
    </script>
</x-app-layout>
