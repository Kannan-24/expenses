<x-app-layout>
    <x-slot name="title">
        {{ __('Create EMI Loan') }} - {{ config('app.name', 'Expense Tracker') }}
    </x-slot>

    <div class="min-h-screen">
        <div class="max-w-4xl mx-auto">
            <!-- Enhanced Header Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-6 overflow-hidden">
                <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 dark:from-purple-800 dark:via-purple-900 dark:to-indigo-900 border-b border-purple-500 dark:border-purple-600 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <!-- Title and Breadcrumb -->
                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Create EMI Loan</h1>
                            <nav class="flex text-sm" aria-label="Breadcrumb">
                                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                                    <li class="inline-flex items-center">
                                        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-purple-200 hover:text-white transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <a href="{{ route('emi-loans.index') }}" class="text-purple-200 hover:text-white transition-colors">EMI Loans</a>
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mx-2 text-purple-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                                        </svg>
                                        <span class="text-purple-100 font-medium">Create</span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        
                        <!-- Back Button -->
                        <a href="{{ route('emi-loans.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-100 text-purple-700 dark:text-purple-800 font-semibold rounded-xl hover:bg-purple-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span class="hidden sm:inline">Back to EMI Loans</span>
                            <span class="sm:hidden">Back</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('emi-loans.store') }}" class="space-y-6" x-data="emiCalculator()">
                    @csrf

                    <!-- Basic Information Section -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Loan Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                       placeholder="e.g., Home Loan, Car Loan">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Category
                                </label>
                                <select name="category_id" id="category_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Default Wallet -->
                            <div>
                                <label for="default_wallet_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Default Wallet
                                </label>
                                <select name="default_wallet_id" id="default_wallet_id"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Select Default Wallet</option>
                                    @foreach($wallets as $wallet)
                                        <option value="{{ $wallet->id }}" {{ old('default_wallet_id') == $wallet->id ? 'selected' : '' }}>
                                            {{ $wallet->name }} (₹{{ number_format($wallet->balance, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Wallet to be used for EMI payments
                                </p>
                                @error('default_wallet_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Loan Details Section -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                            Loan Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Total Amount -->
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Total Loan Amount <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" 
                                           x-model="totalAmount" @input="calculateEMI()" required step="0.01" min="0"
                                           class="w-full pl-8 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                           placeholder="0.00">
                                </div>
                                @error('total_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Interest Rate -->
                            <div>
                                <label for="interest_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Interest Rate (% p.a.) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate') }}" 
                                           x-model="interestRate" @input="calculateEMI()" required step="0.01" min="0" max="100"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                                @error('interest_rate')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tenure -->
                            <div>
                                <label for="tenure_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tenure (Months) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="tenure_months" id="tenure_months" value="{{ old('tenure_months') }}" 
                                       x-model="tenureMonths" @input="calculateEMI()" required min="1"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                       placeholder="12">
                                @error('tenure_months')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Start Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Loan Type -->
                            <div>
                                <label for="loan_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Loan Type <span class="text-red-500">*</span>
                                </label>
                                <select name="loan_type" id="loan_type" x-model="loanType" @change="calculateEMI()" required
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Select Type</option>
                                    <option value="fixed" {{ old('loan_type') == 'fixed' ? 'selected' : '' }}>Fixed Rate</option>
                                    <option value="reducing_balance" {{ old('loan_type') == 'reducing_balance' ? 'selected' : '' }}>Reducing Balance</option>
                                </select>
                                @error('loan_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- EMI Calculation Section -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            EMI Calculation
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Calculated EMI -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Calculated Monthly EMI
                                </label>
                                <div class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg border border-purple-200 dark:border-purple-700">
                                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400" x-text="'₹' + calculatedEMI.toLocaleString('en-IN', {minimumFractionDigits: 2})"></div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Auto-calculated based on loan details</div>
                                </div>
                            </div>

                            <!-- Manual EMI Override -->
                            <div>
                                <label for="monthly_emi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Override Monthly EMI (Optional)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                    </div>
                                    <input type="number" name="monthly_emi" id="monthly_emi" value="{{ old('monthly_emi') }}" 
                                           step="0.01" min="0"
                                           class="w-full pl-8 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                                           placeholder="Leave empty to use calculated EMI">
                                </div>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    If specified, this will override the calculated EMI amount
                                </p>
                                @error('monthly_emi')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Options Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Additional Options
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Auto Deduct -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_auto_deduct" id="is_auto_deduct" value="1" 
                                       {{ old('is_auto_deduct') ? 'checked' : '' }}
                                       class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_auto_deduct" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Enable Auto Deduction
                                </label>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 ml-7">
                                Automatically deduct EMI from your default wallet on due dates
                            </p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('emi-loans.index') }}"
                           class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Create EMI Loan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function emiCalculator() {
            return {
                totalAmount: 0,
                interestRate: 0,
                tenureMonths: 0,
                loanType: 'fixed',
                calculatedEMI: 0,

                calculateEMI() {
                    if (this.totalAmount > 0 && this.interestRate > 0 && this.tenureMonths > 0) {
                        const P = parseFloat(this.totalAmount);
                        const r = parseFloat(this.interestRate) / 100 / 12; // Monthly interest rate
                        const n = parseInt(this.tenureMonths);

                        if (this.loanType === 'fixed') {
                            // EMI = [P x R x (1+R)^N]/[(1+R)^N-1]
                            const emi = (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
                            this.calculatedEMI = isFinite(emi) ? emi : 0;
                        } else {
                            // For reducing balance, using similar formula
                            const emi = (P * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
                            this.calculatedEMI = isFinite(emi) ? emi : 0;
                        }
                    } else {
                        this.calculatedEMI = 0;
                    }
                }
            }
        }
    </script>
</x-app-layout>
