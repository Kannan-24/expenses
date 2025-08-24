# Category API Documentation

## Overview
The Category API allows authenticated users to manage their expense categories. All endpoints require authentication via Bearer token.

## Base URL
All category endpoints are prefixed with `/api/categories`

## Authentication
All endpoints require the `Authorization` header with a valid Bearer token:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

## Endpoints

### 1. Get Categories (Paginated)
```
GET /api/categories
```

**Query Parameters:**
- `search` (string, optional) - Search categories by name
- `per_page` (integer, optional) - Items per page (default: 10, max: 100)
- `page` (integer, optional) - Page number

**Response:**
```json
{
    "success": true,
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Food",
                "user_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
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

### 2. Get All Categories (No Pagination)
```
GET /api/categories/all
```

**Response:**
```json
{
    "success": true,
    "data": {
        "categories": [
            {
                "id": 1,
                "name": "Food",
                "user_id": 1,
                "created_at": "2025-08-24T10:00:00.000000Z",
                "updated_at": "2025-08-24T10:00:00.000000Z"
            }
        ]
    }
}
```

### 3. Create Category
```
POST /api/categories
```

**Request Body:**
```json
{
    "name": "Transportation"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Category created successfully",
    "data": {
        "category": {
            "id": 2,
            "name": "Transportation",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:00:00.000000Z"
        }
    }
}
```

### 4. Get Single Category
```
GET /api/categories/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "category": {
            "id": 1,
            "name": "Food",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:00:00.000000Z"
        }
    }
}
```

### 5. Update Category
```
PUT /api/categories/{id}
```

**Request Body:**
```json
{
    "name": "Groceries"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Category updated successfully",
    "data": {
        "category": {
            "id": 1,
            "name": "Groceries",
            "user_id": 1,
            "created_at": "2025-08-24T10:00:00.000000Z",
            "updated_at": "2025-08-24T10:30:00.000000Z"
        }
    }
}
```

### 6. Delete Category
```
DELETE /api/categories/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Category deleted successfully"
}
```

**Note:** Categories with associated expenses cannot be deleted and will return a 409 Conflict error.

### 7. Get Category Statistics
```
GET /api/categories/stats
```

**Response:**
```json
{
    "success": true,
    "data": {
        "total_categories": 10,
        "categories_with_expenses": 8
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
    "message": "Category not found"
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
    "message": "Cannot delete category that has associated expenses"
}
```

### Server Error (500)
```json
{
    "success": false,
    "message": "Failed to create category",
    "error": "Error details..."
}
```

## Usage Examples

### Using cURL

#### Get all categories
```bash
curl -X GET http://your-domain.com/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

#### Create a category
```bash
curl -X POST http://your-domain.com/api/categories \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"name": "Entertainment"}'
```

#### Update a category
```bash
curl -X PUT http://your-domain.com/api/categories/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"name": "Updated Name"}'
```

#### Delete a category
```bash
curl -X DELETE http://your-domain.com/api/categories/1 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Using JavaScript/Fetch

#### Get categories with search
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/categories?search=food&per_page=5', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
});

const data = await response.json();
```

#### Create a category
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/categories', {
    method: 'POST',
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        name: 'New Category'
    })
});

const data = await response.json();
```

## Security Features

- **User Isolation**: Users can only access their own categories
- **Token Authentication**: All endpoints require valid Sanctum tokens
- **Input Validation**: All inputs are validated and sanitized
- **Error Handling**: Comprehensive error handling with appropriate HTTP status codes
- **Rate Limiting**: Laravel's built-in rate limiting applies
- **SQL Injection Protection**: Uses Eloquent ORM for database queries

## Notes

- Category names must be unique per user
- Categories with expenses cannot be deleted
- All timestamps are in UTC format
- Maximum 100 items per page for paginated endpoints
- Search is case-insensitive and matches partial names
