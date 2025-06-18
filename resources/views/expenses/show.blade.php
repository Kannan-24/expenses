<x-app-layout>
    <x-slot name="title">
        {{ __('Expense Details') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class=" sm:ml-64">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <x-bread-crumb-navigation />

            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        {{ ucfirst($expense->type) }} Details
                    </h2>
                    <div class="flex gap-4">
                        <a href="{{ route('expenses.edit', $expense->id) }}">
                            <button class="px-4 py-2 text-white bg-green-500 rounded-lg shadow-md hover:bg-green-700">
                                Edit
                            </button>
                        </a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-lg shadow-md hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                <hr class="my-4">

                <div class="mb-4">
                    <table class="w-1/ divide-y divide-gray-200">
                        <tbody>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Type</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ ucfirst($expense->type) }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Payment Method</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $expense->payment_method ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Amount</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Category</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">{{ $expense->category?->name ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Person</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">
                                    @if ($expense->person)
                                        {{ $expense->person->name }}
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-700">Date</td>
                                <td class="py-2 px-4 font-semibold text-gray-700">:</td>
                                <td class="py-2 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                            </tr>
                            @if ($expense->note)
                                <tr>
                                    <td class="py-2 px-4 font-semibold text-gray-700 align-top">Note</td>
                                    <td class="py-2 px-4 font-semibold text-gray-700 align-top">:</td>
                                    <td class="py-2 px-4 text-gray-600">
                                        @php $i = 1; @endphp
                                        @foreach (explode('#', $expense->note) as $note)
                                            @if (trim($note) !== '')
                                                <div class="mb-1">{{ $i++ }}. {{ trim($note) }}</div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
