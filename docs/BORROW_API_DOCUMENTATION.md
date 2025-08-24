# Borrow API Documentation

## Overview
The Borrow API provides comprehensive borrow/lend management functionality with service layer separation, following the same patterns as the Transaction and Budget APIs. It supports complex repayment tracking, wallet balance management, and detailed financial analytics.

## Authentication
All Borrow API endpoints require authentication using Laravel Sanctum tokens:
```
Authorization: Bearer {your-token}
```

## Base URL
```
/api/borrows
```

## Endpoints

### 1. Get All Borrows/Lends
**GET** `/api/borrows`

**Query Parameters:**
- `search` - Search in person names, wallet names, amounts, or notes
- `type` - Filter by type (`borrowed`, `lent`)
- `status` - Filter by status (`pending`, `partial`, `returned`)
- `wallet_id` - Filter by wallet ID
- `person_id` - Filter by expense person ID
- `start_date` - Filter borrows from date (YYYY-MM-DD)
- `end_date` - Filter borrows until date (YYYY-MM-DD)
- `min_amount` - Filter by minimum amount
- `max_amount` - Filter by maximum amount
- `sort_by` - Sort field (date, amount, created_at, status)
- `sort_order` - Sort order (asc, desc)
- `per_page` - Items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "data": {
        "data": [
            {
                "id": 1,
                "amount": 500.00,
                "returned_amount": 200.00,
                "status": "partial",
                "borrow_type": "lent",
                "date": "2024-01-15",
                "note": "Emergency loan",
                "person": {
                    "id": 1,
                    "name": "John Doe"
                },
                "wallet": {
                    "id": 1,
                    "name": "Main Wallet",
                    "currency": {
                        "code": "USD",
                        "symbol": "$"
                    }
                }
            }
        ],
        "current_page": 1,
        "total": 25,
        "per_page": 15
    },
    "message": "Borrows retrieved successfully"
}
```

### 2. Create Borrow/Lend
**POST** `/api/borrows`

**Request Body:**
```json
{
    "person_id": 1,
    "amount": 500.00,
    "date": "2024-01-15",
    "borrow_type": "lent",
    "wallet_id": 1,
    "note": "Emergency loan"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "amount": 500.00,
        "returned_amount": 0,
        "status": "pending",
        "borrow_type": "lent",
        "date": "2024-01-15",
        "note": "Emergency loan",
        "person": {...},
        "wallet": {...}
    },
    "message": "Borrow/Lend created successfully"
}
```

### 3. Get Borrow Details with Repayment History
**GET** `/api/borrows/{id}`

**Query Parameters:**
- `per_page` - Items per page for history (default: 10)

**Response:**
```json
{
    "success": true,
    "data": {
        "borrow": {
            "id": 1,
            "amount": 500.00,
            "returned_amount": 200.00,
            "status": "partial",
            "borrow_type": "lent",
            "date": "2024-01-15",
            "note": "Emergency loan",
            "person": {...},
            "wallet": {...}
        },
        "histories": {
            "data": [
                {
                    "id": 1,
                    "amount": 200.00,
                    "date": "2024-01-20",
                    "wallet": {
                        "id": 1,
                        "name": "Main Wallet",
                        "currency": {...}
                    }
                }
            ],
            "current_page": 1,
            "total": 1
        }
    },
    "message": "Borrow retrieved successfully"
}
```

### 4. Update Borrow/Lend
**PUT** `/api/borrows/{id}`

**Request Body:**
```json
{
    "person_id": 1,
    "amount": 600.00,
    "date": "2024-01-15",
    "borrow_type": "lent",
    "wallet_id": 1,
    "note": "Updated emergency loan amount"
}
```

### 5. Delete Borrow/Lend
**DELETE** `/api/borrows/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Borrow/Lend deleted successfully"
}
```

### 6. Get Expense People
**GET** `/api/borrows/expense-people`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "user_id": 1
        }
    ],
    "message": "Expense people retrieved successfully"
}
```

