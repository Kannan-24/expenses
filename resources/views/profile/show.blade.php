<x-app-layout>
    <x-slot name="title">
        {{ __('Profile') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6    ml-4 sm:ml-64">
        <div class="w-full max-w-4xl px-6 mx-auto">

            <!-- Breadcrumb Navigation -->
            <x-bread-crumb-navigation />

            <div class="">
                <!-- Profile Image Card -->


                <!-- User Details Card -->
                <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-lg sm:col-span-2">
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-gray-800">Profile Details</h2>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('profile.edit') }}"
                                class="px-6 py-2 text-white transition bg-blue-600 rounded-lg shadow-md hover:bg-blue-700">
                                ✏️ Edit Profile
                            </a>
                            <a href="{{ route('account.settings') }}"
                                class="px-6 py-2 text-blue-600 transition bg-gray-100 rounded-lg shadow-md hover:bg-gray-200">
                                ⚙️ Settings
                            </a>
                        </div>
                    </div>
                    <div class="space-y-4 mt-6">
                        <div class="flex">
                            <span class="text-gray-600">👤 Name:</span>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>

                        <div class="flex">
                            <span class="text-gray-600">📧 Email:</span>
                            <span class="font-semibold text-gray-800">{{ $user->email }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-600">📞 Phone:</span>
                            <span class="font-semibold text-gray-800">{{ $user->phone }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-gray-600">🏠 Address:</span>
                            <span class="font-semibold text-gray-800">{{ $user->address }}</span>
                        </div>
                    </div>

                    <!-- Buttons Inside the Card -->
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
