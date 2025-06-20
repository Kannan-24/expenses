<x-app-layout>
    <x-slot name="title">
        {{ __('Profile') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full max-w-4xl sm:px-6 mx-auto">

            <!-- Breadcrumb Navigation -->
            <x-bread-crumb-navigation />

            <div>
                <!-- User Details Card -->
                <div class="p-4 sm:p-6 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="flex flex-row items-center justify-between gap-4">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-800">Profile</h2>
                        <div class="flex flex-row gap-2 sm:gap-4">
                            <a href="{{ route('profile.edit') }}"
                                class="px-4 py-2 text-white transition bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 text-center">
                                Edit
                            </a>
                            <a href="{{ route('account.settings') }}"
                                class="px-4 py-2 text-blue-600 transition bg-gray-100 rounded-lg shadow-md hover:bg-gray-200 text-center">
                                Settings
                            </a>
                        </div>
                    </div>
                    <div class="space-y-4 mt-6">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-gray-600">👤 Name:</span>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-gray-600">📧 Email:</span>
                            <span class="font-semibold text-gray-800">{{ $user->email }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-gray-600">📞 Phone:</span>
                            <span class="font-semibold text-gray-800">{{ $user->phone }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                            <span class="text-gray-600">🏠 Address:</span>
                            <span class="font-semibold text-gray-800">{{ $user->address }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
