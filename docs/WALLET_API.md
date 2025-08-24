# Wallet API Documentation

## Overview
The Wallet API allows authenticated users to manage their financial wallets, including creating, updating, deleting wallets, and transferring funds between them. All endpoints require authentication via Bearer token.

## Base URL
All wallet endpoints are prefixed with `/api/wallets`

## Authentication
All endpoints require the `Authorization` header with a valid Bearer token:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

## Endpoints

### 1. Get Wallets (Paginated)
```
GET /api/wallets
```

**Query Parameters:**
- `search` (string, optional) - Search wallets by name, wallet type, or currency
- `filter` (string, optional) - Filter by status: `active`, `inactive`
- `wallet_type_id` (integer, optional) - Filter by wallet type ID
- `currency_id` (integer, optional) - Filter by currency ID
- `per_page` (integer, optional) - Items per page (default: 10, max: 100)
- `page` (integer, optional) - Page number

**Response:**
```json
{
    "success": true,
    "data": {
        "wallets": [
            {
                "id": 1,
                "name": "Main Cash",
                "balance": "1500.50",
                "is_active": true,
                "user_id": 1,
                "wallet_type_id": 1,
                "currency_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z",
                "wallet_type": {
                    "id": 1,
                    "name": "Cash"
                },
                "currency": {
                    "id": 1,
                    "code": "USD",
                    "name": "US Dollar"
                }
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 10,
            "total": 25,
            "last_page": 3,
            "has_more_pages": true
        }
    }
}
```

### 2. Get All Wallets (No Pagination)
```
GET /api/wallets/all
```

**Query Parameters:**
- `active_only` (boolean, optional) - Return only active wallets (default: false)

**Response:**
```json
{
    "success": true,
    "data": {
        "wallets": [
            {
                "id": 1,
                "name": "Main Cash",
                "balance": "1500.50",
                "is_active": true,
                "wallet_type": {
                    "id": 1,
                    "name": "Cash"
                },
                "currency": {
                    "id": 1,
                    "code": "USD",
                    "name": "US Dollar"
                }
            }
        ]
    }
}
```

### 3. Create Wallet
```
POST /api/wallets
```

**Request Body:**
```json
{
    "wallet_type_id": 1,
    "name": "Savings Account",
    "balance": 1000.00,
    "currency_id": 1,
    "is_active": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Wallet created successfully",
    "data": {
        "wallet": {
            "id": 2,
            "name": "Savings Account",
            "balance": "1000.00",
            "is_active": true,
            "user_id": 1,
            "wallet_type_id": 1,
            "currency_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:00:00.000000Z",
            "wallet_type": {
                "id": 1,
                "name": "Bank Account"
            },
            "currency": {
                "id": 1,
                "code": "USD",
                "name": "US Dollar"
            }
        }
    }
}
```

### 4. Get Single Wallet
```
GET /api/wallets/{id}
```

**Query Parameters:**
- `include_transactions` (boolean, optional) - Include paginated transactions (default: false)
- `transactions_per_page` (integer, optional) - Transactions per page when including them (default: 10, max: 50)

**Response:**
```json
{
    "success": true,
    "data": {
        "wallet": {
            "id": 1,
            "name": "Main Cash",
            "balance": "1500.50",
            "is_active": true,
            "wallet_type": {
                "id": 1,
                "name": "Cash"
            },
            "currency": {
                "id": 1,
                "code": "USD",
                "name": "US Dollar"
            }
        }
    }
}
```

### 5. Update Wallet
```
PUT /api/wallets/{id}
```

**Request Body:**
```json
{
    "wallet_type_id": 1,
    "name": "Updated Wallet Name",
    "balance": 2000.00,
    "currency_id": 1,
    "is_active": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Wallet updated successfully",
    "data": {
        "wallet": {
            "id": 1,
            "name": "Updated Wallet Name",
            "balance": "2000.00",
            "is_active": true,
            "wallet_type": {
                "id": 1,
                "name": "Cash"
            },
            "currency": {
                "id": 1,
                "code": "USD",
                "name": "US Dollar"
            }
        }
    }
}
```

### 6. Delete Wallet
```
DELETE /api/wallets/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Wallet deleted successfully"
}
```

**Note:** Wallets with transactions cannot be deleted and will return a 409 Conflict error.

### 7. Transfer Funds Between Wallets
```
POST /api/wallets/transfer
```

**Request Body:**
```json
{
    "from_wallet_id": 1,
    "to_wallet_id": 2,
    "amount": 500.00
}
```

**Response:**
```json
{
    "success": true,
    "message": "Transfer completed successfully",
    "data": {
        "from_wallet": {
            "id": 1,
            "name": "Main Cash",
            "balance": "1000.50"
        },
        "to_wallet": {
            "id": 2,
            "name": "Savings Account",
            "balance": "1500.00"
        },
        "amount": 500.00
    }
}
```

### 8. Get Wallet Statistics
```
GET /api/wallets/stats
```

