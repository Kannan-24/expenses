# Transaction API Documentation

This document provides comprehensive information about the Transaction API endpoints, including authentication, request/response formats, and examples.

## Base URL
```
/api/transactions
```

## Authentication
All endpoints require Bearer token authentication using Laravel Sanctum.

```
Authorization: Bearer {your_api_token}
```

## Endpoints Overview

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/` | Get paginated transactions with filters |
| GET | `/all` | Get all transactions (no pagination) |
| POST | `/` | Create a new transaction |
| GET | `/{id}` | Get specific transaction |
| PUT | `/{id}` | Update transaction |
| DELETE | `/{id}` | Delete transaction |
| GET | `/stats` | Get transaction statistics |
| GET | `/by-category` | Get transactions grouped by category |
| GET | `/monthly-summary` | Get monthly transaction summary |
| GET | `/form-data` | Get form data for dropdowns |
| POST | `/upload-attachment` | Upload attachment file (with optional transaction_id) |
| POST | `/save-camera-image` | Save camera image (with optional transaction_id) |
| DELETE | `/delete-attachment` | Delete attachment |
| POST | `/{id}/add-attachment` | Add attachment to existing transaction |
| POST | `/{id}/add-camera-image` | Add camera image to existing transaction |
| DELETE | `/{id}/remove-attachment` | Remove attachment from existing transaction |
| GET | `/{id}/attachment/{index}` | Download/view attachment |

---

## Detailed Endpoints

### 1. Get Paginated Transactions
**GET** `/api/transactions`

Returns paginated list of transactions with optional filters.

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `page` | integer | No | Page number (default: 1) |
| `per_page` | integer | No | Items per page (default: 15, max: 100) |
| `search` | string | No | Search in person name, category name, or note |
| `filter` | string | No | Date filter: `7days`, `15days`, `1month` |
| `start_date` | date | No | Start date for custom range (YYYY-MM-DD) |
| `end_date` | date | No | End date for custom range (YYYY-MM-DD) |
| `category` | integer | No | Filter by category ID |
| `person` | integer | No | Filter by expense person ID |
| `type` | string | No | Filter by type: `income` or `expense` |
| `wallet` | integer | No | Filter by wallet ID |

#### Example Request
```bash
curl -X GET "http://localhost:8000/api/transactions?page=1&per_page=20&type=expense&filter=1month" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "transactions": [
      {
        "id": 1,
        "user_id": 1,
        "category_id": 2,
        "expense_person_id": 1,
        "wallet_id": 1,
        "amount": "150.00",
        "date": "2024-01-15",
        "note": "Grocery shopping",
        "type": "expense",
        "attachments": [
          {
            "path": "attachments/receipt.jpg",
            "original_name": "receipt.jpg",
            "mime_type": "image/jpeg",
            "size": 245760
          }
        ],
        "created_at": "2024-01-15T10:30:00.000000Z",
        "updated_at": "2024-01-15T10:30:00.000000Z",
        "category": {
          "id": 2,
          "name": "Food & Dining",
          "description": "Food and restaurant expenses"
        },
        "person": {
          "id": 1,
          "name": "John Doe",
          "email": "john@example.com"
        },
        "wallet": {
          "id": 1,
          "name": "Cash Wallet",
          "balance": "1500.00"
        }
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 20,
      "total": 95,
      "from": 1,
      "to": 20
    }
  },
  "message": "Transactions retrieved successfully"
}
```

---

### 2. Get All Transactions
**GET** `/api/transactions/all`

Returns all transactions without pagination (use with caution for large datasets).

#### Query Parameters
Same as paginated endpoint except `page` and `per_page`.

#### Example Request
```bash
curl -X GET "http://localhost:8000/api/transactions/all?type=income" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 3. Create Transaction
**POST** `/api/transactions`

Creates a new income or expense transaction.

#### Request Body
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `type` | string | Yes | `income` or `expense` |
| `amount` | number | Yes | Transaction amount (min: 0) |
| `date` | date | Yes | Transaction date (YYYY-MM-DD) |
| `wallet_id` | integer | Yes | ID of the wallet |
| `category_id` | integer | No | ID of the category |
| `expense_person_id` | integer | No | ID of the expense person |
| `note` | string | No | Transaction note (max: 1000 chars) |
| `attachments[]` | file[] | No | Attachment files (jpg,png,gif,webp,pdf, max: 5MB each) |
| `camera_image` | string | No | Base64 encoded camera image |
| `camera_images[]` | string[] | No | Array of base64 encoded camera images |

