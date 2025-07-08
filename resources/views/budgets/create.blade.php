<x-app-layout>
    <x-slot name="title">
        {{ __('Create Budget') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">Create New Budget</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2 flex-wrap">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-200 hover:text-white transition-colors">
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
                                        <a href="{{ route('budgets.index') }}" class="text-blue-200 hover:text-white transition-colors">
                                            Budgets
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-blue-100 font-medium">Create Budget</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>

                        <!-- Current Time Display -->
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-sm text-blue-200">Today</p>
                                <p class="text-lg font-bold text-white">Jul 07, 2025</p>
                            </div>
                            <div class="w-px h-12 bg-blue-300 opacity-50"></div>
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">New Budget Details</h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enter the budget information below</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 sm:p-6 lg:p-8">
                            <form action="{{ route('budgets.store') }}" method="POST" x-data="budgetForm()" @submit="handleSubmit">
                                @csrf

                                <div class="space-y-6">

                                    <!-- Form Fields -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Category -->
                                        <div class="space-y-2">
                                            <label for="category_id" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Category
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="category_id" id="category_id" required x-model="budgetCategory"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $id => $name)
                                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Amount -->
                                        <div class="space-y-2">
                                            <label for="amount" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Budget Amount
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="number" 
                                                   name="amount" 
                                                   id="amount" 
                                                   value="{{ old('amount') }}"
                                                   required 
                                                   min="0" 
                                                   step="0.01"
                                                   placeholder="0.00"
                                                   x-model="budgetAmount"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('amount')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Start Date -->
                                        <div class="space-y-2">
                                            <label for="start_date" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Start Date
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" 
                                                   name="start_date" 
                                                   id="start_date" 
                                                   value="{{ old('start_date', '2025-07-07') }}"
                                                   required
                                                   min="2025-07-07"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                            @error('start_date')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- End Date -->
                                        <div class="space-y-2">
                                            <label for="end_date" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                End Date
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <input type="date" 
                                                   name="end_date" 
                                                   id="end_date" 
                                                   value="{{ old('end_date', '2025-08-07') }}"
                                                   required
                                                   min="2025-07-08"
                                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                            @error('end_date')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Frequency -->
                                        <div class="space-y-2">
                                            <label for="frequency" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Frequency
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="frequency" id="frequency" required x-model="budgetFrequency"
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="">Select Frequency</option>
                                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>
                                                    Daily
                                                </option>
                                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>
                                                    Weekly
                                                </option>
                                                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>
                                                    Monthly
                                                </option>
                                                <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>
                                                    Yearly
                                                </option>
                                            </select>
                                            @error('frequency')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Roll Over -->
                                        <div class="space-y-2">
                                            <label for="roll_over" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                Roll Over
                                                <span class="text-red-500 ml-1">*</span>
                                            </label>
                                            <select name="roll_over" id="roll_over" required
                                                    class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-1 transition-all duration-200 text-gray-900 dark:text-white bg-white dark:bg-gray-800 font-medium shadow-sm">
                                                <option value="0" {{ old('roll_over') == '0' ? 'selected' : '' }}>
                                                    No - Start fresh each period
                                                </option>
                                                <option value="1" {{ old('roll_over') == '1' ? 'selected' : '' }}>
                                                    Yes - Carry over unused amount
                                                </option>
                                            </select>
                                            @error('roll_over')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Budget Tips -->
                                    <div class="bg-blue-50 dark:bg-blue-900 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-2">Budget Planning Tips</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-blue-700 dark:text-blue-300">
                                            <div class="flex items-start space-x-2">
                                                <p>Set realistic amounts based on your income</p>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <p>Review past spending for each category</p>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <p>Enable roll-over to save unused amounts</p>
                                            </div>
                                            <div class="flex items-start space-x-2">
                                                <p>Choose frequency that matches your income</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Actions -->
                                    <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-600 space-y-4 sm:space-y-0">
                                        <div class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="text-red-500">*</span> Required fields
                                        </div>
                                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                            <a href="{{ route('budgets.index') }}" 
                                               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </a>
                                            <button type="submit" 
                                                    :disabled="isSubmitting || !budgetCategory || !budgetAmount"
                                                    :class="(isSubmitting || !budgetCategory || !budgetAmount) ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                                    class="inline-flex items-center justify-center px-8 py-3 text-white font-bold rounded-xl transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-blue-200 dark:focus:ring-blue-800 disabled:transform-none disabled:shadow-none">
                                                <span x-show="!isSubmitting" class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    Create Budget
                                                </span>
                                                <span x-show="isSubmitting" class="flex items-center">
                                                    <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Creating...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Creation Tips -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-50 dark:from-blue-900 dark:to-blue-900 rounded-2xl border border-blue-200 dark:border-blue-700 p-6">
                        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Budget Tips
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Start with conservative amounts and adjust as needed</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Use the 50/30/20 rule: needs, wants, savings</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Track actual spending to refine future budgets</p>
                            </div>
                            <div class="flex items-start space-x-2">
                                <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                                <p class="text-blue-800 dark:text-blue-200">Include a buffer for unexpected expenses</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Quick Actions
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('budgets.index') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                View All Budgets
                            </a>
                            <a href="{{ route('categories.index') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Manage Categories
                            </a>
                            <a href="{{ route('dashboard') }}"
                               class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function budgetForm() {
            return {
                isSubmitting: false,
                budgetCategory: '{{ old('category_id', '') }}',
                budgetAmount: '{{ old('amount', '') }}',
                budgetFrequency: '{{ old('frequency', '') }}',
                
                handleSubmit(event) {
                    this.isSubmitting = true;
                }
            }
        }

        // Auto-focus the category field
        document.addEventListener('DOMContentLoaded', function() {
            const categoryInput = document.getElementById('category_id');
            if (categoryInput) {
                categoryInput.focus();
            }
        });

        // Date validation
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            function validateDates() {
                if (startDateInput.value && endDateInput.value) {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    if (endDate <= startDate) {
                        endDateInput.setCustomValidity('End date must be after start date');
                    } else {
                        endDateInput.setCustomValidity('');
                    }
                }
            }

            startDateInput.addEventListener('change', validateDates);
            endDateInput.addEventListener('change', validateDates);
        });

        // Quick date range setup
        function setDateRange(type) {
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const today = new Date('2025-07-07');
            
            let endDateValue;
            switch(type) {
                case 'week':
                    endDateValue = new Date(today);
                    endDateValue.setDate(today.getDate() + 6);
                    break;
                case 'month':
                    endDateValue = new Date(today);
                    endDateValue.setMonth(today.getMonth() + 1);
                    break;
                case 'quarter':
                    endDateValue = new Date(today);
                    endDateValue.setMonth(today.getMonth() + 3);
                    break;
            }
            
            startDate.value = '2025-07-07';
            endDate.value = endDateValue.toISOString().split('T')[0];
        }
    </script>
    
</x-app-layout>