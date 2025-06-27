@props([
    'startName' => 'start_date',
    'endName' => 'end_date',
    'startLabel' => 'Start Date',
    'endLabel' => 'End Date',
])

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
    <div>
        <label for="{{ $startName }}" class="block text-sm font-semibold text-gray-700">{{ $startLabel }}</label>
        <input type="date" name="{{ $startName }}" id="{{ $startName }}" value="{{ old($startName) }}"
            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        @error($startName)
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="{{ $endName }}" class="block text-sm font-semibold text-gray-700">{{ $endLabel }}</label>
        <input type="date" name="{{ $endName }}" id="{{ $endName }}" value="{{ old($endName) }}"
            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        @error($endName)
            <span class="text-sm text-red-600">{{ $message }}</span>
        @enderror
    </div>
</div>
