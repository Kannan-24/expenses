<section class="space-y-6">
    <!-- Enhanced Header -->
    <header class="border-b border-gray-200 pb-6">
        <div class="flex items-start space-x-4">
            <div class="p-3 bg-blue-100 rounded-xl">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                    {{ __('Ensure your account is using a long, random password to stay secure. We recommend using a password manager.') }}
                </p>
                
                <!-- Security Tip -->
                <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-amber-800">
                            <strong>Security Tip:</strong> After updating your password, you'll be automatically logged out for security purposes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Enhanced Form -->
    <form method="post" action="{{ route('password.update') }}" class="space-y-6" id="update-password-form" 
          x-data="passwordForm()" @submit="handleSubmit">
        @csrf
        @method('put')

        <!-- Current Password Field -->
        <div class="space-y-2">
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700">
                {{ __('Current Password') }}
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_current_password" 
                       name="current_password" 
                       type="password"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                       autocomplete="current-password"
                       placeholder="Enter your current password"
                       required />
                <button type="button" 
                        @click="togglePasswordVisibility('update_password_current_password')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg x-show="!showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showCurrentPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                    </svg>
                </button>
            </div>
            @if($errors->updatePassword->has('current_password'))
                <div class="flex items-center space-x-2 text-red-600 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $errors->updatePassword->first('current_password') }}</span>
                </div>
            @endif
        </div>

        <!-- New Password Field -->
        <div class="space-y-2">
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700">
                {{ __('New Password') }}
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_password" 
                       name="password" 
                       type="password"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                       autocomplete="new-password"
                       placeholder="Create a strong new password"
                       x-model="newPassword"
                       @input="checkPasswordStrength"
                       required />
                <button type="button" 
                        @click="togglePasswordVisibility('update_password_password')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg x-show="!showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showNewPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                    </svg>
                </button>
            </div>
            
            <!-- Password Strength Indicator -->
            <div x-show="newPassword" class="space-y-2">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-medium text-gray-600">Password Strength:</span>
                    <span class="text-xs font-bold" :class="strengthColor" x-text="strengthText"></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full transition-all duration-300" 
                         :class="strengthBarColor" 
                         :style="`width: ${strengthPercentage}%`"></div>
                </div>
            </div>

            @if($errors->updatePassword->has('password'))
                <div class="flex items-center space-x-2 text-red-600 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $errors->updatePassword->first('password') }}</span>
                </div>
            @endif
        </div>

        <!-- Confirm Password Field -->
        <div class="space-y-2">
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700">
                {{ __('Confirm New Password') }}
                <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input id="update_password_password_confirmation" 
                       name="password_confirmation" 
                       type="password"
                       class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white"
                       autocomplete="new-password"
                       placeholder="Confirm your new password"
                       x-model="confirmPassword"
                       required />
                <button type="button" 
                        @click="togglePasswordVisibility('update_password_password_confirmation')"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                    </svg>
                </button>
            </div>
            
            <!-- Password Match Indicator -->
            <div x-show="confirmPassword" class="flex items-center space-x-2 text-sm">
                <svg x-show="newPassword === confirmPassword && confirmPassword" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="newPassword !== confirmPassword && confirmPassword" class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span x-show="newPassword === confirmPassword && confirmPassword" class="text-green-600">Passwords match</span>
                <span x-show="newPassword !== confirmPassword && confirmPassword" class="text-red-600">Passwords don't match</span>
            </div>

            @if($errors->updatePassword->has('password_confirmation'))
                <div class="flex items-center space-x-2 text-red-600 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $errors->updatePassword->first('password_confirmation') }}</span>
                </div>
            @endif
        </div>

        <!-- Password Requirements Checklist -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 space-y-3">
            <h4 class="text-sm font-semibold text-blue-900 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Password Requirements
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="flex items-center space-x-2 text-sm">
                    <svg :class="hasMinLength ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span :class="hasMinLength ? 'text-green-700' : 'text-gray-600'">At least 8 characters</span>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <svg :class="hasUppercase ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span :class="hasUppercase ? 'text-green-700' : 'text-gray-600'">Uppercase letter</span>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <svg :class="hasLowercase ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span :class="hasLowercase ? 'text-green-700' : 'text-gray-600'">Lowercase letter</span>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <svg :class="hasNumber ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span :class="hasNumber ? 'text-green-700' : 'text-gray-600'">Number (0-9)</span>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <svg :class="hasSpecialChar ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span :class="hasSpecialChar ? 'text-green-700' : 'text-gray-600'">Special character (!@#$%^&*)</span>
                </div>
            </div>
        </div>

        <!-- Submit Button and Status -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200">
            <button type="submit" 
                    :disabled="!isFormValid"
                    :class="isFormValid ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' : 'bg-gray-400 cursor-not-allowed'"
                    class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50">
                <svg x-show="!isSubmitting" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <svg x-show="isSubmitting" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span x-text="isSubmitting ? 'Updating Password...' : 'Update Password'"></span>
            </button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition 
                     x-init="setTimeout(() => show = false, 3000); setTimeout(() => logoutUser(), 3000);"
                     class="flex items-center space-x-2 text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">Password updated successfully! Logging out for security...</span>
                </div>
            @endif
        </div>
    </form>

    <!-- Hidden Logout Form -->
    <form method="post" action="{{ route('logout') }}" id="logout-form" class="hidden">
        @csrf
    </form>

    <script>
        function passwordForm() {
            return {
                newPassword: '',
                confirmPassword: '',
                showCurrentPassword: false,
                showNewPassword: false,
                showConfirmPassword: false,
                isSubmitting: false,
                
                // Password requirements
                hasMinLength: false,
                hasUppercase: false,
                hasLowercase: false,
                hasNumber: false,
                hasSpecialChar: false,
                
                // Strength indicators
                strengthPercentage: 0,
                strengthText: '',
                strengthColor: '',
                strengthBarColor: '',

                get isFormValid() {
                    return this.hasMinLength && this.hasUppercase && this.hasLowercase && 
                           this.hasNumber && this.hasSpecialChar && 
                           this.newPassword === this.confirmPassword && this.confirmPassword;
                },

                togglePasswordVisibility(fieldId) {
                    const field = document.getElementById(fieldId);
                    const isPassword = field.type === 'password';
                    field.type = isPassword ? 'text' : 'password';
                    
                    if (fieldId === 'update_password_current_password') {
                        this.showCurrentPassword = isPassword;
                    } else if (fieldId === 'update_password_password') {
                        this.showNewPassword = isPassword;
                    } else if (fieldId === 'update_password_password_confirmation') {
                        this.showConfirmPassword = isPassword;
                    }
                },

                checkPasswordStrength() {
                    const password = this.newPassword;
                    
                    // Check requirements
                    this.hasMinLength = password.length >= 8;
                    this.hasUppercase = /[A-Z]/.test(password);
                    this.hasLowercase = /[a-z]/.test(password);
                    this.hasNumber = /\d/.test(password);
                    this.hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);
                    
                    // Calculate strength
                    let strength = 0;
                    if (this.hasMinLength) strength += 20;
                    if (this.hasUppercase) strength += 20;
                    if (this.hasLowercase) strength += 20;
                    if (this.hasNumber) strength += 20;
                    if (this.hasSpecialChar) strength += 20;
                    
                    this.strengthPercentage = strength;
                    
                    if (strength < 40) {
                        this.strengthText = 'Weak';
                        this.strengthColor = 'text-red-600';
                        this.strengthBarColor = 'bg-red-500';
                    } else if (strength < 80) {
                        this.strengthText = 'Fair';
                        this.strengthColor = 'text-yellow-600';
                        this.strengthBarColor = 'bg-yellow-500';
                    } else if (strength < 100) {
                        this.strengthText = 'Good';
                        this.strengthColor = 'text-blue-600';
                        this.strengthBarColor = 'bg-blue-500';
                    } else {
                        this.strengthText = 'Strong';
                        this.strengthColor = 'text-green-600';
                        this.strengthBarColor = 'bg-green-500';
                    }
                },

                handleSubmit(event) {
                    if (!this.isFormValid) {
                        event.preventDefault();
                        return;
                    }
                    this.isSubmitting = true;
                }
            }
        }

        function logoutUser() {
            setTimeout(() => {
                document.getElementById('logout-form').submit();
            }, 1000);
        }
    </script>
</section>