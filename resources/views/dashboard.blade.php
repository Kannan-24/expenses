<x-app-layout>
    <x-slot name="title">
        {{ __('Dashboard') }} - {{ config('app.name', 'ExpenseTracker') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl rounded-2xl m-4 flex flex-col justify-between">

            <!-- Welcome Message -->
            <div
                class="p-6 mb-6 text-center text-white rounded-lg shadow-lg bg-gradient-to-r from-blue-500 to-indigo-600">
                <h1 class="text-3xl font-bold">
                    Welcome Back! {{ auth()->user()->name }}!
                </h1>
                <p class="mt-2 text-lg">Here’s your monthly financial summary.</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <x-summary-card title="This Month's Income" value="₹{{ number_format($totalIncome, 2) }}" color="green" />
                <x-summary-card title="This Month's Expense" value="₹{{ number_format($totalExpense, 2) }}"
                    color="red" />
                <x-summary-card title="Net Balance" value="₹{{ number_format($monthlyNetBalance, 2) }}"
                    color="blue" />

            </div>

            {{-- Grid View --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Recent Transactions -->
                <div class="bg-white shadow rounded-lg p-6 mb-8 sm:col-span-2">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Recent Transactions</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-100 text-xs text-gray-500 uppercase">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Payment Method</th>
                                    <th class="px-4 py-2">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentExpenses as $expense)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="font-semibold {{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ ucfirst($expense->type) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($expense->payment_method === 'cash')
                                                <span class="text-yellow-400">Cash</span>
                                            @else
                                                <span class="text-blue-400">Bank</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            <span
                                                class="{{ $expense->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                ₹{{ number_format($expense->amount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-400">No recent
                                            transactions.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Wallets -->
                <div class="p-6 bg-white rounded-2xl shadow-lg mb-8 sm:col-span-1">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-gray-800 text-xl font-bold">Wallets</h2>
                        <a href="{{ route('wallets.index') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-800 transition font-medium">
                            Edit Balance
                        </a>
                    </div>

                    <div class="space-y-2">
                        @foreach ($wallets as $wallet)
                            <div class="flex items-center justify-between text-gray-700">
                                <span class="font-medium">{{ $wallet->name }}</span>
                                <span class="text-right font-semibold">₹{{ number_format($wallet->balance, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 border-t pt-4 flex items-center justify-between text-gray-900 text-lg font-bold">
                        <span>Total Balance</span>
                        <span>₹{{ number_format($wallets->sum('balance'), 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top Categories (using Bar Chart) -->
                <div class="bg-white shadow rounded-lg p-6 mb-8 col-span-1">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Top Categories</h3>
                    <canvas id="topCategoriesChart" height="150"></canvas>
                </div>

                <!-- Budget Usage Chart -->
                <div class="bg-white shadow rounded-lg p-6 mb-8 col-span-1">
                    <h3 class="text-lg font-bold mb-4">Budget Usage by Category</h3>
                    <canvas id="budgetChart" height="150"></canvas>
                </div>
            </div>

            <!-- Monthly Overview Table -->
            <div class="bg-white shadow rounded-lg p-6 ">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Monthly Income vs Expense</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 text-xs text-gray-500 uppercase">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Month</th>
                                <th class="px-4 py-2">Income</th>
                                <th class="px-4 py-2">Expense</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($monthlyData as $month)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('F Y') }}
                                    </td>
                                    <td class="px-4 py-2 text-green-600 font-semibold">
                                        ₹{{ number_format($month->total_income, 2) }}</td>
                                    <td class="px-4 py-2 text-red-600 font-semibold">
                                        ₹{{ number_format($month->total_expense, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-gray-400">No monthly data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>



            <!-- Chart Section -->
            <div class="bg-white shadow rounded-lg p-6 mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Graphical View: Monthly Income vs Expense</h3>
                    <select id="dateRangeSelector"
                        class="border border-gray-300 rounded-md p-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="7d" selected>Last 7 Days</option>
                        <option value="30d">Last 30 Days</option>
                        <option value="3m">Last 3 Months</option>
                        <option value="6m">Last 6 Months</option>
                    </select>
                </div>
                <canvas id="incomeExpenseChart" height="100"></canvas>
            </div>

        </div>
    </div>

    @if (session('just_registered'))
        <script>
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                event: 'expense_register_success',
                method: '{{ session('registration_method', 'email') }}'
            });
        </script>

        {{-- Clear the session so it only fires once --}}
        @php
            session()->forget('just_registered');
            session()->forget('registration_method');
        @endphp
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let incomeExpenseChart;

        async function loadChart(range = '7d') {
            try {
                const response = await fetch(`{{ route('chart.data') }}?range=${range}`);
                const res = await response.json();

                const ctx = document.getElementById('incomeExpenseChart').getContext('2d');

                if (incomeExpenseChart) {
                    incomeExpenseChart.destroy();
                }

                incomeExpenseChart = new Chart(ctx, {
                    type: 'line',
                    borderJoinStyle: 'bevel',
                    data: {
                        labels: res.labels,
                        datasets: [{
                                label: 'Income',
                                data: res.income,
                                backgroundColor: 'rgba(34,197,94,0.2)',
                                borderColor: 'rgba(34,197,94,1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: 'rgba(34,197,94,1)'
                            },
                            {
                                label: 'Expense',
                                data: res.expense,
                                backgroundColor: 'rgba(239,68,68,0.2)',
                                borderColor: 'rgba(239,68,68,1)',
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: 'rgba(239,68,68,1)'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => '₹' + value.toLocaleString()
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading chart data:', error);
            }
        }

        document.getElementById('dateRangeSelector').addEventListener('change', function() {
            loadChart(this.value);
        });

        window.addEventListener('load', () => {
            loadChart();
        });

        const topCategoriesCTX = document.getElementById('topCategoriesChart').getContext('2d');
        new Chart(topCategoriesCTX, {
            type: 'bar',
            data: {
                labels: @json($topCategories->pluck('name')),
                datasets: [{
                    label: 'Total Amount',
                    data: @json($topCategories->pluck('total_amount')),
                    backgroundColor: 'rgba(59,130,246,0.7)',
                    borderColor: 'rgba(59,130,246,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        const budgetChartCTX = document.getElementById('budgetChart').getContext('2d');
        const budgetData = @json($budgetData);

        const labels = budgetData.map(item => item.category);
        const allocated = budgetData.map(item => item.allocated);
        const spent = budgetData.map(item => item.spent);

        const budgetChart = new Chart(budgetChartCTX, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Allocated',
                        data: allocated,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Spent',
                        data: spent,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ₹${context.parsed.y.toFixed(2)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
