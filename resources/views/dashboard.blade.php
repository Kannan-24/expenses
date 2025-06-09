<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }} - {{ config('app.name', 'ExpenseTracker') }}
    </x-slot>

    <div class="ml-4 py-9 sm:ml-64 sm:me-4 lg:me-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome -->
            <div
                class="p-6 mb-6 text-center text-white rounded-lg shadow-lg bg-gradient-to-r from-blue-500 to-indigo-600">
                <h1 class="text-3xl font-bold">Welcome Back! 👋</h1>
                <p class="mt-2 text-lg">Here's a quick summary of your finances today.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="p-6 bg-white rounded shadow text-center">
                    <p class="text-sm text-gray-500">Total Income</p>
                    <h2 class="text-2xl font-semibold text-green-600">₹{{ number_format($totalIncome, 2) }}</h2>
                </div>
                <div class="p-6 bg-white rounded shadow text-center">
                    <p class="text-sm text-gray-500">Total Expenses</p>
                    <h2 class="text-2xl font-semibold text-red-600">₹{{ number_format($totalExpense, 2) }}</h2>
                </div>
                <div class="p-6 bg-white rounded shadow text-center">
                    <p class="text-sm text-gray-500">Balance</p>
                    <h2 class="text-2xl font-semibold text-blue-600">₹{{ number_format($balance, 2) }}</h2>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Recent Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $recentExpenses = $expenses->take(10);
                            @endphp
                            @forelse($recentExpenses as $expense)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $expense->date }}</td>
                                    <td class="px-4 py-2">{{ $expense->category->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        <span
                                            class="px-2 py-1 rounded text-xs {{ $expense->type == 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($expense->type) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">₹{{ number_format($expense->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-500">No transactions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
