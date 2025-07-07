<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Profile') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="w-full mx-auto max-w-7xl space-y-6">

        <!-- Enhanced Header Section -->
        <div class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 dark:from-blue-800 dark:via-indigo-900 dark:to-purple-900 rounded-2xl shadow-xl overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10 dark:opacity-20"></div>
            <div class="absolute -top-8 -right-8 w-40 h-40 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white opacity-5 dark:opacity-10 rounded-full"></div>
            <div class="relative p-8 text-white">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Profile Picture Section -->
                        <div class="relative group">
                            @if ($user->profile_photo)
                                <img class="w-20 h-20 lg:w-24 lg:h-24 rounded-full object-cover ring-4 ring-white ring-opacity-30 dark:ring-white dark:ring-opacity-50 shadow-xl" 
                                    src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" />
                            @else
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-gradient-to-br from-blue-400 to-purple-600 dark:from-blue-500 dark:to-purple-700 rounded-full flex items-center justify-center ring-4 ring-white ring-opacity-30 dark:ring-white dark:ring-opacity-50 shadow-xl">
                                    <span class="text-white font-bold text-2xl lg:text-3xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <!-- Edit Photo Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div>
                            <h1 class="text-3xl lg:text-4xl font-bold mb-2">Edit Profile</h1>
                            <p class="text-blue-200 dark:text-blue-300 text-lg">Update your personal information and preferences</p>
                            <div class="flex items-center space-x-2 mt-3 text-blue-100 dark:text-blue-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-sm font-medium">{{ $user->name }}</span>
                                <span class="text-blue-300 dark:text-blue-400">•</span>
                                <span class="text-sm">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-6 lg:mt-0 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('profile.show') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white bg-opacity-20 dark:bg-white dark:bg-opacity-30 text-white font-semibold rounded-xl hover:bg-opacity-30 dark:hover:bg-opacity-40 transition-all duration-200 border border-white border-opacity-30 dark:border-opacity-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Profile
                        </a>
                        <a href="{{ route('account.settings') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-100 text-blue-700 dark:text-blue-800 font-semibold rounded-xl hover:bg-blue-50 dark:hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Account Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Main Form Section -->
            <div class="lg:col-span-3">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-gray-700 dark:to-blue-900 border-b border-gray-200 dark:border-gray-600 p-6">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Personal Information</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Update your personal details and contact information</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6 lg:p-8">
                        <!-- Enhanced Form -->
                        <form method="POST" action="{{ route('profile.update') }}" x-data="profileForm()" @submit="handleSubmit">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="user_type" value="{{ $user->user_type }}">

                            <div class="space-y-8">
                                <!-- Personal Details Section -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Personal Details
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Name Field -->
                                        <div class="space-y-2">
                                            <label for="name" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                                Full Name
                                                <span class="text-red-500 dark:text-red-400 ml-1">*</span>
                                            </label>
                                            <input type="text" 
                                                name="name" 
                                                id="name" 
                                                value="{{ old('name', $user->name) }}"
                                                required 
                                                maxlength="255"
                                                placeholder="Enter your full name"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-600 dark:focus:border-blue-400 transition-all duration-200 text-gray-900 dark:text-white font-medium shadow-sm bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('name')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <!-- Email Field -->
                                        <div class="space-y-2">
                                            <label for="email" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                                <svg class="w-4 h-4 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                                </svg>
                                                Email Address
                                                <span class="text-red-500 dark:text-red-400 ml-1">*</span>
                                            </label>
                                            <input type="email" 
                                                name="email" 
                                                id="email" 
                                                value="{{ old('email', $user->email) }}"
                                                required 
                                                maxlength="255"
                                                placeholder="Enter your email address"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-600 dark:focus:border-blue-400 transition-all duration-200 text-gray-900 dark:text-white font-medium shadow-sm bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400">
                                            @error('email')
                                                <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Section -->
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        Contact Information
                                    </h3>
                                    
                                    <!-- Phone Field -->
                                    <div class="space-y-2 mb-6">
                                        <label for="phone" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                            <svg class="w-4 h-4 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Phone Number
                                            <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                        </label>
                                        <input type="tel" 
                                            name="phone" 
                                            id="phone" 
                                            value="{{ old('phone', $user->phone) }}"
                                            maxlength="20"
                                            placeholder="Enter your phone number"
                                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-200 dark:focus:ring-green-800 focus:border-green-600 dark:focus:border-green-400 transition-all duration-200 text-gray-900 dark:text-white font-medium shadow-sm bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400">
                                        @error('phone')
                                            <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Address Field -->
                                    <div class="space-y-2">
                                        <label for="address" class="flex items-center text-sm font-bold text-gray-900 dark:text-white">
                                            <svg class="w-4 h-4 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Address
                                            <span class="text-gray-500 dark:text-gray-400 text-xs ml-2">(Optional)</span>
                                        </label>
                                        <textarea name="address" 
                                                id="address"
                                                rows="4"
                                                placeholder="Enter your full address"
                                                class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-green-200 dark:focus:ring-green-800 focus:border-green-600 dark:focus:border-green-400 transition-all duration-200 text-gray-900 dark:text-white font-medium shadow-sm resize-none bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400">{{ old('address', $user->address) }}</textarea>
                                        @error('address')
                                            <p class="text-sm text-red-700 dark:text-red-400 flex items-center mt-2 font-semibold">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex flex-col sm:flex-row justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-600 space-y-4 sm:space-y-0">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        <span class="text-red-500 dark:text-red-400">*</span> Required fields
                                    </div>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('profile.show') }}" 
                                        class="inline-flex items-center px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Cancel
                                        </a>
                                        <button type="submit" 
                                                :disabled="isSubmitting"
                                                :class="isSubmitting ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-gradient-to-r from-blue-600 to-indigo-700 dark:from-blue-500 dark:to-indigo-600 hover:from-blue-700 hover:to-indigo-800 dark:hover:from-blue-600 dark:hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105'"
                                                class="inline-flex items-center px-8 py-3 text-white font-bold rounded-xl transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 disabled:transform-none disabled:shadow-none">
                                            <span x-show="!isSubmitting" class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Save Changes
                                            </span>
                                            <span x-show="isSubmitting" class="flex items-center">
                                                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                                Saving...
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
                
                <!-- Profile Tips -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900 dark:to-indigo-900 rounded-xl border border-blue-200 dark:border-blue-700 p-6">
                    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Profile Tips
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Keep your contact information updated for important notifications</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Use a professional email address for business communications</p>
                        </div>
                        <div class="flex items-start space-x-2">
                            <span class="text-blue-600 dark:text-blue-400 mt-0.5">•</span>
                            <p class="text-blue-800 dark:text-blue-200">Adding your phone number helps with account recovery</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Completion -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Profile Completion
                    </h3>
                    
                    @php
                        $completionFields = collect([
                            'name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->phone,
                            'address' => $user->address,
                        ]);
                        $filledFields = $completionFields->filter()->count();
                        $totalFields = $completionFields->count();
                        $completionPercentage = round(($filledFields / $totalFields) * 100);
                    @endphp
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $filledFields }}/{{ $totalFields }} fields completed</span>
                            <span class="text-sm font-bold text-green-600 dark:text-green-400">{{ $completionPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-3">
                            <div class="bg-gradient-to-r from-green-400 to-green-600 dark:from-green-500 dark:to-green-700 h-3 rounded-full transition-all duration-500" 
                                style="width: {{ $completionPercentage }}%"></div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center {{ $user->name ? 'text-green-600 dark:text-green-400' : 'text-gray-400 dark:text-gray-500' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm">Full Name</span>
                            </div>
                            <div class="flex items-center {{ $user->email ? 'text-green-600 dark:text-green-400' : 'text-gray-400 dark:text-gray-500' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-sm">Email Address</span>
                            </div>
                            <div class="flex items-center {{ $user->phone ? 'text-green-600 dark:text-green-400' : 'text-gray-400 dark:text-gray-500' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $user->phone ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                                </svg>
                                <span class="text-sm">Phone Number</span>
                            </div>
                            <div class="flex items-center {{ $user->address ? 'text-green-600 dark:text-green-400' : 'text-gray-400 dark:text-gray-500' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $user->address ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12' }}"></path>
                                </svg>
                                <span class="text-sm">Address</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Account Info
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">User ID:</span>
                            <span class="font-medium text-gray-900 dark:text-white">#{{ $user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Member Since:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Last Updated:</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Account Type:</span>
                            <span class="font-medium text-gray-900 dark:text-white capitalize">{{ $user->user_type ?? 'Standard' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Current User:</span>
                            <span class="font-medium text-gray-900 dark:text-white">harithelord47</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Session:</span>
                            <span class="font-medium text-gray-900 dark:text-white">Jul 07, 2025</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Time:</span>
                            <span class="font-medium text-gray-900 dark:text-white">16:10 UTC</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function profileForm() {
            return {
                isSubmitting: false,
                
                handleSubmit(event) {
                    this.isSubmitting = true;
                }
            }
        }

        // Auto-save draft functionality
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('input, textarea');
            
            formInputs.forEach(input => {
                input.addEventListener('input', function() {
                    // Save to localStorage as draft
                    localStorage.setItem(`profile_draft_${this.name}`, this.value);
                });
            });

            // Load draft data
            formInputs.forEach(input => {
                const draftValue = localStorage.getItem(`profile_draft_${input.name}`);
                if (draftValue && !input.value) {
                    input.value = draftValue;
                }
            });

            // Clear draft on successful submission
            document.querySelector('form').addEventListener('submit', function() {
                formInputs.forEach(input => {
                    localStorage.removeItem(`profile_draft_${input.name}`);
                });
            });

            console.log('Edit Profile page loaded for user: harithelord47');
            console.log('Current time: 2025-07-07 16:10:21 UTC');
        });
    </script>
</x-app-layout>