### 7. Get Wallets
**GET** `/api/borrows/wallets`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Main Wallet",
            "balance": 1500.00,
            "currency": {
                "code": "USD",
                "symbol": "$"
            }
        }
    ],
    "message": "Wallets retrieved successfully"
}
```

### 8. Process Repayment
**POST** `/api/borrows/{id}/repay`

**Request Body:**
```json
{
    "repay_amount": 150.00,
    "wallet_id": 1,
    "date": "2024-01-25"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "history": {
            "id": 2,
            "amount": 150.00,
            "date": "2024-01-25",
            "wallet": {...}
        },
        "borrow": {
            "id": 1,
            "amount": 500.00,
            "returned_amount": 350.00,
            "status": "partial",
            ...
        }
    },
    "message": "Repayment recorded successfully"
}
```

### 9. Update Repayment
**PUT** `/api/borrows/{borrow_id}/repayments/{history_id}`

**Request Body:**
```json
{
    "amount": 175.00,
    "wallet_id": 1,
    "date": "2024-01-25"
}
```

### 10. Delete Repayment
**DELETE** `/api/borrows/{borrow_id}/repayments/{history_id}`

**Response:**
```json
{
    "success": true,
    "data": {
        "borrow": {
            "id": 1,
            "returned_amount": 200.00,
            "status": "partial",
            ...
        }
    },
    "message": "Repayment deleted successfully"
}
```

### 11. Get Borrow Statistics
**GET** `/api/borrows/stats`

**Query Parameters:**
- `start_date` - Statistics start date
- `end_date` - Statistics end date

**Response:**
```json
{
    "success": true,
    "data": {
        "total_borrows": 15,
        "total_borrowed_amount": 2500.00,
        "total_lent_amount": 3000.00,
        "total_returned_borrowed": 1800.00,
        "total_returned_lent": 2200.00,
        "pending_count": 5,
        "partial_count": 8,
        "returned_count": 2,
        "net_borrowed_outstanding": 700.00,
        "net_lent_outstanding": 800.00,
        "net_position": 100.00
    },
    "message": "Borrow statistics retrieved successfully"
}
```

### 12. Get Borrows by Status
**GET** `/api/borrows/by-status`

**Response:**
```json
{
    "success": true,
    "data": {
        "pending": [...],
        "partial": [...],
        "returned": [...]
    },
    "message": "Borrows by status retrieved successfully"
}
```

### 13. Bulk Delete Borrows
**POST** `/api/borrows/bulk-delete`

**Request Body:**
```json
{
    "borrow_ids": [1, 2, 3]
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "deleted_count": 3
    },
    "message": "Successfully deleted 3 borrow(s)"
}
```

## Error Responses

All endpoints return standardized error responses:

```json
{
    "success": false,
    "message": "Error description",
    "error": "Detailed error message"
}
```

**Common HTTP Status Codes:**
- `200` - Success
- `201` - Created successfully
- `403` - Unauthorized access
- `404` - Resource not found
- `422` - Validation errors
- `500` - Server error

## Business Logic Features

### Wallet Balance Management
- **Automatic Balance Updates**: Wallet balances are automatically updated when borrows/lends are created, updated, or deleted
- **Insufficient Balance Protection**: System prevents lending more than available wallet balance
- **Transaction Rollback**: All wallet changes are properly rolled back when borrows are deleted

### Repayment Tracking
- **Status Management**: Automatic status updates (pending → partial → returned) based on repayment progress
- **History Tracking**: Complete audit trail of all repayments with dates and wallets
- **Validation**: Prevents repayments exceeding outstanding amounts

### Data Integrity
- **Database Transactions**: All operations use database transactions for data consistency
- **Ownership Validation**: Users can only access their own borrows and related data
- **Referential Integrity**: Validates person and wallet ownership before operations

### Advanced Features
- **Complex Filtering**: Multi-dimensional filtering by date, amount, status, type, person, wallet
- **Statistical Analysis**: Comprehensive statistics including net positions and outstanding amounts
- **Bulk Operations**: Efficient bulk deletion with proper balance restoration
- **Search Functionality**: Full-text search across multiple fields

## Service Layer Architecture

The Borrow API follows a clean service layer pattern:

- **BorrowController** - Handles HTTP requests/responses and validation
- **BorrowService** - Contains all business logic and database operations
- **Models** - Borrow, BorrowHistory, ExpensePerson, Wallet models with relationships

### Benefits:
- **Testability** - Business logic isolated in services
- **Reusability** - Service methods used across web and API controllers
- **Maintainability** - Consistent error handling and validation
- **Security** - Centralized authorization and ownership validation
- **Performance** - Optimized queries with proper eager loading

## Security Features

### Authentication & Authorization
- Laravel Sanctum token authentication required for all endpoints
- User isolation - users can only access their own data
- Ownership validation for all borrow and repayment operations
- Secure error handling without information leakage

### Input Validation
- Comprehensive validation rules for all inputs
- Amount range validation and precision handling
- Date validation and format consistency
- Referential integrity checks for related entities

### Data Protection
- Sensitive financial data protected with proper access controls
- Transaction-safe operations to prevent data corruption
- Audit trails for all financial operations
- Secure deletion with balance restoration
