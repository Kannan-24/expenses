# Expense People API Documentation

## Overview
The Expense People API allows authenticated users to manage the people associated with their expenses. All endpoints require authentication via Bearer token.

## Base URL
All expense people endpoints are prefixed with `/api/expense-people`

## Authentication
All endpoints require the `Authorization` header with a valid Bearer token:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

## Endpoints

### 1. Get Expense People (Paginated)
```
GET /api/expense-people
```

**Query Parameters:**
- `search` (string, optional) - Search expense people by name
- `per_page` (integer, optional) - Items per page (default: 12, max: 100)
- `page` (integer, optional) - Page number

**Response:**
```json
{
    "success": true,
    "data": {
        "expense_people": [
            {
                "id": 1,
                "name": "John Doe",
                "user_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 12,
            "total": 25,
            "last_page": 3,
            "has_more_pages": true
        }
    }
}
```

### 2. Get All Expense People (No Pagination)
```
GET /api/expense-people/all
```

**Response:**
```json
{
    "success": true,
    "data": {
        "expense_people": [
            {
                "id": 1,
                "name": "John Doe",
                "user_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
            }
        ]
    }
}
```

### 3. Create Expense Person
```
POST /api/expense-people
```

**Request Body:**
```json
{
    "name": "Jane Smith"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Expense person created successfully",
    "data": {
        "expense_person": {
            "id": 2,
            "name": "Jane Smith",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:00:00.000000Z"
        }
    }
}
```

### 4. Get Single Expense Person
```
GET /api/expense-people/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "expense_person": {
            "id": 1,
            "name": "John Doe",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:00:00.000000Z"
        }
    }
}
```

### 5. Update Expense Person
```
PUT /api/expense-people/{id}
```

**Request Body:**
```json
{
    "name": "John Smith"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Expense person updated successfully",
    "data": {
        "expense_person": {
            "id": 1,
            "name": "John Smith",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:30:00.000000Z"
        }
    }
}
```

### 6. Delete Expense Person
```
DELETE /api/expense-people/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Expense person deleted successfully"
}
```

**Note:** Expense people with associated transactions cannot be deleted and will return a 409 Conflict error.

### 7. Search Expense People
```
GET /api/expense-people/search
```

**Query Parameters:**
- `query` (string, required) - Search term
- `limit` (integer, optional) - Maximum results (default: 10, max: 50)

**Response:**
```json
{
    "success": true,
    "data": {
        "expense_people": [
            {
                "id": 1,
                "name": "John Doe",
                "user_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
            }
        ]
    }
}
```

### 8. Get Expense People Statistics
```
GET /api/expense-people/stats
```

**Response:**
```json
{
    "success": true,
    "data": {
        "total_expense_people": 15,
        "expense_people_with_transactions": 12
    }
}
```

### 9. Get Expense People with Transaction Counts
```
GET /api/expense-people/with-transaction-counts
```

**Response:**
```json
{
    "success": true,
    "data": {
        "expense_people": [
            {
                "id": 1,
                "name": "John Doe",
                "user_id": 1,
                "transactions_count": 5,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
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
        "name": ["The name field is required."]
    }
}
```

### Not Found (404)
```json
{
    "success": false,
    "message": "Expense person not found"
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
    "message": "Cannot delete expense person that has associated transactions"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Failed to create expense person",
    "error": "Error details..."
}
```

## Usage Examples

### Using cURL

#### Get all expense people
```bash
curl -X GET http://your-domain.com/api/expense-people \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Create an expense person
```bash
curl -X POST http://your-domain.com/api/expense-people \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"name": "Alice Johnson"}'
```

#### Search expense people
```bash
curl -X GET "http://your-domain.com/api/expense-people/search?query=john&limit=5" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Update an expense person
```bash
curl -X PUT http://your-domain.com/api/expense-people/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"name": "Updated Name"}'
```

#### Delete an expense person
```bash
curl -X DELETE http://your-domain.com/api/expense-people/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using JavaScript/Fetch

#### Get expense people with search
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/expense-people?search=john&per_page=10', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
});

const data = await response.json();
```

#### Create an expense person
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/expense-people', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        name: 'New Person'
    })
});

const data = await response.json();
```

#### Search expense people
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/expense-people/search?query=alice&limit=10', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
});

const data = await response.json();
```

## Security Features

- **User Isolation**: Users can only access their own expense people
- **Token Authentication**: All endpoints require valid Sanctum tokens
- **Input Validation**: All inputs are validated and sanitized
- **Error Handling**: Comprehensive error handling with appropriate HTTP status codes
- **Rate Limiting**: Laravel's built-in rate limiting applies
- **SQL Injection Protection**: Uses Eloquent ORM for database queries
- **Unique Name Validation**: Prevents duplicate names per user

## Notes

- Expense person names must be unique per user
- Expense people with transactions cannot be deleted
- All timestamps are in UTC format
- Maximum 100 items per page for paginated endpoints
- Search is case-insensitive and matches partial names
- Maximum 50 results for search queries
- Transaction counts are available via the dedicated endpoint
