<x-app-layout>
    <x-slot name="title">
        {{ $reportTemplate->name }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        <!-- Header -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <div class="absolute inset-0 bg-black/10 dark:bg-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent dark:from-white/10 dark:to-transparent"></div>

                <div class="relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @if($reportTemplate->templateCategory)
                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $reportTemplate->templateCategory->color }}"></span>
                                    <span class="text-blue-100 dark:text-blue-200 text-sm">{{ $reportTemplate->templateCategory->name }}</span>
                                @endif
                                @if($reportTemplate->is_public)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        {{ __('Public') }}
                                    </span>
                                @endif
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $reportTemplate->name }}</h1>
                            @if($reportTemplate->description)
                                <p class="text-blue-100 dark:text-blue-200 mt-2">{{ $reportTemplate->description }}</p>
                            @endif
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('report-templates.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 text-white font-medium rounded-lg hover:bg-white/30 dark:hover:bg-white/20 transition-colors backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                {{ __('Back') }}
                            </a>
                            @if($reportTemplate->canBeEditedBy(Auth::user()))
                                <a href="{{ route('report-templates.edit', $reportTemplate) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-medium rounded-lg hover:bg-yellow-600 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                            @endif
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
            <!-- Template Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Template Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Template Information') }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Report Type') }}</label>
                                <p class="text-gray-900 dark:text-white capitalize">{{ $reportTemplate->report_type }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Version') }}</label>
                                <p class="text-gray-900 dark:text-white">{{ $reportTemplate->version }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Created By') }}</label>
                                <p class="text-gray-900 dark:text-white">{{ $reportTemplate->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Created At') }}</label>
                                <p class="text-gray-900 dark:text-white">{{ $reportTemplate->created_at->format('M j, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Usage Count') }}</label>
                                <p class="text-gray-900 dark:text-white">{{ $reportTemplate->usage_count }} {{ __('times') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Last Used') }}</label>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $reportTemplate->last_used_at ? $reportTemplate->last_used_at->diffForHumans() : __('Never') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Fields -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Template Fields') }}</h3>
                        @if($reportTemplate->templateFields->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-gray-50 dark:bg-gray-700">
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Field') }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Type') }}</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Properties') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($reportTemplate->templateFields as $field)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div>
                                                        <p class="font-medium text-gray-900 dark:text-white">{{ $field->field_label }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $field->field_name }}</p>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                        {{ $field->field_type }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">
                                                    <div class="flex flex-wrap gap-1">
                                                        @if($field->is_visible)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                                {{ __('Visible') }}
                                                            </span>
                                                        @endif
                                                        @if($field->is_filterable)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                                {{ __('Filterable') }}
                                                            </span>
                                                        @endif
                                                        @if($field->is_groupable)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                                                {{ __('Groupable') }}
                                                            </span>
                                                        @endif
                                                        @if($field->is_sortable)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                                {{ __('Sortable') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">{{ __('No fields configured for this template.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Quick Actions') }}</h3>
                        <div class="space-y-3">
                            <button onclick="showGenerateModal()" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ __('Generate Report') }}
                            </button>
                            <a href="{{ route('report-templates.preview', $reportTemplate) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('Preview Template') }}
                            </a>
                            <button onclick="showCloneModal({{ $reportTemplate->id }}, '{{ $reportTemplate->name }}')" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('Clone Template') }}
                            </button>
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

    <!-- Clone Template Modal -->
    <div id="cloneModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Clone Template') }}</h3>
                <form id="cloneForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="new_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('New Template Name') }}</label>
                        <input type="text" id="new_name" name="new_name" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="hideCloneModal()"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            {{ __('Clone Template') }}
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

        function showCloneModal(templateId, templateName) {
            const modal = document.getElementById('cloneModal');
            const form = document.getElementById('cloneForm');
            const nameInput = document.getElementById('new_name');
            
            form.action = `/report-templates/${templateId}/clone`;
            nameInput.value = `Copy of ${templateName}`;
            modal.classList.remove('hidden');
        }

        function hideCloneModal() {
            document.getElementById('cloneModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>