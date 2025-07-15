<x-app-layout>
    <x-slot name="title">
        {{ __('Preview') }}: {{ $reportTemplate->name }} - {{ config('app.name', 'expenses') }}
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
                            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                {{ __('Preview') }}: {{ $reportTemplate->name }}
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-2">
                                {{ __('Template structure and field configuration preview') }}
                            </p>
                        </div>
                        <div class="flex gap-3">
                            <a href="{{ route('report-templates.show', $reportTemplate) }}" 
                               class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 text-white font-medium rounded-lg hover:bg-white/30 dark:hover:bg-white/20 transition-colors backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Back to Template') }}
                            </a>
                            <button onclick="showGenerateModal()" 
                                    class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ __('Generate Report') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Template Preview -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Preview Notice -->
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('Template Preview') }}</h4>
                            <p class="text-sm text-blue-600 dark:text-blue-300">{{ __('This shows how your report will be structured. Generate a report to see actual data.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Mock Report Preview -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $reportTemplate->name }}</h3>
                            @if($reportTemplate->description)
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $reportTemplate->description }}</p>
                            @endif
                        </div>

                        <!-- Mock Summary Section -->
                        @if($reportTemplate->summary_by_config)
                            <div class="mb-8">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">{{ __('Summary Statistics') }}</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach(array_slice(['Total Count', 'Sum Amount', 'Average'], 0, 3) as $index => $stat)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <div class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $stat }}</div>
                                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                                @switch($index)
                                                    @case(0)
                                                        123
                                                        @break
                                                    @case(1)
                                                        $4,567.89
                                                        @break
                                                    @case(2)
                                                        $37.24
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Mock Data Table -->
                        @if($reportTemplate->templateFields->where('is_visible', true)->count() > 0)
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">{{ __('Sample Data') }}</h4>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm">
                                        <thead>
                                            <tr class="bg-gray-50 dark:bg-gray-700">
                                                @foreach($reportTemplate->templateFields->where('is_visible', true) as $field)
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                        {{ $field->field_label }}
                                                        @if($field->is_sortable)
                                                            <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                                            </svg>
                                                        @endif
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                            @for($i = 1; $i <= 3; $i++)
                                                <tr>
                                                    @foreach($reportTemplate->templateFields->where('is_visible', true) as $field)
                                                        <td class="px-4 py-3 text-gray-900 dark:text-white">
                                                            @switch($field->field_type)
                                                                @case('date')
                                                                    {{ now()->subDays(rand(1, 30))->format('Y-m-d') }}
                                                                    @break
                                                                @case('number')
                                                                    @if(str_contains($field->field_name, 'amount'))
                                                                        ${{ number_format(rand(10, 500), 2) }}
                                                                    @else
                                                                        {{ rand(1, 100) }}
                                                                    @endif
                                                                    @break
                                                                @case('select')
                                                                    {{ ['Option A', 'Option B', 'Option C'][rand(0, 2)] }}
                                                                    @break
                                                                @default
                                                                    Sample {{ $field->field_label }} {{ $i }}
                                                            @endswitch
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('* This is sample data for preview purposes only') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Template Configuration -->
            <div class="space-y-6">
                <!-- Template Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Template Configuration') }}</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Report Type') }}</span>
                                <span class="text-gray-900 dark:text-white capitalize">{{ $reportTemplate->report_type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Total Fields') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $reportTemplate->templateFields->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Visible Fields') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $reportTemplate->templateFields->where('is_visible', true)->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Filterable Fields') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $reportTemplate->templateFields->where('is_filterable', true)->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">{{ __('Groupable Fields') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $reportTemplate->templateFields->where('is_groupable', true)->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Field List -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Field Configuration') }}</h3>
                        <div class="space-y-3">
                            @foreach($reportTemplate->templateFields as $field)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_label }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $field->field_type }}</p>
                                    </div>
                                    <div class="flex space-x-1">
                                        @if($field->is_visible)
                                            <span class="w-2 h-2 bg-green-500 rounded-full" title="{{ __('Visible') }}"></span>
                                        @endif
                                        @if($field->is_filterable)
                                            <span class="w-2 h-2 bg-blue-500 rounded-full" title="{{ __('Filterable') }}"></span>
                                        @endif
                                        @if($field->is_groupable)
                                            <span class="w-2 h-2 bg-purple-500 rounded-full" title="{{ __('Groupable') }}"></span>
                                        @endif
                                        @if($field->is_sortable)
                                            <span class="w-2 h-2 bg-yellow-500 rounded-full" title="{{ __('Sortable') }}"></span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div id="generateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Generate Report') }}</h3>
                <form action="{{ route('reports.generate') }}" method="GET">
                    <input type="hidden" name="template_id" value="{{ $reportTemplate->id }}">
                    <div class="mb-4">
                        <label for="report_format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Report Format') }}</label>
                        <select id="report_format" name="report_format" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="html">{{ __('HTML (Web View)') }}</option>
                            <option value="pdf">{{ __('PDF Document') }}</option>
                            <option value="csv">{{ __('CSV Spreadsheet') }}</option>
                            <option value="xlsx">{{ __('Excel Spreadsheet') }}</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideGenerateModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            {{ __('Generate Report') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showGenerateModal() {
            document.getElementById('generateModal').classList.remove('hidden');
        }

        function hideGenerateModal() {
            document.getElementById('generateModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>