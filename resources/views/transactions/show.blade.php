<x-app-layout>
    <x-slot name="title">
        {{ __('Transaction Details') }} - {{ config('app.name', 'Cazhoo') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div
                class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div
                    class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Transaction Details</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}"
                                            class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <a href="{{ route('transactions.index') }}"
                                            class="text-blue-200 hover:text-white transition-colors">
                                            Transactions
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Details</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Transaction Type Badge -->
                        <div class="flex items-center">
                            @if ($transaction->type === 'income')
                                <div
                                    class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-green-800 dark:text-green-200 font-semibold">Income
                                        Transaction</span>
                                </div>
                            @else
                                <div class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 rounded-full">
                                    <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-red-800 dark:text-red-200 font-semibold">Expense
                                        Transaction</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Transaction Details Card -->
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Transaction Information</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Complete details of your
                                    transaction</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Amount Section -->
                            <div
                                class="text-center p-6 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-600">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Transaction Amount
                                </p>
                                <p
                                    class="text-4xl font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }}{{ $transaction->wallet->currency->symbol ?? '₹' }}{{ number_format($transaction->amount, 2) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    {{ $transaction->type === 'income' ? 'Money received' : 'Money spent' }}
                                </p>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Transaction Type -->
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Transaction Type
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $transaction->type === 'income' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Category
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $transaction->category->name ?? 'No category assigned' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Person -->
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Person
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $transaction->person->name ?? 'No person associated' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Wallet -->
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Wallet
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white font-medium">
                                            {{ $transaction->wallet->name ?? 'No wallet specified' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="space-y-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Transaction Date
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <div>
                                            <span class="text-gray-900 dark:text-white font-medium block">
                                                {{ \Carbon\Carbon::parse($transaction->date)->format('l, F j, Y') }}
                                            </span>
                                            <span class="text-gray-500 dark:text-gray-400 text-sm">
                                                {{ \Carbon\Carbon::parse($transaction->date)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Note -->
                                <div class="space-y-2 md:col-span-2">
                                    <label
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                        Notes
                                    </label>
                                    <div
                                        class="p-3 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <span class="text-gray-900 dark:text-white">
                                            @if ($transaction->note)
                                                @if (str_contains($transaction->note, '#'))
                                                    <ol class="list-decimal pl-10">
                                                        @foreach (explode('#', $transaction->note) as $notePart)
                                                            <li class="text-gray-700 dark:text-gray-300">
                                                                {{ $notePart }}
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                @else
                                                    {{ $transaction->note }}
                                                @endif
                                            @else
                                                No additional notes provided for this transaction.
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <!-- Attachments -->
                                @if ($transaction->attachments && count($transaction->attachments) > 0)
                                    <div class="space-y-2 md:col-span-2">
                                        <label
                                            class="text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a2 2 0 00-2.828-2.828z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                                </path>
                                            </svg>
                                            Attachments ({{ count($transaction->attachments) }})
                                        </label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach ($transaction->attachments as $idx => $attachment)
                                                <div
                                                    class="bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 overflow-hidden">
                                                    @if (str_starts_with($attachment['mime_type'], 'image/'))
                                                        <!-- Image Attachment -->
                                                        <div class="aspect-square relative">
                                                            <img src="{{ route('transactions.attachment', [$transaction->id, $idx]) }}"
                                                                alt="{{ $attachment['original_name'] }}"
                                                                class="w-full h-full object-cover cursor-pointer"
                                                                onclick="openImageModal('{{ route('transactions.attachment', [$transaction->id, $idx]) }}', '{{ $attachment['original_name'] }}')">
                                                            <div class="absolute top-2 right-2">
                                                                <a href="{{ route('transactions.attachment', [$transaction->id, $idx]) }}"
                                                                    download="{{ $attachment['original_name'] }}"
                                                                    class="bg-black bg-opacity-50 text-white p-1 rounded-full hover:bg-opacity-70 transition-all">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- PDF or Other File Attachment -->
                                                        <div class="p-4 flex items-center justify-center h-32">
                                                            <div class="text-center">
                                                                <svg class="w-12 h-12 mx-auto text-red-500 mb-2"
                                                                    fill="currentColor" viewBox="0 0 24 24">
                                                                    <path
                                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                                </svg>
                                                                <p
                                                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                                    PDF</p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="p-3 border-t border-gray-200 dark:border-gray-600">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate"
                                                            title="{{ $attachment['original_name'] }}">
                                                            {{ $attachment['original_name'] }}
                                                        </p>
                                                        <div class="flex items-center justify-between mt-1">
                                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ number_format($attachment['size'] / 1024, 1) }} KB
                                                            </p>
                                                            <div class="flex space-x-2">
                                                                @if ($attachment['mime_type'] === 'application/pdf')
                                                                    <a href="{{ route('transactions.attachment', [$transaction->id, $idx]) }}"
                                                                        target="_blank"
                                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                                                        <svg class="w-4 h-4" fill="none"
                                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                stroke-width="2"
                                                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                                            </path>
                                                                        </svg>
                                                                    </a>
                                                                @endif
                                                                <a href="{{ route('transactions.attachment', [$transaction->id, $idx]) }}"
                                                                    download="{{ $attachment['original_name'] }}"
                                                                    class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                                                    <svg class="w-4 h-4" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                                                        </path>
                                                                    </svg>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Modal -->
                <div id="imageModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-75"
                    onclick="closeImageModal()">
                    <div
                        class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div
                            class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform">
                            <img id="modalImage" src="" alt="" class="w-full h-auto rounded-lg">
                            <div class="absolute top-4 right-4">
                                <button onclick="closeImageModal()"
                                    class="bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Panel -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Transaction Tips Card -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-50 dark:from-blue-900 dark:to-blue-900 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                </path>
                            </svg>
                            Quick Tips
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Keep your transaction records organized for
                                    better financial tracking</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Add notes to remember important details
                                    about transactions</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Regular review of your transactions helps
                                    maintain budget control</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <!-- Edit Button -->
                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit Transaction
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this transaction? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Delete Transaction
                                </button>
                            </form>

                            <!-- Back to List -->
                            <a href="{{ route('transactions.index') }}"
                                class="w-full flex items-center justify-center px-4 py-3 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 font-semibold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                Back to Transactions
                            </a>
                        </div>
                    </div>

                    <!-- Transaction Summary Card -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Transaction Summary
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Transaction
                                    ID</span>
                                <span
                                    class="text-sm text-gray-600 dark:text-gray-400 font-mono">#{{ $transaction->id }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Created</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $transaction->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            @if ($transaction->updated_at != $transaction->created_at)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Last
                                        Updated</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $transaction->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageUrl, imageName) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalImage').alt = imageName;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>

</x-app-layout>
