@props(['title', 'value', 'color'])

@php
    $colors = [
        'green' => 'bg-green-100 text-green-800 border-green-500',
        'red' => 'bg-red-100 text-red-800 border-red-500',
        'blue' => 'bg-blue-100 text-blue-800 border-blue-500',
        'yellow' => 'bg-yellow-100 text-yellow-800 border-yellow-500',
    ];

    $bgClass = $colors[$color] ?? 'bg-gray-100 text-gray-800 border-gray-300';
@endphp

<div class="p-6 bg-white border-l-4 shadow rounded-xl {{ $bgClass }}">
    <h2 class="text-gray-600 text-lg font-semibold">{{ $title }}</h2>
    <p class="mt-2 text-2xl font-bold">{{ $value }}</p>
</div>
