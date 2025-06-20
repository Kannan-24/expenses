<x-app-layout>
    <x-slot name="title">
        {{ __('User Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        User Details
                    </h2>
                </div>
                <hr class="my-4">

                <div class="mb-4">
                    <table class="w-1/ divide-y divide-gray-200">
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Name</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Email</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Phone</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Address</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $user->address ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
