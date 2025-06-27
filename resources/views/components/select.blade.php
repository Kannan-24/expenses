@props(['label', 'name', 'options' => [], 'selected' => null, 'required' => false])

<div class="mb-5">
    <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">Select {{ $label }}</option>
        @foreach ($options as $value => $text)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
    @error($name)
        <span class="text-sm text-red-600">{{ $message }}</span>
    @enderror
</div>
