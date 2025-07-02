<x-app-layout>
    <x-slot name="title">
        {{ __('Budget Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" bg-white p-6 rounded-2xl shadow flex flex-col"
        style="height: 93vh; overflow: auto;">
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
                        <span class="text-gray-700">Budget Details</span>
                    </li>
                </ol>
            </nav>
        </div>

        <hr class="p-2 border-t border-gray-400">

        <!-- Budget Details -->
        <div class="flex flex-col gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Budget Details :</h2>
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">Category</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ $budget->category->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">Amount</span>
                    <span class="mx-1">:</span>
                    <span class="text-lg font-bold text-green-600">
                        {{ number_format($budget->amount, 2) }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">Start Date</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">
                        {{ \Carbon\Carbon::parse($budget->start_date)->format('d M, Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">End Date</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">
                        {{ \Carbon\Carbon::parse($budget->end_date)->format('d M, Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">Frequency</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ ucfirst($budget->frequency) }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="w-24 text-sm font-bold text-gray-900">Roll Over</span>
                    <span class="mx-1">:</span>
                    <span class="text-base text-gray-600">{{ $budget->roll_over ? 'Yes' : 'No' }}</span>
                </div>
            </div>

            <hr class=" border-t border-gray-400">

            <!-- Budget Histories Table -->
            <h3 class="text-md font-semibold text-gray-700">Budget Histories</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start Date
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End Date
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Alloted
                                Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Spent Amount
                            </th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Remaining
                                Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($histories->sortByDesc('end_date') as $history)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($history->start_date)->format('d M, Y') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($history->end_date)->format('d M, Y') }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @php
                                        $allocatedAmount =
                                            $history->allocated_amount + ($history->roll_over_amount ?? 0);
                                    @endphp
                                    {{ number_format($allocatedAmount, 2) }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ number_format($history->spent_amount, 2) }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap">
                                    @php
                                        $remaining = $allocatedAmount - $history->spent_amount;
                                    @endphp
                                    {{ number_format($remaining, 2) }}
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center text-gray-500">No histories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $histories->links() }}
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('budgets.edit', $budget->id) }}"
                    class="px-4 py-2 text-sm font-bold text-white bg-indigo-600 rounded hover:bg-indigo-700 transition">
                    Edit
                </a>
                <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>
