<x-app-layout>
    <x-slot name="title">
        {{ __('Balance History') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-4 rounded-2xl">
                <form method="GET" class="mb-4 flex flex-col sm:flex-row flex-wrap gap-3 items-stretch sm:items-center">
                    <select name="filter" onchange="this.form.submit()"
                        class="bg-white border border-gray-300 text-sm rounded px-3 py-2 text-gray-900 w-full sm:w-auto">
                        <option value="">All</option>
                        <option value="7days" {{ request('filter') == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="15days" {{ request('filter') == '15days' ? 'selected' : '' }}>Last 15 Days</option>
                        <option value="1month" {{ request('filter') == '1month' ? 'selected' : '' }}>Last 1 Month</option>
                    </select>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800 w-full sm:w-auto">
                        <span class="text-gray-500 text-center sm:text-left">to</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="border border-gray-300 rounded px-3 py-1 text-sm text-gray-800 w-full sm:w-auto">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded text-sm w-full sm:w-auto">Filter</button>
                        <a href="{{ route('balance.history') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-1 rounded text-sm text-center w-full sm:w-auto">Reset</a>
                    </div>
                </form>

                <div class="bg-gray-800 rounded-lg shadow p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-300">
                        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Cash</th>
                                <th class="px-4 py-2">Bank</th>
                                <th class="px-4 py-2">Updated By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $history)
                                <tr class="border-b border-gray-700 hover:bg-gray-700">
                                    <td class="px-4 py-2">{{ ($histories->firstItem() ?? 0) + $loop->index }}</td>
                                    <td class="px-4 py-2">{{ $history->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-2">
                                        ₹{{ $history->cash_before }} → <span class="font-semibold text-green-400">₹{{ $history->cash_after }}</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        ₹{{ $history->bank_before }} → <span class="font-semibold text-blue-400">₹{{ $history->bank_after }}</span>
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $history->editor->name ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-gray-400">No history yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <x-pagination :paginator="$histories" />
            </div>
        </div>
    </div>
</x-app-layout>
