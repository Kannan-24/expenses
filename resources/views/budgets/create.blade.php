<x-app-layout>
    <x-slot name="title">
        {{ __('Add Budget') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" bg-white p-6 rounded-2xl shadow flex flex-col"
        style="height: auto; overflow: auto;">
        <!-- Breadcrumb -->
        <div class="flex justify-between items-center mb-4">
            <nav class="flex text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a1 1 0 01.7.3l7 7a1 1 0 01-1.4 1.4L16 10.42V17a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6.58l-.3.28a1 1 0 01-1.4-1.44l7-7A1 1 0 0110 2z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('budgets.index') }}" class="inline-flex items-center hover:text-blue-600">
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            Budgets
                        </a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                        </svg>
                        <span class="text-gray-700">Add Budget</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Form -->
        <form action="{{ route('budgets.store') }}" method="POST">
            @csrf

            <!-- Category -->
            <div class="mb-5 mt-3">
                <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $id => $name)
                        <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Amount -->
            <div class="mb-5">
                <label for="amount" class="block text-sm font-semibold text-gray-700">Amount</label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required min="0" step="0.01">
                @error('amount')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Start Date -->
            <div class="mb-5">
                <label for="start_date" class="block text-sm font-semibold text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('start_date')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- End Date -->
            <div class="mb-5">
                <label for="end_date" class="block text-sm font-semibold text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('end_date')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Roll Over -->
            <div class="mb-5">
                <label for="roll_over" class="block text-sm font-semibold text-gray-700">Roll Over</label>
                <select name="roll_over" id="roll_over"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="0" {{ old('roll_over') == '0' ? 'selected' : '' }}>No</option>
                    <option value="1" {{ old('roll_over') == '1' ? 'selected' : '' }}>Yes</option>
                </select>
                @error('roll_over')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Frequency -->
            <div class="mb-5">
                <label for="frequency" class="block text-sm font-semibold text-gray-700">Frequency</label>
                <select name="frequency" id="frequency"
                    class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                    <option value="">Select Frequency</option>
                    <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ old('frequency') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
                @error('frequency')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Add Budget') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    
</x-app-layout>
