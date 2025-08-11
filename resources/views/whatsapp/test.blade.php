<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">WhatsApp Expense Integration</h1>

            <!-- Parse Expense Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Parse Expense Message</h2>
                <form id="parseExpenseForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Expense Message
                        </label>
                        <textarea id="message" name="message" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="e.g., Spent 500 on lunch at restaurant using HDFC card" required></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Parse Message
                        </button>

                        <button type="button" id="parseAndCreateBtn"
                            class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Parse & Create Transaction
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div id="results" class="hidden">
                <!-- Parsed Data -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-4">Parsed Expense Data</h3>
                    <div id="parsedData" class="grid grid-cols-2 gap-4"></div>
                </div>

                <!-- New Entries Created -->
                <div id="newEntriesSection" class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 hidden">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">New Entries Created</h3>
                    <div id="newEntries"></div>
                </div>

                <!-- Suggestions -->
                <div id="suggestionsSection" class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6 hidden">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-4">Suggestions</h3>
                    <div id="suggestions"></div>
                </div>

                <!-- Transaction Created -->
                <div id="transactionSection" class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-6 hidden">
                    <h3 class="text-lg font-semibold text-purple-800 mb-4">Transaction Created</h3>
                    <div id="transactionData"></div>
                </div>
            </div>

            <!-- Error Section -->
            <div id="error" class="hidden bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-red-800 mb-2">Error</h3>
                <div id="errorMessage" class="text-red-700"></div>
            </div>

            <!-- Loading Indicator -->
            <div id="loading" class="hidden text-center py-8">
                <div
                    class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-blue-500">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Processing...
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Transactions</h2>
                <button id="loadRecentBtn"
                    class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 mb-4">
                    Load Recent Transactions
                </button>
                <div id="recentTransactions" class="space-y-4"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const parseForm = document.getElementById('parseExpenseForm');
            const parseAndCreateBtn = document.getElementById('parseAndCreateBtn');
            const loadRecentBtn = document.getElementById('loadRecentBtn');
            const loading = document.getElementById('loading');
            const results = document.getElementById('results');
            const error = document.getElementById('error');

            function showLoading() {
                loading.classList.remove('hidden');
                results.classList.add('hidden');
                error.classList.add('hidden');
            }

            function hideLoading() {
                loading.classList.add('hidden');
            }

            function showError(message) {
                error.classList.remove('hidden');
                document.getElementById('errorMessage').textContent = message;
                hideLoading();
            }

            function showResults(data) {
                results.classList.remove('hidden');

                // Display parsed data
                const parsedDataDiv = document.getElementById('parsedData');
                parsedDataDiv.innerHTML = '';

                if (data.parsed_expense) {
                    const expense = data.parsed_expense;
                    parsedDataDiv.innerHTML = `
                <div><strong>Amount:</strong> ₹${expense.amount}</div>
                <div><strong>Category:</strong> ${expense.category_name}</div>
                <div><strong>Wallet:</strong> ${expense.wallet_name}</div>
                <div><strong>Person:</strong> ${expense.person_name}</div>
                <div><strong>Date:</strong> ${expense.date}</div>
                <div><strong>Notes:</strong> ${expense.notes || 'None'}</div>
            `;
                }

                // Display new entries
                if (data.new_entries_created && Object.values(data.new_entries_created).some(arr => arr.length >
                    0)) {
                    const newEntriesSection = document.getElementById('newEntriesSection');
                    const newEntriesDiv = document.getElementById('newEntries');
                    newEntriesSection.classList.remove('hidden');

                    let html = '';
                    if (data.new_entries_created.categories.length > 0) {
                        html += '<div><strong>New Categories:</strong> ' + data.new_entries_created.categories.map(
                            c => c.name).join(', ') + '</div>';
                    }
                    if (data.new_entries_created.wallets.length > 0) {
                        html += '<div><strong>New Wallets:</strong> ' + data.new_entries_created.wallets.map(w => w
                            .name).join(', ') + '</div>';
                    }
                    if (data.new_entries_created.persons.length > 0) {
                        html += '<div><strong>New Persons:</strong> ' + data.new_entries_created.persons.map(p => p
                            .name).join(', ') + '</div>';
                    }
                    newEntriesDiv.innerHTML = html;
                }

                // Display suggestions
                if (data.suggestions && Object.keys(data.suggestions).length > 0) {
                    const suggestionsSection = document.getElementById('suggestionsSection');
                    const suggestionsDiv = document.getElementById('suggestions');
                    suggestionsSection.classList.remove('hidden');

                    let html = '';
                    if (data.suggestions.similar_amount_categories) {
                        html += '<div><strong>Similar Amount Categories:</strong> ' + data.suggestions
                            .similar_amount_categories.join(', ') + '</div>';
                    }
                    if (data.suggestions.common_wallets) {
                        html += '<div><strong>Common Wallets:</strong> ' + data.suggestions.common_wallets.join(
                            ', ') + '</div>';
                    }
                    suggestionsDiv.innerHTML = html;
                }

                // Display transaction if created
                if (data.transaction) {
                    const transactionSection = document.getElementById('transactionSection');
                    const transactionDiv = document.getElementById('transactionData');
                    transactionSection.classList.remove('hidden');

                    transactionDiv.innerHTML = `
                <div><strong>Transaction ID:</strong> ${data.transaction.id}</div>
                <div><strong>Amount:</strong> ₹${data.transaction.amount}</div>
                <div><strong>Type:</strong> ${data.transaction.type}</div>
                <div><strong>Created:</strong> ${new Date(data.transaction.created_at).toLocaleString()}</div>
                ${data.updated_wallet_balance ? `<div><strong>Updated Wallet Balance:</strong> ₹${data.updated_wallet_balance}</div>` : ''}
            `;
                }

                hideLoading();
            }

            // Parse expense form submission
            parseForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const message = document.getElementById('message').value;
                if (!message.trim()) return;

                showLoading();

                fetch('/whatsapp/parse-expense', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showResults(data.data);
                        } else {
                            showError(data.message || 'Failed to parse expense');
                        }
                    })
                    .catch(err => {
                        showError('Network error: ' + err.message);
                    });
            });

            // Parse and create button
            parseAndCreateBtn.addEventListener('click', function() {
                const message = document.getElementById('message').value;
                if (!message.trim()) return;

                showLoading();

                fetch('/whatsapp/parse-and-create', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: message,
                            auto_create: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showResults(data.data);
                        } else {
                            showError(data.message || 'Failed to parse and create expense');
                        }
                    })
                    .catch(err => {
                        showError('Network error: ' + err.message);
                    });
            });

            // Load recent transactions
            loadRecentBtn.addEventListener('click', function() {
                fetch('/whatsapp/recent-transactions', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const container = document.getElementById('recentTransactions');
                            container.innerHTML = '';

                            data.data.forEach(transaction => {
                                const div = document.createElement('div');
                                div.className = 'border border-gray-200 rounded-lg p-4';
                                div.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-semibold">₹${transaction.amount}</div>
                                <div class="text-sm text-gray-600">${transaction.category?.name || 'Unknown'} • ${transaction.wallet?.name || 'Unknown'}</div>
                                <div class="text-sm text-gray-500">${transaction.date}</div>
                            </div>
                            <div class="text-sm font-medium ${transaction.type === 'expense' ? 'text-red-600' : 'text-green-600'}">
                                ${transaction.type}
                            </div>
                        </div>
                        ${transaction.note ? `<div class="text-sm text-gray-600 mt-2">${transaction.note}</div>` : ''}
                    `;
                                container.appendChild(div);
                            });
                        } else {
                            showError('Failed to load recent transactions');
                        }
                    })
                    .catch(err => {
                        showError('Network error: ' + err.message);
                    });
            });
        });
    </script>
</x-app-layout>
