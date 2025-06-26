<x-app-layout>
    <x-slot name="title">
        {{ __('Add Transaction') }} - {{ config('app.name', 'expenses') }}
    </x-slot>


    <div class="sm:ml-64">
        <div class="w-full mx-auto max-w-7xl sm:px-6 lg:px-8 bg-white p-4 rounded-2xl shadow m-4 flex flex-col"
            style="height: 88vh;">

            <!-- Breadcrumb & Create Button -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-3 gap-4">
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
                            <svg class="w-4 h-4 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M7.05 4.05a1 1 0 011.41 0l5.5 5.5a1 1 0 010 1.41l-5.5 5.5a1 1 0 01-1.41-1.41L12.09 10 7.05 4.95a1 1 0 010-1.41z" />
                            </svg>
                            <span class="text-gray-700">Transactions</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="mt-2 text-sm text-gray-600">
                <strong>Available Wallets: </strong> {{ $wallets->count() > 0 ? '' : 'None' }}<br>
                @foreach ($wallets as $wallet)
                    <strong>{{ $wallet->name }}:</strong> {{ $wallet->currency->symbol }}
                    {{ number_format($wallet->balance, 2) }}<br>
                @endforeach
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="mt-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-5">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700">Type</label>
                            <select name="type" id="type"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                                <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Expense
                                </option>
                                <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Income</option>
                            </select>
                            @error('type')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="category_id" class="block text-sm font-semibold text-gray-700">
                                    Category <span class="text-xs text-gray-500 font-normal">(optional)</span>
                                </label>
                                <button type="button" onclick="openCategoryModal()"
                                    class="text-sm text-blue-600 hover:underline">+ Add New</button>
                            </div>
                            <select name="category_id" id="category_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">None</option>
                                @foreach ($categories->where('user_id', auth()->id()) as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Expense Person -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="expense_person_id" class="block text-sm font-semibold text-gray-700">Expense
                                    Person <span class="text-xs text-gray-500 font-normal">(optional)</span></label>
                                <button type="button" onclick="openPersonModal()"
                                    class="text-sm text-blue-600 hover:underline">+ Add New</button>
                            </div>
                            <select name="expense_person_id" id="expense_person_id"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">None</option>
                                @foreach ($people as $person)
                                    <option value="{{ $person->id }}"
                                        {{ old('expense_person_id') == $person->id ? 'selected' : '' }}>
                                        {{ $person->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('expense_person_id')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-5">
                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-semibold text-gray-700">Amount</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                min="0" step="0.01" required>
                            @error('amount')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Wallet -->
                        <div>
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
                        <div>
                            <label for="date" class="block text-sm font-semibold text-gray-700">Date</label>
                            <input type="date" name="date" id="date"
                                value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                required>
                            @error('date')
                                <span class="text-sm text-red-600">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Note -->
                    </div>
                </div>
                <div class="mt-5">
                    <label for="note" class="block text-sm font-semibold text-gray-700">
                        Note <span class="text-xs text-gray-500 font-normal">(optional)</span>
                    </label>
                    <textarea name="note" id="note" rows="3"
                        class="w-full p-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('note') }}</textarea>
                    @error('note')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-end mt-6">
                    <x-primary-button>
                        {{ __('Create Transaction') }}
                    </x-primary-button>
                </div>
            </form>
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
            <div class="mb-4">
                <label for="newWalletName" class="block text-sm font-semibold text-gray-700">Wallet Name</label>
                <input type="text" id="newWalletName"
                    class="w-full p-2 mt-1 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Wallet name" required>
            </div>
            @if ($currencies->count() > 0)
                <div class="mb-4">
                    <label for="newWalletCurrency" class="block text-sm font-semibold text-gray-700">Currency</label>
                    <select id="newWalletCurrency"
                        class="w-full p-2 mt-1 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->symbol }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="mb-4">
                <label for="newWalletBalance" class="block text-sm font-semibold text-gray-700">Initial
                    Balance</label>
                <input type="number" id="newWalletBalance" value="0"
                    class="w-full p-2 mt-1 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Initial Balance" min="0" step="0.01">
            </div>
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
                        currency_id: currency,
                        name,
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
                            `${data.wallet.name} (${data.wallet.currency.symbol} ${Number(data.wallet.balance).toFixed(2)})`;
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
