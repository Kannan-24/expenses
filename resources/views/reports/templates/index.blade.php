<x-app-layout>
    <x-slot name="title">
        {{ __('Report Templates') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="py-6 space-y-8" style="min-height: 88vh;">
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 dark:from-blue-800 dark:via-blue-900 dark:to-indigo-900 border-b border-blue-500 dark:border-blue-600 rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 sm:px-8 py-8 relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 bg-black/10 dark:bg-black/30"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent dark:from-white/10 dark:to-transparent"></div>

                <!-- Content -->
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 dark:bg-white/10 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                {{ __('Report Templates') }}
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-2 text-sm sm:text-base">
                                {{ __('Create and manage custom report templates for advanced analytics') }}
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('reports.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 text-white font-medium rounded-lg hover:bg-white/30 dark:hover:bg-white/20 transition-colors backdrop-blur-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                {{ __('Generate Reports') }}
                            </a>
                            <a href="{{ route('report-templates.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('New Template') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Template Categories Filter -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Filter by Category') }}</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('report-templates.index') }}" 
                       class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ !$categoryId ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        {{ __('All Templates') }}
                        <span class="ml-1 px-1.5 py-0.5 bg-white dark:bg-gray-800 rounded text-xs">{{ $templates->count() }}</span>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('report-templates.index', ['category' => $category->id]) }}" 
                           class="inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $categoryId == $category->id ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                            <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                            {{ $category->name }}
                            <span class="ml-1 px-1.5 py-0.5 bg-white dark:bg-gray-800 rounded text-xs">{{ $category->active_report_templates_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Templates Grid -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                @if($templates->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No Templates Found') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('Create your first report template to get started with advanced analytics.') }}</p>
                        <a href="{{ route('report-templates.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Create Template') }}
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($templates as $template)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($template->templateCategory)
                                                <span class="w-3 h-3 rounded-full" style="background-color: {{ $template->templateCategory->color }}"></span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $template->templateCategory->name }}</span>
                                            @endif
                                            @if($template->is_public)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    {{ __('Public') }}
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $template->name }}</h3>
                                        @if($template->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $template->description }}</p>
                                        @endif
                                    </div>
                                    <div class="relative ml-4">
                                        <button class="template-menu-btn text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" data-template-id="{{ $template->id }}">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                            </svg>
                                        </button>
                                        <div class="template-menu hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 z-10" id="menu-{{ $template->id }}">
                                            <a href="{{ route('report-templates.show', $template) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('View Details') }}</a>
                                            <a href="{{ route('report-templates.preview', $template) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Preview') }}</a>
                                            @if($template->canBeEditedBy(Auth::user()))
                                                <a href="{{ route('report-templates.edit', $template) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Edit') }}</a>
                                            @endif
                                            <button onclick="showCloneModal({{ $template->id }}, '{{ $template->name }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">{{ __('Clone') }}</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <span class="inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        {{ ucfirst($template->report_type) }}
                                    </span>
                                    <span>{{ __('Used') }} {{ $template->usage_count }} {{ __('times') }}</span>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('by') }} {{ $template->user->name }}
                                        @if($template->last_used_at)
                                            <br>{{ __('Last used') }} {{ $template->last_used_at->diffForHumans() }}
                                        @endif
                                    </div>
                                    <a href="{{ route('report-templates.show', $template) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
                                        {{ __('Use Template') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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
        // Template menu handling
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.template-menu-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const templateId = this.dataset.templateId;
                    const menu = document.getElementById(`menu-${templateId}`);
                    
                    // Hide all other menus
                    document.querySelectorAll('.template-menu').forEach(m => {
                        if (m !== menu) m.classList.add('hidden');
                    });
                    
                    menu.classList.toggle('hidden');
                });
            });

            // Hide menus when clicking outside
            document.addEventListener('click', function() {
                document.querySelectorAll('.template-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });
        });

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