#### Example Request
```bash
curl -X POST "http://localhost:8000/api/transactions" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "expense",
    "amount": 75.50,
    "date": "2024-01-20",
    "wallet_id": 1,
    "category_id": 3,
    "expense_person_id": 2,
    "note": "Coffee with client"
  }'
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 123,
    "user_id": 1,
    "category_id": 3,
    "expense_person_id": 2,
    "wallet_id": 1,
    "amount": "75.50",
    "date": "2024-01-20",
    "note": "Coffee with client",
    "type": "expense",
    "attachments": [],
    "created_at": "2024-01-20T15:45:00.000000Z",
    "updated_at": "2024-01-20T15:45:00.000000Z",
    "category": {
      "id": 3,
      "name": "Business"
    },
    "person": {
      "id": 2,
      "name": "Jane Smith"
    },
    "wallet": {
      "id": 1,
      "name": "Cash Wallet",
      "balance": "1424.50"
    }
  },
  "message": "Expense created successfully"
}
```

---

### 4. Get Specific Transaction
**GET** `/api/transactions/{id}`

Retrieves details of a specific transaction.

#### Example Request
```bash
curl -X GET "http://localhost:8000/api/transactions/123" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

---

### 5. Update Transaction
**PUT** `/api/transactions/{id}`

Updates an existing transaction.

#### Request Body
Same fields as create transaction, plus:
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `removed_attachments[]` | string[] | No | Array of attachment paths to remove |

#### Example Request
```bash
curl -X PUT "http://localhost:8000/api/transactions/123" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "expense",
    "amount": 85.00,
    "date": "2024-01-20",
    "wallet_id": 1,
    "category_id": 3,
    "note": "Updated: Coffee and lunch with client"
  }'
```

---

### 6. Delete Transaction
**DELETE** `/api/transactions/{id}`

Deletes a transaction and reverts wallet balance.

#### Example Request
```bash
curl -X DELETE "http://localhost:8000/api/transactions/123" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Example Response
```json
{
  "success": true,
  "message": "Expense deleted successfully"
}
```

---

### 7. Get Transaction Statistics
**GET** `/api/transactions/stats`

Returns statistical information about transactions.

#### Query Parameters
Same filtering options as the main transaction list.

#### Example Request
```bash
curl -X GET "http://localhost:8000/api/transactions/stats?filter=1month" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "total_income": "2500.00",
    "total_expense": "1850.75",
    "balance": "649.25",
    "transaction_count": 48
  },
  "message": "Transaction statistics retrieved successfully"
}
```

---

### 8. Get Transactions by Category
**GET** `/api/transactions/by-category`

