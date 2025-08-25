# API Endpoints Reference (Table View)

This document aggregates all API endpoints described in the docs folder into a single table with concise examples.

- Base paths vary per module (see Route column)
- Authentication: Unless noted, all endpoints require Bearer token (Laravel Sanctum)
- Timestamps are UTC unless specified

| Module | Method | Route | Description | Auth | Request Body (example) | Sample Response (example) | Notes |
|---|---|---|---|---|---|---|---|
| Auth | POST | /api/auth/register | Register new user and return token | No | `{ "name": "John Doe", "email": "john@example.com", "password": "password123", "password_confirmation": "password123", "device_name": "Mobile App" }` | `{ "success": true, "data": { "user": { "id": 1, "name": "John Doe" }, "token": "1|abc..." } }` | `device_name` optional |
| Auth | POST | /api/auth/login | Login and retrieve token | No | `{ "email": "john@example.com", "password": "password123", "device_name": "Web App" }` | `{ "success": true, "data": { "user": { "id": 1, "name": "John Doe" }, "token": "1|abc..." } }` | — |
| Auth | GET | /api/auth/user | Get authenticated user info | Yes | — | `{ "success": true, "data": { "user": { "id": 1, "name": "John Doe" } } }` | — |
| Auth | POST | /api/auth/logout | Logout current device | Yes | — | `{ "success": true, "message": "Logout successful" }` | — |
| Auth | POST | /api/auth/logout-all | Logout all devices | Yes | — | `{ "success": true, "message": "Logged out from all devices" }` | — |
| Auth | GET | /api/auth/tokens | List active tokens | Yes | — | `{ "success": true, "data": { "tokens": [ { "id": 1, "name": "Mobile App" } ] } }` | — |
| Auth | POST | /api/auth/revoke-token | Revoke specific token | Yes | `{ "token_id": 1 }` | `{ "success": true, "message": "Token revoked successfully" }` | — |
| Account Settings | GET | /api/account/profile | Get current user's profile | Yes | — | `{ "success": true, "data": { "id": 5, "name": "John" } }` | — |
| Account Settings | PUT | /api/account/profile | Update profile (name, email, phone, address) | Yes | `{ "name": "John Smith", "email": "john@ex.com", "phone": "+1...", "address": "..." }` | `{ "success": true, "message": "Profile updated successfully" }` | Email must be unique |
| Account Settings | GET | /api/account/settings | Get all settings (profile, notifications, security, activity) | Yes | — | `{ "success": true, "data": { "profile": {...}, "notifications": {...}, "security": {...}, "activity": {...} } }` | — |
| Account Settings | PUT | /api/account/password | Update password (verify current) | Yes | `{ "current_password": "old", "password": "newPass123", "password_confirmation": "newPass123" }` | `{ "success": true, "message": "Password updated successfully" }` | 422 if current password invalid |
| Account Settings | GET | /api/account/security | Get account security info | Yes | — | `{ "success": true, "data": { "has_set_password": true, "password_updated_at": "..." } }` | — |
| Account Settings | DELETE | /api/account/delete | Delete account (requires password + confirmation) | Yes | `{ "password": "userPass", "confirmation": "DELETE" }` | `{ "success": true, "message": "Account deleted successfully" }` | Revokes tokens, then deletes |
| Account Settings | GET | /api/account/notifications | Get notification preferences | Yes | — | `{ "success": true, "data": { "reminder_frequency": "daily", "reminder_time": "09:00", "timezone": "UTC" } }` | — |
| Account Settings | PUT | /api/account/notifications | Update notification preferences | Yes | `{ "wants_reminder": true, "reminder_frequency": "custom_weekdays", "reminder_time": "09:30", "timezone": "America/Los_Angeles", "custom_weekdays": [1,2,3,4,5] }` | `{ "success": true, "message": "Notification preferences updated successfully" }` | If `random`, include `random_min_days`, `random_max_days` |
| Account Settings | GET | /api/account/activity | Get account activity summary | Yes | — | `{ "success": true, "data": { "total_transactions": 156, "total_budgets": 8 } }` | — |
| Account Settings | GET | /api/account/config-options | Get timezones, reminder frequencies, weekdays | Yes | — | `{ "success": true, "data": { "timezones": {...}, "reminder_frequencies": {...}, "weekdays": {...} } }` | — |
| Transactions | GET | /api/transactions | List transactions (paginated, filters) | Yes | — (query: `page, per_page, filter, type, ...`) | `{ "success": true, "data": { "transactions": [...], "pagination": {...} } }` | Filters: date range, category, person, wallet |
| Transactions | GET | /api/transactions/all | List all transactions (no pagination) | Yes | — (query like above) | `{ "success": true, "data": { "transactions": [...] } }` | Large datasets caution |
| Transactions | POST | /api/transactions | Create transaction | Yes | `{ "type": "expense", "amount": 75.5, "date": "2024-01-20", "wallet_id": 1, "category_id": 3, "note": "..." }` | `{ "success": true, "data": { "id": 123, "amount": "75.50" }, "message": "Expense created successfully" }` | Supports attachments/camera images |
| Transactions | GET | /api/transactions/{id} | Get transaction by ID | Yes | — | `{ "success": true, "data": { "id": 123, "attachments": [...] } }` | — |
| Transactions | PUT | /api/transactions/{id} | Update transaction | Yes | `{ "amount": 85.0, "date": "2024-01-20", "wallet_id": 1, "removed_attachments": ["attachments/1/old.jpg"] }` | `{ "success": true }` | — |
| Transactions | DELETE | /api/transactions/{id} | Delete transaction | Yes | — | `{ "success": true, "message": "Expense deleted successfully" }` | Reverts wallet balance |
| Transactions | GET | /api/transactions/stats | Get transaction statistics | Yes | — (query filters) | `{ "success": true, "data": { "total_income": "2500.00", "total_expense": "1850.75" } }` | — |
| Transactions | GET | /api/transactions/by-category | Grouped totals by category | Yes | — | `{ "success": true, "data": [ { "category_id": 1, "total_amount": "450.00" } ] }` | — |
| Transactions | GET | /api/transactions/monthly-summary | Monthly summary for a year | Yes | — (query: `year`) | `{ "success": true, "data": [ { "month": 1, "type": "expense", "total_amount": "3200.50" } ] }` | `year` required |
| Transactions | GET | /api/transactions/form-data | Form dropdown data | Yes | — | `{ "success": true, "data": { "categories": [...], "people": [...], "wallets": [...] } }` | — |
| Transactions | POST | /api/transactions/upload-attachment | Upload file (optionally with transaction_id) | Yes | multipart: `file=@...`, `transaction_id` | `{ "success": true, "data": { "path": "attachments/..." } }` | — |
| Transactions | POST | /api/transactions/save-camera-image | Save camera image (optional transaction_id) | Yes | `{ "image": "data:image/jpeg;base64,...", "transaction_id": 123 }` | `{ "success": true }` | — |
| Transactions | DELETE | /api/transactions/delete-attachment | Delete unattached uploaded file | Yes | `{ "attachment_path": "attachments/..." }` | `{ "success": true }` | When not tied to a transaction |
| Transactions | POST | /api/transactions/{id}/add-attachment | Add attachment to existing transaction | Yes | multipart: `file=@...` | `{ "success": true, "message": "Attachment added to transaction successfully" }` | — |
| Transactions | POST | /api/transactions/{id}/add-camera-image | Add camera image to existing transaction | Yes | `{ "image": "data:image/jpeg;base64,..." }` | `{ "success": true }` | — |
| Transactions | DELETE | /api/transactions/{id}/remove-attachment | Remove attachment from transaction | Yes | `{ "attachment_path": "attachments/..." }` | `{ "success": true }` | Also deletes file |
| Transactions | GET | /api/transactions/{id}/attachment/{index} | Download/view attachment | Yes | — | (returns file) | `index` is 0-based |
| Budgets | GET | /api/budgets | List budgets (paginated) | Yes | — (query filters) | `{ "success": true, "data": { "data": [...], "current_page": 1 } }` | — |
| Budgets | POST | /api/budgets | Create budget | Yes | `{ "category_id": 1, "amount": 1500, "start_date": "2024-01-01", "end_date": "2024-01-31", "roll_over": true, "frequency": "monthly" }` | `{ "success": true, "message": "Budget created successfully" }` | — |
| Budgets | GET | /api/budgets/{id} | Get budget with histories (paginated) | Yes | — (query: `per_page`) | `{ "success": true, "data": { "budget": {...}, "histories": {...} } }` | — |
| Budgets | PUT | /api/budgets/{id} | Update budget | Yes | `{ "amount": 1800, "frequency": "monthly" }` | `{ "success": true }` | — |
| Budgets | DELETE | /api/budgets/{id} | Delete budget | Yes | — | `{ "success": true, "message": "Budget deleted successfully" }` | — |
| Budgets | GET | /api/budgets/categories | Get user's categories | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "Food & Dining" } ] }` | — |
| Budgets | GET | /api/budgets/stats | Get budget stats | Yes | — (query: date range, category) | `{ "success": true, "data": { "total_budgets": 5, "total_spent": 6200 } }` | — |
| Budgets | GET | /api/budgets/performance-by-category | Category performance summary | Yes | — (query: date range) | `{ "success": true, "data": [ { "category_name": "Food & Dining", "total_spent": 1200 } ] }` | — |
| Budgets | GET | /api/budgets/trends | Budget trends over time | Yes | — (query: `period`, `category_id`) | `{ "success": true, "data": [ { "period": "2024-01", "total_spent": 4200 } ] }` | — |
| Budgets | GET | /api/budgets/active | Get active budgets | Yes | — | `{ "success": true, "data": [ { "id": 1, "amount": 1500 } ] }` | — |
| Budgets | POST | /api/budgets/check-overlaps | Check overlapping budgets | Yes | `{ "category_id": 1, "start_date": "2024-01-01", "end_date": "2024-01-31", "budget_id": 2 }` | `{ "success": true, "data": { "has_overlaps": false } }` | — |
| Budgets | POST | /api/budgets/bulk-delete | Bulk delete budgets | Yes | `{ "budget_ids": [1,2,3] }` | `{ "success": true, "data": { "deleted_count": 3 } }` | — |
| Borrow/Lend | GET | /api/borrows | List borrows/lends (filters) | Yes | — (query filters) | `{ "success": true, "data": { "data": [...], "total": 25 } }` | — |
| Borrow/Lend | POST | /api/borrows | Create borrow/lend | Yes | `{ "person_id": 1, "amount": 500, "date": "2024-01-15", "borrow_type": "lent", "wallet_id": 1, "note": "..." }` | `{ "success": true, "message": "Borrow/Lend created successfully" }` | — |
| Borrow/Lend | GET | /api/borrows/{id} | Get borrow with repayment history | Yes | — (query: `per_page`) | `{ "success": true, "data": { "borrow": {...}, "histories": {...} } }` | — |
| Borrow/Lend | PUT | /api/borrows/{id} | Update borrow/lend | Yes | `{ "amount": 600, "note": "Updated..." }` | `{ "success": true }` | — |
| Borrow/Lend | DELETE | /api/borrows/{id} | Delete borrow/lend | Yes | — | `{ "success": true, "message": "Borrow/Lend deleted successfully" }` | — |
| Borrow/Lend | GET | /api/borrows/expense-people | Get expense people | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "John Doe" } ] }` | — |
| Borrow/Lend | GET | /api/borrows/wallets | Get wallets | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "Main Wallet" } ] }` | — |
| Borrow/Lend | POST | /api/borrows/{id}/repay | Add repayment | Yes | `{ "repay_amount": 150, "wallet_id": 1, "date": "2024-01-25" }` | `{ "success": true, "message": "Repayment recorded successfully" }` | — |
| Borrow/Lend | PUT | /api/borrows/{borrow_id}/repayments/{history_id} | Update repayment | Yes | `{ "amount": 175, "wallet_id": 1, "date": "2024-01-25" }` | `{ "success": true }` | — |
| Borrow/Lend | DELETE | /api/borrows/{borrow_id}/repayments/{history_id} | Delete repayment | Yes | — | `{ "success": true, "message": "Repayment deleted successfully" }` | — |
| Borrow/Lend | GET | /api/borrows/stats | Borrow stats | Yes | — (query: date range) | `{ "success": true, "data": { "total_borrows": 15, "net_position": 100 } }` | — |
| Borrow/Lend | GET | /api/borrows/by-status | Borrows grouped by status | Yes | — | `{ "success": true, "data": { "pending": [...], "partial": [...], "returned": [...] } }` | — |
| Borrow/Lend | POST | /api/borrows/bulk-delete | Bulk delete borrows | Yes | `{ "borrow_ids": [1,2,3] }` | `{ "success": true, "data": { "deleted_count": 3 } }` | — |
| Categories | GET | /api/categories | List categories (paginated) | Yes | — (query: `search, per_page, page`) | `{ "success": true, "data": { "categories": [...], "pagination": {...} } }` | — |
| Categories | GET | /api/categories/all | List all categories | Yes | — | `{ "success": true, "data": { "categories": [...] } }` | — |
| Categories | POST | /api/categories | Create category | Yes | `{ "name": "Transportation" }` | `{ "success": true, "message": "Category created successfully" }` | Name unique per user |
| Categories | GET | /api/categories/{id} | Get category | Yes | — | `{ "success": true, "data": { "category": { "id": 1, "name": "Food" } } }` | — |
| Categories | PUT | /api/categories/{id} | Update category | Yes | `{ "name": "Groceries" }` | `{ "success": true, "message": "Category updated successfully" }` | — |
| Categories | DELETE | /api/categories/{id} | Delete category | Yes | — | `{ "success": true, "message": "Category deleted successfully" }` | 409 if has expenses |
| Categories | GET | /api/categories/stats | Category stats | Yes | — | `{ "success": true, "data": { "total_categories": 10 } }` | — |
| Wallets | GET | /api/wallets | List wallets (paginated) | Yes | — (query filters) | `{ "success": true, "data": { "wallets": [...], "pagination": {...} } }` | — |
| Wallets | GET | /api/wallets/all | List all wallets | Yes | — (query: `active_only`) | `{ "success": true, "data": { "wallets": [...] } }` | — |
| Wallets | POST | /api/wallets | Create wallet | Yes | `{ "wallet_type_id": 1, "name": "Savings", "balance": 1000, "currency_id": 1, "is_active": true }` | `{ "success": true, "message": "Wallet created successfully" }` | — |
| Wallets | GET | /api/wallets/{id} | Get wallet (optionally with transactions) | Yes | — (query: `include_transactions`, `transactions_per_page`) | `{ "success": true, "data": { "wallet": {...} } }` | — |
| Wallets | PUT | /api/wallets/{id} | Update wallet | Yes | `{ "name": "Updated Wallet", "balance": 2000 }` | `{ "success": true, "message": "Wallet updated successfully" }` | — |
| Wallets | DELETE | /api/wallets/{id} | Delete wallet | Yes | — | `{ "success": true, "message": "Wallet deleted successfully" }` | 409 if has transactions |
| Wallets | POST | /api/wallets/transfer | Transfer funds between wallets | Yes | `{ "from_wallet_id": 1, "to_wallet_id": 2, "amount": 500 }` | `{ "success": true, "message": "Transfer completed successfully" }` | Atomic transaction |
| Wallets | GET | /api/wallets/stats | Wallet stats | Yes | — | `{ "success": true, "data": { "total_wallets": 5 } }` | — |
| Wallets | GET | /api/wallets/balance-summary | Balance by currency | Yes | — | `{ "success": true, "data": { "balance_summary": [ { "currency": { "code": "USD" }, "total_balance": 5500.75 } ] } }` | — |
| Wallets | GET | /api/wallets/by-currency/{currencyId} | Wallets filtered by currency | Yes | — | `{ "success": true, "data": { "wallets": [...] } }` | — |
| Wallets | GET | /api/wallets/wallet-types | Get wallet types | Yes | — | `{ "success": true, "data": { "wallet_types": [...] } }` | — |
| Wallets | GET | /api/wallets/currencies | Get currencies | Yes | — | `{ "success": true, "data": { "currencies": [...] } }` | — |
| EMI Loans | GET | /api/emi-loans | List EMI loans (paginated, filters) | Yes | — (query filters) | `{ "success": true, "data": { "data": [...], "total": 1 } }` | — |
| EMI Loans | POST | /api/emi-loans | Create EMI loan | Yes | `{ "name": "Car Loan", "total_amount": 250000, "interest_rate": 9.5, "start_date": "2024-03-01", "tenure_months": 60, "loan_type": "reducing_balance", "is_auto_deduct": true, "default_wallet_id": 1 }` | `{ "success": true, "message": "EMI loan created successfully" }` | Generates schedules |
| EMI Loans | GET | /api/emi-loans/{id} | Get EMI loan (with schedules) | Yes | — (query: `per_page`) | `{ "success": true, "data": { "emi_loan": {...}, "schedules": {...} } }` | — |
| EMI Loans | PUT | /api/emi-loans/{id} | Update EMI loan | Yes | (same as create) | `{ "success": true, "message": "EMI loan updated successfully" }` | Regenerates schedules |
| EMI Loans | DELETE | /api/emi-loans/{id} | Delete EMI loan | Yes | — | `{ "success": true, "message": "EMI loan deleted successfully" }` | — |
| EMI Loans | GET | /api/emi-loans/categories | Get categories | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "Housing" } ] }` | — |
| EMI Loans | GET | /api/emi-loans/wallets | Get wallets | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "SBI Checking" } ] }` | — |
| EMI Loans | GET | /api/emi-loans/upcoming-schedules | Get upcoming schedules | Yes | — (query: `notification_days`) | `{ "success": true, "data": [ { "id": 25, "due_date": "2024-03-01" } ] }` | — |
| EMI Loans | POST | /api/emi-loans/{loanId}/schedules/{scheduleId}/mark-paid | Mark schedule as paid | Yes | `{ "wallet_id": 2, "paid_amount": 4321.5, "paid_date": "2024-03-01", "notes": "..." }` | `{ "success": true, "message": "EMI payment recorded successfully" }` | — |
| EMI Loans | PUT | /api/emi-loans/{loanId}/schedules/{scheduleId}/update-payment | Update schedule payment | Yes | (same as mark-paid) | `{ "success": true, "message": "EMI payment updated successfully" }` | — |
| EMI Loans | POST | /api/emi-loans/{loanId}/schedules/{scheduleId}/mark-unpaid | Reverse payment | Yes | — | `{ "success": true, "message": "EMI payment reversed successfully" }` | Restores wallet balance |
| EMI Loans | GET | /api/emi-loans/stats | EMI loan stats | Yes | — (query: date range) | `{ "success": true, "data": { "total_loans": 5, "active_loans": 3 } }` | — |
| EMI Loans | POST | /api/emi-loans/bulk-delete | Bulk delete EMI loans | Yes | `{ "loan_ids": [1,2,3] }` | `{ "success": true, "data": { "deleted_count": 3 } }` | — |
| Expense People | GET | /api/expense-people | List expense people (paginated) | Yes | — (query: `search, per_page, page`) | `{ "success": true, "data": { "expense_people": [...], "pagination": {...} } }` | — |
| Expense People | GET | /api/expense-people/all | List all expense people | Yes | — | `{ "success": true, "data": { "expense_people": [...] } }` | — |
| Expense People | POST | /api/expense-people | Create expense person | Yes | `{ "name": "Jane Smith" }` | `{ "success": true, "message": "Expense person created successfully" }` | Name unique per user |
| Expense People | GET | /api/expense-people/{id} | Get expense person | Yes | — | `{ "success": true, "data": { "expense_person": { "id": 1, "name": "John" } } }` | — |
| Expense People | PUT | /api/expense-people/{id} | Update expense person | Yes | `{ "name": "John Smith" }` | `{ "success": true, "message": "Expense person updated successfully" }` | — |
| Expense People | DELETE | /api/expense-people/{id} | Delete expense person | Yes | — | `{ "success": true, "message": "Expense person deleted successfully" }` | 409 if has transactions |
| Expense People | GET | /api/expense-people/search | Search expense people | Yes | — (query: `query, limit`) | `{ "success": true, "data": { "expense_people": [...] } }` | — |
| Expense People | GET | /api/expense-people/stats | Expense people stats | Yes | — | `{ "success": true, "data": { "total_expense_people": 15 } }` | — |
| Expense People | GET | /api/expense-people/with-transaction-counts | People with transaction counts | Yes | — | `{ "success": true, "data": { "expense_people": [ { "id": 1, "transactions_count": 5 } ] } }` | — |
| Support Tickets | GET | /api/support-tickets | List tickets (paginated, filters) | Yes | — (query filters; admin can filter by `user_id`) | `{ "success": true, "data": { "data": [...], "total": 25 } }` | Non-admins see own tickets only |
| Support Tickets | POST | /api/support-tickets | Create support ticket | Yes | `{ "subject": "Payment Issue", "message": "..." }` | `{ "success": true, "message": "Support ticket created successfully" }` | Requires permission to request support |
| Support Tickets | GET | /api/support-tickets/{id} | Get ticket details | Yes | — | `{ "success": true, "data": { "id": 1, "messages": [...] } }` | Ownership enforced |
| Support Tickets | DELETE | /api/support-tickets/{id} | Delete ticket | Yes | — | `{ "success": true, "message": "Support ticket deleted successfully" }` | — |
| Support Tickets | POST | /api/support-tickets/{id}/reply | Add reply to ticket | Yes | `{ "message": "Thanks, it works now" }` | `{ "success": true, "message": "Reply added successfully" }` | Updates status, sends notifications |
| Support Tickets | POST | /api/support-tickets/{id}/close | Close ticket | Yes | — | `{ "success": true, "message": "Support ticket closed successfully" }` | — |
| Support Tickets | POST | /api/support-tickets/{id}/reopen | Reopen ticket | Yes | — | `{ "success": true, "message": "Support ticket reopened successfully" }` | — |
| Support Tickets | POST | /api/support-tickets/{id}/recover | Recover soft-deleted ticket | Yes | — | `{ "success": true, "message": "Support ticket recovered successfully" }` | Admin only |
| Support Tickets | GET | /api/support-tickets/stats | Ticket stats | Yes | — | `{ "success": true, "data": { "total_tickets": 125 } }` | Admins see global stats |
| Support Tickets | GET | /api/support-tickets/by-status | Ticket counts by status | Yes | — | `{ "success": true, "data": { "opened": 15, "closed": 85 } }` | — |
| Support Tickets | POST | /api/support-tickets/bulk-update | Bulk update tickets | Yes | `{ "ticket_ids": [1,2,3], "action": "close" }` | `{ "success": true, "data": { "updated_count": 3 } }` | Actions: close, reopen, delete |
| Support Tickets | GET | /api/support-tickets/users | Users list (admin) | Yes | — | `{ "success": true, "data": [ { "id": 1, "name": "Admin" } ] }` | Admin only |

Notes:
- Auth header: `Authorization: Bearer {token}`
- Common errors: 401 Unauthorized, 422 Validation Error, 404 Not Found, 500 Server Error
- Monetary values are strings to preserve precision where applicable
- File uploads use multipart/form-data
