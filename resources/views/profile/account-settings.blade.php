<x-app-layout>
    <x-slot name="title">
        {{ __('Account Settings') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full max-w-4xl mx-auto">
            <x-bread-crumb-navigation />

            <!-- Update Password Form -->
            <div class="p-8 mb-6 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User Form -->
            <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Session Activity -->
            <div class="p-8 mt-6 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="max-w-xl">
                    @include('profile.partials.session-activity')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
