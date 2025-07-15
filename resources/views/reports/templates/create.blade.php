<x-app-layout>
    <x-slot name="title">
        {{ __('Create Report Template') }} - {{ config('app.name', 'expenses') }}
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                {{ __('Create Report Template') }}
                            </h1>
                            <p class="text-blue-100 dark:text-blue-200 mt-2">
                                {{ __('Design a custom report template for advanced analytics') }}
                            </p>
                        </div>
                        <a href="{{ route('report-templates.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white/20 dark:bg-white/10 text-white font-medium rounded-lg hover:bg-white/30 dark:hover:bg-white/20 transition-colors backdrop-blur-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('Back to Templates') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form method="POST" action="{{ route('report-templates.store') }}" id="templateForm">
                @csrf
                
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Basic Information') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Template Name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="template_category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Category') }}
                                </label>
                                <select id="template_category_id" name="template_category_id"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">{{ __('Select Category') }}</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('template_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('template_category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Description') }}
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Report Type') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="report_type" name="report_type" required
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('report_type') border-red-500 @enderror">
                                    <option value="">{{ __('Select Report Type') }}</option>
                                    <option value="transactions" {{ old('report_type', $reportType) == 'transactions' ? 'selected' : '' }}>{{ __('Transactions') }}</option>
                                    <option value="budgets" {{ old('report_type', $reportType) == 'budgets' ? 'selected' : '' }}>{{ __('Budgets') }}</option>
                                    <option value="tickets" {{ old('report_type', $reportType) == 'tickets' ? 'selected' : '' }}>{{ __('Support Tickets') }}</option>
                                    <option value="custom" {{ old('report_type', $reportType) == 'custom' ? 'selected' : '' }}>{{ __('Custom') }}</option>
                                </select>
                                @error('report_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="hidden" name="is_public" value="0">
                                <input type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_public" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Make this template public (other users can use it)') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Fields Configuration -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Fields Configuration') }}</h3>
                            <button type="button" id="loadPredefinedFields" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                {{ __('Load Default Fields') }}
                            </button>
                        </div>

                        <div id="fieldsContainer" class="space-y-4">
                            <!-- Fields will be dynamically added here -->
                        </div>

                        <button type="button" id="addField" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('Add Custom Field') }}
                        </button>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-3">
                    <a href="{{ route('report-templates.index') }}" 
                       class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                        {{ __('Create Template') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let fieldIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            // Load predefined fields when report type changes or button is clicked
            document.getElementById('loadPredefinedFields').addEventListener('click', loadPredefinedFields);
            document.getElementById('report_type').addEventListener('change', function() {
                if (this.value) {
                    loadPredefinedFields();
                }
            });

            // Add custom field
            document.getElementById('addField').addEventListener('click', function() {
                addFieldForm();
            });

            // Load initial fields if report type is already selected
            if (document.getElementById('report_type').value) {
                loadPredefinedFields();
            }
        });

        function loadPredefinedFields() {
            const reportType = document.getElementById('report_type').value;
            if (!reportType || reportType === 'custom') return;

            fetch(`/api/template-fields/${reportType}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('fieldsContainer');
                    container.innerHTML = '';
                    fieldIndex = 0;

                    data.fields.forEach(field => {
                        addFieldForm(field);
                    });
                })
                .catch(error => {
                    console.error('Error loading predefined fields:', error);
                });
        }

        function addFieldForm(fieldData = null) {
            const container = document.getElementById('fieldsContainer');
            const fieldHtml = `
                <div class="field-item bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600" data-index="${fieldIndex}">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Field ${fieldIndex + 1}</h4>
                        <button type="button" onclick="removeField(${fieldIndex})" class="text-red-600 hover:text-red-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Field Name</label>
                            <input type="text" name="fields[${fieldIndex}][field_name]" value="${fieldData?.field_name || ''}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Field Label</label>
                            <input type="text" name="fields[${fieldIndex}][field_label]" value="${fieldData?.field_label || ''}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Field Type</label>
                            <select name="fields[${fieldIndex}][field_type]" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white text-sm">
                                <option value="text" ${fieldData?.field_type === 'text' ? 'selected' : ''}>Text</option>
                                <option value="number" ${fieldData?.field_type === 'number' ? 'selected' : ''}>Number</option>
                                <option value="date" ${fieldData?.field_type === 'date' ? 'selected' : ''}>Date</option>
                                <option value="select" ${fieldData?.field_type === 'select' ? 'selected' : ''}>Select</option>
                                <option value="checkbox" ${fieldData?.field_type === 'checkbox' ? 'selected' : ''}>Checkbox</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data Type</label>
                            <select name="fields[${fieldIndex}][data_type]" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white text-sm">
                                <option value="string" ${fieldData?.data_type === 'string' ? 'selected' : ''}>String</option>
                                <option value="integer" ${fieldData?.data_type === 'integer' ? 'selected' : ''}>Integer</option>
                                <option value="decimal" ${fieldData?.data_type === 'decimal' ? 'selected' : ''}>Decimal</option>
                                <option value="date" ${fieldData?.data_type === 'date' ? 'selected' : ''}>Date</option>
                                <option value="boolean" ${fieldData?.data_type === 'boolean' ? 'selected' : ''}>Boolean</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="fields[${fieldIndex}][is_filterable]" value="1" ${fieldData?.is_filterable !== false ? 'checked' : ''}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Filterable</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fields[${fieldIndex}][is_groupable]" value="1" ${fieldData?.is_groupable !== false ? 'checked' : ''}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Groupable</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fields[${fieldIndex}][is_sortable]" value="1" ${fieldData?.is_sortable !== false ? 'checked' : ''}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sortable</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="fields[${fieldIndex}][is_visible]" value="1" ${fieldData?.is_visible !== false ? 'checked' : ''}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Visible</span>
                        </label>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', fieldHtml);
            fieldIndex++;
        }

        function removeField(index) {
            const fieldItem = document.querySelector(`.field-item[data-index="${index}"]`);
            if (fieldItem) {
                fieldItem.remove();
            }
        }
    </script>
    @endpush
</x-app-layout>