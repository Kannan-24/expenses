<x-guest-layout>
    <x-slot name="title">
        {{ __('Register') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="flex items-center justify-center min-h-screen px-6">
        <div class="grid w-full max-w-6xl grid-cols-1 overflow-hidden bg-white rounded-lg shadow-lg md:grid-cols-2">

            <!-- Left Section: Branding & Info -->
            <div class="flex-col justify-center hidden px-10 py-16 text-white bg-blue-700 md:flex">

                <h2 class="text-3xl font-extrabold">Automated Transport Management System</h2>
                <p class="mt-4 text-lg leading-relaxed">
                    Secure and efficient transport management for students, parents, and staff.
                </p>
                <div class="mt-6 space-y-4 text-left">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 6.75h4.5M9.75 9.75h4.5m-4.5 3h4.5m0 3h-4.5m-4.5 0h.007m.993 0h3.5m5.5 0h.007m.993 0h3.5m-10-6H9m5 0h.007m.993 0h3.5">
                            </path>
                        </svg>
                        <span> Live Bus Tracking for safety and convenience</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-2.485 0-4.5 2.015-4.5 4.5h9c0-2.485-2.015-4.5-4.5-4.5z">
                            </path>
                        </svg>
                        <span> Automated Attendance for better record-keeping</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232a2 2 0 012.828 0l.707.707a2 2 0 010 2.828l-5.657 5.657a2 2 0 01-2.828 0l-.707-.707a2 2 0 010-2.828l5.657-5.657zM6.343 15.657a2 2 0 010 2.828l-.707.707a2 2 0 01-2.828 0l-.707-.707a2 2 0 010-2.828l.707-.707a2 2 0 012.828 0z">
                            </path>
                        </svg>
                        <span> Personalized Dashboard for users & admins</span>
                    </div>
                </div>
            </div>

            <!-- Right Section: Register Form -->
            <div class="max-w-md p-8 mx-auto">
                <div class="mb-8">
                    <h3 class="text-3xl font-bold text-gray-800">Create an Account</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        Register to access your transport details, schedules, and attendance records.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Full Name</label>
                        <div class="relative flex items-center">
                            <input id="name" name="name" type="text" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your full name" value="{{ old('name') }}" autofocus
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Email</label>
                        <div class="relative flex items-center">
                            <input id="email" name="email" type="email" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your email" value="{{ old('email') }}" autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Phone Number</label>
                        <div class="relative flex items-center">
                            <input id="phone" name="phone" type="tel" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter your phone number" value="{{ old('phone') }}" autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Password</label>
                        <div class="relative flex items-center">
                            <input id="password" name="password" type="password" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Enter password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block mb-2 text-sm text-gray-800">Confirm Password</label>
                        <div class="relative flex items-center">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="w-full py-3 pl-4 pr-10 text-sm text-gray-800 border border-gray-300 rounded-lg outline-blue-600"
                                placeholder="Confirm password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Already registered link -->
                    <div class="flex items-center justify-between mb-4">
                        <a class="text-sm text-gray-600 transition hover:text-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <div class="!mt-8">
                        <button type="submit"
                            class="w-full shadow-xl py-2.5 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                            {{ __('Sign Up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
