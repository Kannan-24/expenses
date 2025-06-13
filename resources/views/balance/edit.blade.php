<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Balance') }} - {{ config('app.name', 'ExpenseTracker') }}
    </x-slot>

    <div class="py-6 ml-4 sm:ml-64">
        <div class="w-full max-w-4xl px-6 mx-auto">
            <x-bread-crumb-navigation />

            <div class="p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <form action="{{ route('balance.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Cash -->
                    <div class="mb-4">
                        <label for="cash" class="block text-sm font-semibold text-gray-700">Cash Balance</label>
                        <input type="number" step="0.01" name="cash" id="cash" value="{{ old('cash', $balance->cash) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <!-- Bank -->
                    <div class="mb-4">
                        <label for="bank" class="block text-sm font-semibold text-gray-700">Bank Balance</label>
                        <input type="number" step="0.01" name="bank" id="bank" value="{{ old('bank', $balance->bank) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Update Balance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
