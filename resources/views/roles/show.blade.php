<x-app-layout>
    <x-slot name="title">
        {{ __('Role Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        {{ ucfirst($role->name) }} Role Details
                    </h2>
                    <div class="flex gap-4">
                        <a href="{{ route('roles.edit', $role->id) }}">
                            <button class="px-4 py-2 text-white bg-green-500 rounded-lg shadow-md hover:bg-green-700">
                                Edit
                            </button>
                        </a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-lg shadow-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr class="my-4">

                <div class="mb-4">
                    <table class="w-1/2 divide-y divide-gray-200">
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Role Name</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $role->name }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700 align-top">Permissions</td>
                                <td class="py-2 px-4 font-semibold text-gray-700 align-top">:</td>
                                <td class="py-2 px-4 text-gray-600">
                                    @if($role->permissions->count())
                                        <ol class="list-decimal ml-4">
                                            @foreach($role->permissions as $permission)
                                                <li>{{ $permission->name }}</li>
                                            @endforeach
                                        </ol>
                                    @else
                                        <span class="text-gray-500">No permissions assigned</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
