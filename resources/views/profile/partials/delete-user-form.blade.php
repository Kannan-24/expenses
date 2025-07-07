<section class="space-y-8">
    <!-- Enhanced Header -->
    <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900 dark:to-pink-900 rounded-2xl p-6 border-l-4 border-red-500 dark:border-red-400">
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-800 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Danger Zone') }}
                </h2>
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-3">
                    {{ __('Delete Account') }}
                </h3>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Data Impact Information -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('What will be deleted?') }}
            </h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Financial Data -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Financial Data') }}
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('All expense records and transactions') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Budget settings and goals') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Wallet and payment method data') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Financial reports and insights') }}
                        </li>
                    </ul>
                </div>

                <!-- Account Data -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-4 h-4 mr-2 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Account Information') }}
                    </h4>
                    <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Profile information and preferences') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Uploaded receipts and attachments') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Custom categories and tags') }}
                        </li>
                        <li class="flex items-center">
                            <span class="w-2 h-2 bg-red-400 dark:bg-red-500 rounded-full mr-3"></span>
                            {{ __('Notification and alert settings') }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Important Notice -->
            <div class="mt-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h5 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-1">{{ __('Important Notice') }}</h5>
                        <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                            {{ __('This action cannot be undone. All data will be permanently removed from our servers immediately. We recommend exporting your financial data before proceeding.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Data Export Options -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900 border-b border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                {{ __('Export Your Data First') }}
            </h3>
        </div>
        
        <div class="p-6">
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                {{ __('Before deleting your account, you can export your financial data to keep a personal copy.') }}
            </p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Export All Data -->
                <button type="button" 
                        onclick="exportData('all')"
                        class="group flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900 transition-all duration-200">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-200 dark:group-hover:bg-blue-700 transition-colors">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center">{{ __('Complete Data') }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-1">{{ __('All transactions, budgets & settings') }}</p>
                </button>

                <!-- Export Transactions -->
                <button type="button" 
                        onclick="exportData('transactions')"
                        class="group flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-green-300 dark:hover:border-green-500 hover:bg-green-50 dark:hover:bg-green-900 transition-all duration-200">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-800 rounded-xl flex items-center justify-center mb-3 group-hover:bg-green-200 dark:group-hover:bg-green-700 transition-colors">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center">{{ __('Transactions Only') }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-1">{{ __('Expense & income records') }}</p>
                </button>

                <!-- Export Reports -->
                <button type="button" 
                        onclick="exportData('reports')"
                        class="group flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-600 rounded-xl hover:border-purple-300 dark:hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900 transition-all duration-200">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-800 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-200 dark:group-hover:bg-purple-700 transition-colors">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 dark:text-white text-center">{{ __('Financial Reports') }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mt-1">{{ __('Analytics & insights') }}</p>
                </button>
            </div>
        </div>
    </div> --}}

    <!-- Delete Account Button -->
    <div class="bg-white dark:bg-gray-900 rounded-2xl border-2 border-red-200 dark:border-red-700 shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200 mb-2">{{ __('Permanently Delete Account') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    {{ __('This action is irreversible. Please be certain before proceeding.') }}
                </p>
            </div>
            
            <button type="button"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 dark:from-red-500 dark:to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-800 dark:hover:from-red-600 dark:hover:to-red-700 transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-red-200 dark:focus:ring-red-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                {{ __('Delete Account') }}
            </button>
        </div>
    </div>

    <!-- Enhanced Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6 bg-white dark:bg-gray-900">
            <!-- Modal Header -->
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ __('Confirm Account Deletion') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('This action cannot be undone') }}
                    </p>
                </div>
            </div>

            <!-- Warning Content -->
            <div class="bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.314 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">{{ __('Warning: Permanent Data Loss') }}</h3>
                        <p class="text-red-700 dark:text-red-300 text-sm leading-relaxed">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This includes all your financial records, transaction history, budgets, and personal settings. This action cannot be reversed.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3">{{ __('Account to be deleted:') }}</h4>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Confirmation Form -->
            <form method="post" action="{{ route('account.destroy') }}" x-data="deleteAccountForm()" @submit="handleSubmit">
                @csrf
                @method('delete')

                <!-- Password Confirmation -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('Confirm with your password') }}
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               x-model="password"
                               :type="showPassword ? 'text' : 'password'"
                               class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:outline-none focus:border-red-500 dark:focus:border-red-400 focus:ring-4 focus:ring-red-100 dark:focus:ring-red-800 transition-all bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                               placeholder="{{ __('Enter your current password') }}" 
                               required>
                        
                        <!-- Password toggle -->
                        <button type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <!-- Final Confirmation Checkbox -->
                <div class="mb-6">
                    <label class="flex items-start space-x-3 cursor-pointer">
                        <input type="checkbox" 
                               x-model="confirmDeletion"
                               required
                               class="w-5 h-5 text-red-600 dark:text-red-500 bg-gray-100 dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded focus:ring-red-500 dark:focus:ring-red-400 focus:ring-2 mt-0.5">
                        <span class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ __('I understand that this action will permanently delete my account and all associated data. This action cannot be undone.') }}
                        </span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                    <button type="button"
                            x-on:click="$dispatch('close')"
                            class="px-6 py-3 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700">
                        {{ __('Cancel') }}
                    </button>

                    <button type="submit"
                            :disabled="!password || !confirmDeletion || loading"
                            class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 dark:from-red-500 dark:to-red-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-red-700 hover:to-red-800 dark:hover:from-red-600 dark:hover:to-red-700 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-red-200 dark:focus:ring-red-800 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!loading" class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('Delete Account Permanently') }}
                        </span>
                        
                        <span x-show="loading" class="flex items-center">
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Deleting Account...') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>

<!-- Enhanced JavaScript -->
<script>
    // Delete Account Form Handler
    function deleteAccountForm() {
        return {
            password: '',
            confirmDeletion: false,
            showPassword: false,
            loading: false,
            
            handleSubmit(event) {
                if (!this.password || !this.confirmDeletion) {
                    event.preventDefault();
                    alert('{{ __("Please enter your password and confirm the deletion.") }}');
                    return;
                }
                
                // Final confirmation
                const confirmed = confirm('{{ __("Are you absolutely sure? This action cannot be undone.") }}');
                if (!confirmed) {
                    event.preventDefault();
                    return;
                }
                
                this.loading = true;
            }
        }
    }

    // Data Export Functions
    function exportData(type) {
        // Show loading state
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        
        button.innerHTML = `
            <div class="flex items-center">
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ __('Exporting...') }}
            </div>
        `;
        button.disabled = true;

        // Make export request
        fetch(`/account/export/${type}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                return response.blob();
            }
            throw new Error('Export failed');
        })
        .then(blob => {
            // Create download link
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `duo-dev-expenses-${type}-${new Date().toISOString().split('T')[0]}.zip`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            showNotification('{{ __("Data exported successfully!") }}', 'success');
        })
        .catch(error => {
            console.error('Export error:', error);
            showNotification('{{ __("Export failed. Please try again.") }}', 'error');
        })
        .finally(() => {
            // Restore button
            button.innerHTML = originalContent;
            button.disabled = false;
        });
    }

    // Notification System
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-600 text-white' : 
            type === 'error' ? 'bg-red-600 text-white' : 
            'bg-blue-600 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                        type === 'error' ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    }
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white/80 hover:text-white">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Delete account section loaded for user: {{ Auth::user()->email }}');
    });
</script>

<!-- Additional Styles for Enhanced Responsiveness -->
<style>
    /* Ensure proper spacing on mobile */
    @media (max-width: 640px) {
        .space-y-8 > * + * {
            margin-top: 1.5rem;
        }
        
        .grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
    
    /* Enhanced modal responsiveness */
    @media (max-width: 768px) {
        .modal-content {
            margin: 1rem;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
        }
    }
    
    /* Smooth transitions for all interactive elements */
    button, .hover\\:scale-105:hover {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Enhanced focus states for accessibility */
    button:focus, input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
</style>