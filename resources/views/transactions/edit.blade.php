<x-app-layout>
    <x-slot name="title">
        {{ __('Edit Expense / Income') }} - {{ config('app.name', 'expenses') }}
    </x-slot>

    <div class="sm:ml-64">
        <div class="w-full max-w-4xl mx-auto sm:px-4">
            <x-bread-crumb-navigation />

            <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg shadow-lg">
                <div class="mb-4 text-sm text-gray-600">
                    <strong>Available Wallets: </strong> {{ $wallets->count() > 0 ? '' : 'None' }}<br>
                    @foreach ($wallets as $wallet)
                        <strong>{{ $wallet->name }}:</strong> {{ $wallet->currency->symbol }}
                        {{ number_format($wallet->balance, 2) }}<br>
                    @endforeach
                </div>

                <form action="{{ route('transactions.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-semibold text-gray-700">Type</label>
                        <select name="type" id="type"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="expense" {{ old('type', $expense->type) === 'expense' ? 'selected' : '' }}>
                                Expense</option>
                            <option value="income" {{ old('type', $expense->type) === 'income' ? 'selected' : '' }}>
                                Income</option>
                        </select>
                        @error('type')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <label for="category_id" class="block text-sm font-semibold text-gray-700">Category</label>
                            <button type="button" onclick="openCategoryModal()"
                                class="text-sm text-blue-600 hover:underline">+ Add New</button>
                        </div>
                        <select name="category_id" id="category_id"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">None</option>
                            @foreach ($categories->where('user_id', auth()->id()) as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Expense Person -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <label for="expense_person_id" class="block text-sm font-semibold text-gray-700">Expense
                                Person</label>
                            <button type="button" onclick="openPersonModal()"
                                class="text-sm text-blue-600 hover:underline">+ Add New</button>
                        </div>
                        <select name="expense_person_id" id="expense_person_id"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">None</option>
                            @foreach ($people as $person)
                                <option value="{{ $person->id }}"
                                    {{ old('expense_person_id', $expense->expense_person_id) == $person->id ? 'selected' : '' }}>
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('expense_person_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-4">
                        <label for="amount" class="block text-sm font-semibold text-gray-700">Amount</label>
                        <input type="number" name="amount" id="amount"
                            value="{{ old('amount', $expense->amount) }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            min="0" step="0.01" required>
                        @error('amount')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Wallet -->
                    <div class="mb-4">
                        <div class="flex items-center justify-between">
                            <label for="wallet_id" class="block text-sm font-semibold text-gray-700">Wallet</label>
                            <button type="button" onclick="openWalletModal()"
                                class="text-sm text-blue-600 hover:underline">+ Add New</button>
                        </div>
                        <select name="wallet_id" id="wallet_id"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="">Select Wallet</option>
                            @foreach ($wallets as $wallet)
                                <option value="{{ $wallet->id }}"
                                    {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->name }} ({{ $wallet->currency->symbol }}
                                    {{ number_format($wallet->balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('wallet_id')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label for="date" class="block text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" name="date" id="date"
                            value="{{ old('date', $expense->date ? \Carbon\Carbon::parse($expense->date)->format('Y-m-d') : '') }}"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                        @error('date')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Note -->
                    <div class="mb-4">
                        <label for="note" class="block text-sm font-semibold text-gray-700">Note</label>
                        <textarea name="note" id="note" rows="3"
                            class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note', $expense->note) }}</textarea>
                        @error('note')
                            <span class="text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 text-lg font-semibold text-white transition duration-300 rounded-lg shadow-md bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-600 hover:to-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Add New Category</h3>
            <input type="text" id="newCategoryName"
                class="w-full p-2 mb-4 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Category name">
            <div class="flex justify-end space-x-2">
                <button onclick="closeCategoryModal()" class="px-3 py-1 text-gray-600">Cancel</button>
                <button onclick="submitNewCategory()" class="px-3 py-1 bg-indigo-600 text-white rounded">Add</button>
            </div>
        </div>
    </div>

    <!-- Person Modal -->
    <div id="personModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Add New Person</h3>
            <input type="text" id="newPersonName"
                class="w-full p-2 mb-4 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Person name">
            <div class="flex justify-end space-x-2">
                <button onclick="closePersonModal()" class="px-3 py-1 text-gray-600">Cancel</button>
                <button onclick="submitNewPerson()" class="px-3 py-1 bg-indigo-600 text-white rounded">Add</button>
            </div>
        </div>
    </div>

    <!-- Wallet Modal -->
    <div id="walletModal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Add New Wallet</h3>
            <div class="mb-4">
                <label for="newWalletType" class="block text-sm font-semibold text-gray-700">Wallet Type</label>
                <select id="newWalletType"
                    class="w-full p-2 mt-1 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">
                    @foreach ($walletTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" id="newWalletName"
                class="w-full p-2 mb-4 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Wallet name">
            <input type="text" id="newWalletCurrency"
                class="w-full p-2 mb-4 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Currency (e.g. USD, EUR)">
            <input type="number" id="newWalletBalance" value="0"
                class="w-full p-2 mb-4 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Initial Balance" min="0" step="0.01">
            <div class="flex justify-end space-x-2">
                <button onclick="closeWalletModal()" class="px-3 py-1 text-gray-600">Cancel</button>
                <button onclick="submitNewWallet()" class="px-3 py-1 bg-indigo-600 text-white rounded">Add</button>
            </div>
        </div>
    </div>

    <script>
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
        }

        function submitNewCategory() {
            const name = document.getElementById('newCategoryName').value;

            if (!name) return alert("Please enter a category name");

            fetch('{{ route('categories.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('category_id');
                        const option = document.createElement('option');
                        option.value = data.category.id;
                        option.text = data.category.name;
                        option.selected = true;
                        select.appendChild(option);

                        closeCategoryModal();
                        document.getElementById('newCategoryName').value = '';
                    } else {
                        alert("Error adding category");
                    }
                });
        }

        // Person Modal
        function openPersonModal() {
            document.getElementById('personModal').classList.remove('hidden');
        }

        function closePersonModal() {
            document.getElementById('personModal').classList.add('hidden');
        }

        function submitNewPerson() {
            const name = document.getElementById('newPersonName').value;

            if (!name) return alert("Please enter a person name");

            fetch('{{ route('expense-people.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('expense_person_id');
                        const option = document.createElement('option');
                        option.value = data.person.id;
                        option.text = data.person.name;
                        option.selected = true;
                        select.appendChild(option);

                        closePersonModal();
                        document.getElementById('newPersonName').value = '';
                    } else {
                        alert("Error adding person");
                    }
                });
        }

        // Wallet Modal
        function openWalletModal() {
            document.getElementById('walletModal').classList.remove('hidden');
        }

        function closeWalletModal() {
            document.getElementById('walletModal').classList.add('hidden');
        }

        function submitNewWallet() {
            const walletType = document.getElementById('newWalletType').value;
            const name = document.getElementById('newWalletName').value;
            const currency = document.getElementById('newWalletCurrency').value;
            const balance = document.getElementById('newWalletBalance').value || 0;

            if (!walletType || !name || !currency) {
                return alert("Please fill in all fields");
            }

            fetch('{{ route('wallets.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        wallet_type_id: walletType,
                        name,
                        currency,
                        balance: parseFloat(balance),
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = document.getElementById('wallet_id');
                        const option = document.createElement('option');
                        option.value = data.wallet.id;
                        option.text =
                            `${data.wallet.name} (${data.wallet.currency.symbol} ${data.wallet.balance.toFixed(2)})`;
                        option.selected = true;
                        select.appendChild(option);

                        closeWalletModal();
                        document.getElementById('newWalletName').value = '';
                        document.getElementById('newWalletCurrency').value = '';
                        document.getElementById('newWalletBalance').value = '';
                        document.getElementById('newWalletType').value = '';
                    } else {
                        alert("Error adding wallet");
                    }
                });
        }
    </script>

</x-app-layout>
