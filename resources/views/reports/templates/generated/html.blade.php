<x-app-layout>
    <x-slot name="title">
        {{ $template->name }} Report - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        <!-- Header -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <div class="absolute inset-0 bg-black/10 dark:bg-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent dark:from-white/10 dark:to-transparent"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $template->name }}</h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-2">
                                {{ __('Generated on') }} {{ $generated_at->format('M j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('reports.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 text-white font-medium rounded-lg hover:bg-white/30 dark:hover:bg-white/20 transition-colors backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Back to Reports') }}
                            </a>
                            <button onclick="window.print()" 
                                    class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                {{ __('Print') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Content -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                @if($template->description)
                    <div class="mb-6">
                        <p class="text-gray-600 dark:text-gray-400">{{ $template->description }}</p>
                    </div>
                @endif

                @if(isset($data['aggregations']) && $data['aggregations'])
                    <!-- Summary Section -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Summary') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($data['aggregations'] as $key => $value)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                        {{ str_replace('_', ' ', $key) }}
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                        @if(str_contains($key, 'amount') || str_contains($key, 'sum'))
                                            ${{ number_format($value, 2) }}
                                        @elseif(str_contains($key, 'avg'))
                                            {{ number_format($value, 2) }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if(isset($data['data']) && !empty($data['data']))
                    <!-- Data Table -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Detailed Data') }}</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        @foreach($template->visibleFields as $field)
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ $field->field_label }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($data['data'] as $row)
                                        <tr>
                                            @foreach($template->visibleFields as $field)
                                                <td class="px-4 py-3 text-gray-900 dark:text-white">
                                                    {{ $field->formatValue($row[$field->field_name] ?? '') }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if((!isset($data['data']) || empty($data['data'])) && (!isset($data['aggregations']) || !$data['aggregations']))
                    <!-- No Data -->
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No Data Found') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('No data matches the current filters for this template.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Report Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 text-center text-sm text-gray-500 dark:text-gray-400">
            {{ __('Generated by') }} {{ $user->name }} {{ __('using') }} {{ $template->name }} {{ __('template') }}
            <br>
            {{ config('app.name') }} - {{ __('Advanced Reporting System') }}
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .print\:hidden {
                display: none !important;
            }
            
            body {
                background: white !important;
            }
            
            .dark\:bg-gray-800,
            .dark\:bg-gray-700 {
                background: white !important;
                color: black !important;
            }
            
            .dark\:text-white,
            .dark\:text-gray-300 {
                color: black !important;
            }
        }
    </style>
    @endpush
</x-app-layout>