<x-app-layout>
    <x-slot name="title">
        {{ __('Batch Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <!-- Main Content Section -->
    <div class="py-6    ml-4 sm:ml-64">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <!-- Batch Details Container -->
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">Batch Details</h2>
                    <div class="flex gap-4">
                        <a href="{{ route('batches.edit', $batch->id) }}">
                            <button class="px-4 py-2 text-white bg-green-500 rounded-lg shadow-md hover:bg-green-700">
                                Edit
                            </button>
                        </a>
                        <form action="{{ route('batches.destroy', $batch->id) }}" method="POST">
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

                <!-- Batch Year Details -->
                <div class="mb-4">
                    <p class="text-lg font-semibold text-gray-700">Start Year:
                        <span class="font-normal text-gray-600">{{ $batch->start_year }}</span>
                    </p>
                    <p class="text-lg font-semibold text-gray-700">End Year:
                        <span class="font-normal text-gray-600">{{ $batch->end_year }}</span>
                    </p>
                </div>

                <!-- Associated Classes -->
                @if ($batch->classes->count() > 0)
                    <h3 class="mt-6 text-xl font-semibold text-gray-800">Associated Classes</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                        @foreach ($batch->classes as $class)
                            <a href="{{ route('classes.show', $class->id) }}" class="block">
                                <div
                                    class="relative overflow-hidden bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl shadow-lg transition-transform transform hover:scale-105">
                                    <div class="p-6">
                                        <h4 class="text-lg font-semibold text-white">
                                            {{ $class->academicYearRoman }} - {{ $class->department->dept_code }} -
                                            {{ $class->section }}
                                        </h4>
                                        <p class="text-white opacity-90">{{ $class->department->dept_name }}</p>
                                    </div>
                                    <div class="absolute top-0 right-0 p-3">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold text-white bg-black bg-opacity-30 rounded-full">
                                            {{ $loop->iteration }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-gray-600">No classes are assigned to this batch.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