Returns transactions grouped by category.

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "category_id": 1,
      "type": "expense",
      "total_amount": "450.00",
      "transaction_count": 5,
      "category": {
        "id": 1,
        "name": "Food & Dining"
      }
    }
  ],
  "message": "Transactions by category retrieved successfully"
}
```

---

### 9. Get Monthly Summary
**GET** `/api/transactions/monthly-summary`

Returns monthly breakdown of transactions for a specific year.

#### Query Parameters
| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `year` | integer | Yes | Year for the summary (2000-2034) |

#### Example Request
```bash
curl -X GET "http://localhost:8000/api/transactions/monthly-summary?year=2024" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "month": 1,
      "type": "income",
      "total_amount": "5000.00",
      "transaction_count": 2
    },
    {
      "month": 1,
      "type": "expense",
      "total_amount": "3200.50",
      "transaction_count": 25
    }
  ],
  "message": "Monthly transaction summary retrieved successfully"
}
```

---

### 10. Get Form Data
**GET** `/api/transactions/form-data`

Returns data needed for transaction forms (categories, people, wallets, etc.).

#### Example Response
```json
{
  "success": true,
  "data": {
    "categories": [
      {
        "id": 1,
        "name": "Food & Dining",
        "description": "Food and restaurant expenses"
      }
    ],
    "people": [
      {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      }
    ],
    "wallets": [
      {
        "id": 1,
        "name": "Cash Wallet",
        "balance": "1500.00"
      }
    ],
    "walletTypes": [
      {
        "id": 1,
        "name": "Cash"
      }
    ],
    "currencies": [
      {
        "id": 1,
        "code": "USD",
        "name": "US Dollar"
      }
    ]
  },
  "message": "Form data retrieved successfully"
}
```

---

### 13. Add Attachment to Existing Transaction
**POST** `/api/transactions/{id}/add-attachment`

Adds a new attachment to an existing transaction.

#### Request Body (multipart/form-data)
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `file` | file | Yes | File to upload (jpg,png,gif,webp,pdf, max: 5MB) |

#### Example Request
```bash
curl -X POST "http://localhost:8000/api/transactions/123/add-attachment" \
  -H "Authorization: Bearer {token}" \
  -F "file=@additional_receipt.jpg"
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "attachment": {
      "path": "attachments/1/document_20240120_154500.jpg",
      "original_name": "additional_receipt.jpg",
      "mime_type": "image/jpeg",
      "size": 245760
    },
    "transaction": {
      "id": 123,
      "attachments": [
        {
          "path": "attachments/1/original_receipt.jpg",
          "original_name": "original_receipt.jpg",
          "mime_type": "image/jpeg",
          "size": 180000
        },
        {
          "path": "attachments/1/document_20240120_154500.jpg",
          "original_name": "additional_receipt.jpg",
          "mime_type": "image/jpeg",
          "size": 245760
        }
      ]
    }
  },
  "message": "Attachment added to transaction successfully"
}
```

---

### 14. Add Camera Image to Existing Transaction
**POST** `/api/transactions/{id}/add-camera-image`

Adds a new camera image to an existing transaction.

#### Request Body
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `image` | string | Yes | Base64 encoded image data |

#### Example Request
```bash
curl -X POST "http://localhost:8000/api/transactions/123/add-camera-image" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"image": "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQ..."}'
```

---

### 15. Remove Attachment from Transaction
**DELETE** `/api/transactions/{id}/remove-attachment`

Removes an attachment from an existing transaction and deletes the file.

#### Request Body
| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `attachment_path` | string | Yes | Path of the attachment to remove |

#### Example Request
```bash
curl -X DELETE "http://localhost:8000/api/transactions/123/remove-attachment" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"attachment_path": "attachments/1/old_receipt.jpg"}'
```

---

### 17. Download/View Attachment
**GET** `/api/transactions/{id}/attachment/{index}`

Downloads or displays an attachment file.

#### Parameters
- `id`: Transaction ID
- `index`: Attachment index (0-based)

Returns the actual file with appropriate headers for viewing or downloading.

---

## Error Responses

All endpoints may return error responses in the following format:

```json
{
  "success": false,
  "message": "Error description",
  "error": "Detailed error message"
}
```

### Common HTTP Status Codes
- `200`: Success
- `201`: Created successfully
- `400`: Bad request (validation errors)
- `401`: Unauthorized (invalid or missing token)
- `403`: Forbidden (insufficient permissions)
- `404`: Not found
- `422`: Validation errors
- `500`: Internal server error

### Validation Error Example
```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "amount": ["The amount field is required."],
    "wallet_id": ["The selected wallet id is invalid."]
  }
}
```

---

## Rate Limiting

API requests are subject to rate limiting. Default limits:
- 60 requests per minute for authenticated users

Rate limit headers are included in responses:
```
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1642680000
```

---

## Security Considerations

1. **Authentication**: Always include valid Bearer token
2. **Input Validation**: All inputs are validated on the server
3. **File Security**: Uploaded files are scanned and restricted by type/size
4. **User Isolation**: Users can only access their own transactions
5. **HTTPS**: Use HTTPS in production for secure data transmission

---

## Examples

### Create Transaction with Attachments During Creation
```bash
curl -X POST "http://localhost:8000/api/transactions" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -F "type=expense" \
  -F "amount=125.00" \
  -F "date=2024-01-20" \
  -F "wallet_id=1" \
  -F "category_id=2" \
  -F "note=Restaurant bill" \
  -F "attachments[]=@receipt.jpg"
```

### Upload File with Transaction ID Association
```bash
curl -X POST "http://localhost:8000/api/transactions/upload-attachment" \
  -H "Authorization: Bearer {token}" \
  -F "file=@receipt.jpg" \
  -F "transaction_id=123"
```

### Add Attachment to Existing Transaction
```bash
curl -X POST "http://localhost:8000/api/transactions/123/add-attachment" \
  -H "Authorization: Bearer {token}" \
  -F "file=@additional_receipt.jpg"
```

### Remove Attachment from Transaction
```bash
curl -X DELETE "http://localhost:8000/api/transactions/123/remove-attachment" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"attachment_path": "attachments/1/old_receipt.jpg"}'
```

### Get Transactions for Current Month
```bash
curl -X GET "http://localhost:8000/api/transactions?filter=1month&type=expense" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Update Transaction and Remove Attachment
```bash
curl -X PUT "http://localhost:8000/api/transactions/123" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "expense",
    "amount": 100.00,
    "date": "2024-01-20",
    "wallet_id": 1,
    "removed_attachments": ["attachments/1/old_receipt.jpg"]
  }'
```

### Workflow: Create Transaction, then Add Multiple Attachments
```bash
# 1. Create transaction
TRANSACTION_ID=$(curl -X POST "http://localhost:8000/api/transactions" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "expense",
    "amount": 75.00,
    "date": "2024-01-20",
    "wallet_id": 1,
    "category_id": 2,
    "note": "Business lunch"
  }' | jq -r '.data.id')

# 2. Add receipt image
curl -X POST "http://localhost:8000/api/transactions/${TRANSACTION_ID}/add-attachment" \
  -H "Authorization: Bearer {token}" \
  -F "file=@receipt.jpg"

# 3. Add business card photo
curl -X POST "http://localhost:8000/api/transactions/${TRANSACTION_ID}/add-camera-image" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"image": "data:image/jpeg;base64,/9j/4AAQ..."}'
```
