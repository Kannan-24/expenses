@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'required' => false,
    'min' => null,
    'max' => null,
    'step' => null,
])

<div class="mb-5">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }} @if ($min !== null) min="{{ $min }}" @endif
        @if ($max !== null) max="{{ $max }}" @endif
        @if ($step !== null) step="{{ $step }}" @endif
        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
