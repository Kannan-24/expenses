<x-app-layout>
    <x-slot name="title">
        {{ __('Account Settings') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-6 rounded-2xl shadow m-4 flex flex-col"
            style="height: 88vh;">
            <!-- Breadcrumb -->
            <div class="flex justify-between items-center mb-4">
                <x-bread-crumb-navigation />
            </div>

            <hr class="p-2 border-t border-gray-400">

            <!-- Update Password Form -->
            <div class="flex flex-col gap-4">
                <h2 class="text-lg font-semibold text-gray-800">Update Password :</h2>
                <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete User Form -->
            <div class="flex flex-col gap-4 mt-6">
                <h2 class="text-lg font-semibold text-gray-800">Delete Account :</h2>
                <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