**Response:**
```json
{
    "success": true,
    "data": {
        "total_wallets": 5,
        "active_wallets": 4,
        "inactive_wallets": 1,
        "total_balance": 15750.50,
        "wallets_with_transactions": 3
    }
}
```

### 9. Get Balance Summary by Currency
```
GET /api/wallets/balance-summary
```

**Response:**
```json
{
    "success": true,
    "data": {
        "balance_summary": [
            {
                "currency": {
                    "id": 1,
                    "code": "USD",
                    "name": "US Dollar"
                },
                "total_balance": 5500.75,
                "wallet_count": 3
            },
            {
                "currency": {
                    "id": 2,
                    "code": "EUR",
                    "name": "Euro"
                },
                "total_balance": 2000.00,
                "wallet_count": 1
            }
        ]
    }
}
```

### 10. Get Wallets by Currency
```
GET /api/wallets/by-currency/{currencyId}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "wallets": [
            {
                "id": 1,
                "name": "Main Cash",
                "balance": "1500.50",
                "wallet_type": {
                    "id": 1,
                    "name": "Cash"
                }
            }
        ]
    }
}
```

### 11. Get Wallet Types
```
GET /api/wallets/wallet-types
```

**Response:**
```json
{
    "success": true,
    "data": {
        "wallet_types": [
            {
                "id": 1,
                "name": "Cash",
                "is_active": true
            },
            {
                "id": 2,
                "name": "Bank Account",
                "is_active": true
            }
        ]
    }
}
```

### 12. Get Currencies
```
GET /api/wallets/currencies
```

**Response:**
```json
{
    "success": true,
    "data": {
        "currencies": [
            {
                "id": 1,
                "code": "USD",
                "name": "US Dollar",
                "symbol": "$"
            },
            {
                "id": 2,
                "code": "EUR",
                "name": "Euro",
                "symbol": "€"
            }
        ]
    }
}
```

## Error Responses

### Validation Error (422)
```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "name": ["The name field is required."],
        "balance": ["The balance must be at least 0."]
    }
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Wallet not found"
}
```

### Unauthorized (401)
```json
{
    "success": false,
    "message": "Unauthenticated"
}
```

### Conflict (409)
```json
{
    "success": false,
    "message": "Cannot delete wallet with existing transactions"
}
```

### Transfer Error (400)
```json
{
    "success": false,
    "message": "Transfer failed",
    "error": "Insufficient balance in source wallet."
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Failed to create wallet",
    "error": "Error details..."
}
```

## Usage Examples

### Using cURL

#### Get all wallets
```bash
curl -X GET http://your-domain.com/api/wallets \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Create a wallet
```bash
curl -X POST http://your-domain.com/api/wallets \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "wallet_type_id": 1,
    "name": "Emergency Fund",
    "balance": 5000.00,
    "currency_id": 1,
    "is_active": true
  }'
```

#### Transfer funds
```bash
curl -X POST http://your-domain.com/api/wallets/transfer \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "from_wallet_id": 1,
    "to_wallet_id": 2,
    "amount": 500.00
  }'
```

#### Get wallet with transactions
```bash
curl -X GET "http://your-domain.com/api/wallets/1?include_transactions=true&transactions_per_page=20" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

### Using JavaScript/Fetch

#### Get wallets with filters
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/wallets?filter=active&wallet_type_id=1&per_page=20', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
});

const data = await response.json();
```

#### Create a wallet
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/wallets', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        wallet_type_id: 1,
        name: 'New Wallet',
        balance: 1000.00,
        currency_id: 1,
        is_active: true
    })
});

const data = await response.json();
```

#### Transfer funds
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/wallets/transfer', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        from_wallet_id: 1,
        to_wallet_id: 2,
        amount: 500.00
    })
});

const data = await response.json();
```

## Security Features

- **User Isolation**: Users can only access their own wallets
- **Token Authentication**: All endpoints require valid Sanctum tokens
- **Input Validation**: All inputs are validated and sanitized
- **Error Handling**: Comprehensive error handling with appropriate HTTP status codes
- **Rate Limiting**: Laravel's built-in rate limiting applies
- **SQL Injection Protection**: Uses Eloquent ORM for database queries
- **Transfer Validation**: Comprehensive validation for fund transfers
- **Balance Checks**: Prevents overdrafts and negative balances

## Business Rules

- Wallet names must be unique per user and wallet type combination
- Wallets with transactions cannot be deleted
- Transfer source and destination wallets must be different
- Both wallets involved in transfers must be active
- Transfer amount must be positive and available in source wallet
- All monetary values are stored with 2 decimal precision
- Soft deletes are used for wallet records

## Notes

- All monetary amounts are returned as strings to preserve precision
- All timestamps are in UTC format
- Maximum 100 items per page for paginated endpoints
- Maximum 50 transactions per page when including transactions
- Search is case-insensitive and matches wallet names, types, and currencies
- Balance summary groups wallets by currency for easy overview
- Transfer operations are atomic (all-or-nothing) using database transactions
