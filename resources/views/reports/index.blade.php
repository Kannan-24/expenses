<x-app-layout>
    <x-slot name="title">
        {{ __('Reports') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl rounded-2xl m-4 flex flex-col justify-between">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Transactions Report -->
                <form action="{{ route('reports.generate') }}" method="GET" class="bg-gray-50 p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-4">Transaction Report</h2>
                    <input type="hidden" name="report_type" value="transactions">

                    <x-date-range label="Date Range" name="date_range" />

                    <x-select name="category_id" label="Category" :options="$categories" />
                    <x-select name="expense_person_id" label="Expense Person" :options="$people" />
                    <x-input name="amount" label="Amount" type="number" />
                    <x-select name="amount_filter" label="Amount Filter" :options="['<' => 'Less Than', '>' => 'Greater Than']" />
                    <x-select name="wallet_id" label="Wallet" :options="$wallets" />
                    <x-select name="type" label="Transaction Type" :options="['income' => 'Income', 'expense' => 'Expense']" />

                    <x-primary-button class="mt-3">Generate</x-primary-button>
                </form>

                <!-- Budgets Report -->
                <form action="{{ route('reports.generate') }}" method="GET" class="bg-gray-50 p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-4">Budget Report</h2>
                    <input type="hidden" name="report_type" value="budgets">

                    <x-date-range label="Date Range" name="date_range" />
                    <x-select name="category_id" label="Category" :options="$categories" />

                    <x-primary-button class="mt-3">Generate</x-primary-button>
                </form>

                <!-- Support Tickets Report -->
                <form action="{{ route('reports.generate') }}" method="GET" class="bg-gray-50 p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-4">Support Ticket Report</h2>
                    <input type="hidden" name="report_type" value="tickets">

                    <x-date-range label="Date Range" name="date_range" />
                    <x-select name="status" label="Status" :options="[
                        'opened' => 'Opened',
                        'admin replied' => 'Admin Replied',
                        'customer replied' => 'Customer Replied',
                        'closed' => 'Closed',
                    ]" />
                    <x-select name="trashed" label="Include Trashed?" :options="['0' => 'No', '1' => 'Yes']" />

                    <x-primary-button class="mt-3">Generate</x-primary-button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
