<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div
                    class="mx-auto h-16 w-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-shield-alt text-2xl text-blue-600 dark:text-blue-400"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">
                    Secure Your Account
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Set up a password to secure your account and enable additional login options
                </p>
            </div>

            <!-- Benefits Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Why set up a password?
                </h3>
                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                        <span>Log in even if Google services are unavailable</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                        <span>Enhanced account security with multiple login options</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                        <span>Access your account from any device or browser</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 flex-shrink-0"></i>
                        <span>Better account recovery options</span>
                    </li>
                </ul>
            </div>

            <!-- Password Setup Form -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <form method="POST" action="{{ route('password.setup.store') }}" class="space-y-6">
                    @csrf

                    <!-- Current Login Info -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fab fa-google text-blue-600 dark:text-blue-400 text-xl mr-3"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    Currently signed in with Google
                                </p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ Auth::user()->email }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            New Password
                        </label>
                        <div class="relative">
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Enter a strong password">
                            <button type="button" onclick="togglePassword('password')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="password-icon"
                                    class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                autocomplete="new-password" required
                                class="appearance-none relative block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Confirm your password">
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i id="password_confirmation-icon"
                                    class="fas fa-eye text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-300 mb-2">
                            Password Requirements
                        </h4>
                        <ul class="text-xs text-yellow-700 dark:text-yellow-400 space-y-1">
                            <li>• At least 8 characters long</li>
                            <li>• Contains at least one uppercase letter</li>
                            <li>• Contains at least one lowercase letter</li>
                            <li>• Contains at least one number</li>
                            <li>• Contains at least one special character</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                            class="flex-1 group relative flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <i class="fas fa-shield-alt mr-2"></i>
                            Set Up Password
                        </button>
                        <a href="{{ route('dashboard') }}"
                            class="flex-1 group relative flex justify-center py-3 px-4 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Skip for Now
                        </a>
                    </div>
                </form>
            </div>

            <!-- Security Note -->
            <div class="text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-lock mr-1"></i>
                    Your password will be securely encrypted and stored. You can continue using Google login even after
                    setting up a password.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Real-time password validation
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const requirements = [{
                    regex: /.{8,}/,
                    text: 'At least 8 characters'
                },
                {
                    regex: /[A-Z]/,
                    text: 'One uppercase letter'
                },
                {
                    regex: /[a-z]/,
                    text: 'One lowercase letter'
                },
                {
                    regex: /\d/,
                    text: 'One number'
                },
                {
                    regex: /[^A-Za-z0-9]/,
                    text: 'One special character'
                }
            ];

            // You can add visual feedback here if needed
        });
    </script>
</x-app-layout>
