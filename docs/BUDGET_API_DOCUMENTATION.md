# Budget API Documentation

## Overview
The Budget API provides comprehensive budget management functionality with service layer separation, following the same patterns as the Transaction API.

## Authentication
All Budget API endpoints require authentication using Laravel Sanctum tokens:
```
Authorization: Bearer {your-token}
```

## Base URL
```
/api/budgets
```

## Endpoints

### 1. Get All Budgets
**GET** `/api/budgets`

**Query Parameters:**
- `search` - Search in budget descriptions
- `category_id` - Filter by category ID
- `start_date` - Filter budgets starting from date (YYYY-MM-DD)
- `end_date` - Filter budgets ending before date (YYYY-MM-DD)
- `frequency` - Filter by frequency (daily, weekly, monthly, yearly)
- `status` - Filter by status (active, inactive, expired)
- `sort_by` - Sort field (amount, start_date, end_date, created_at)
- `sort_order` - Sort order (asc, desc)
- `per_page` - Items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "data": {
        "data": [...],
        "current_page": 1,
        "total": 50,
        "per_page": 15
    },
    "message": "Budgets retrieved successfully"
}
```

### 2. Create Budget
**POST** `/api/budgets`

**Request Body:**
```json
{
    "category_id": 1,
    "amount": 1500.00,
    "start_date": "2024-01-01",
    "end_date": "2024-01-31",
    "roll_over": true,
    "frequency": "monthly"
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "category_id": 1,
        "amount": 1500.00,
        "start_date": "2024-01-01",
        "end_date": "2024-01-31",
        "roll_over": true,
        "frequency": "monthly",
        "created_at": "2024-01-01T00:00:00.000000Z"
    },
    "message": "Budget created successfully"
}
```

### 3. Get Budget Details
**GET** `/api/budgets/{id}`

**Query Parameters:**
- `per_page` - Items per page for histories (default: 10)

**Response:**
```json
{
    "success": true,
    "data": {
        "budget": {...},
        "histories": {
            "data": [...],
            "current_page": 1,
            "total": 25
        }
    },
    "message": "Budget retrieved successfully"
}
```

### 4. Update Budget
**PUT** `/api/budgets/{id}`

**Request Body:**
```json
{
    "category_id": 1,
    "amount": 1800.00,
    "start_date": "2024-01-01",
    "end_date": "2024-01-31",
    "roll_over": false,
    "frequency": "monthly"
}
```

### 5. Delete Budget
**DELETE** `/api/budgets/{id}`

**Response:**
```json
{
    "success": true,
    "message": "Budget deleted successfully"
}
```

### 6. Get Categories
**GET** `/api/budgets/categories`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Food & Dining",
            "user_id": 1
        }
    ],
    "message": "Categories retrieved successfully"
}
```

### 7. Get Budget Statistics
**GET** `/api/budgets/stats`

**Query Parameters:**
- `start_date` - Statistics start date
- `end_date` - Statistics end date
- `category_id` - Filter by category

**Response:**
```json
{
    "success": true,
    "data": {
        "total_budgets": 5,
        "total_budgeted_amount": 7500.00,
        "total_spent": 6200.00,
        "remaining_amount": 1300.00,
        "average_utilization": 82.67,
        "categories_count": 3
    },
    "message": "Budget statistics retrieved successfully"
}
```

### 8. Get Budget Performance by Category
**GET** `/api/budgets/performance-by-category`

**Query Parameters:**
- `start_date` - Analysis start date
- `end_date` - Analysis end date

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "category_id": 1,
            "category_name": "Food & Dining",
            "total_budgeted": 1500.00,
            "total_spent": 1200.00,
            "utilization_percentage": 80.00,
            "remaining": 300.00,
            "budget_count": 1
        }
    ],
    "message": "Budget performance retrieved successfully"
}
```

### 9. Get Budget Trends
**GET** `/api/budgets/trends`

**Query Parameters:**
- `period` - Time period (monthly, yearly)
- `category_id` - Filter by category

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "period": "2024-01",
            "total_budgeted": 5000.00,
            "total_spent": 4200.00,
            "budget_count": 3,
            "categories": {
                "Food & Dining": {
                    "budgeted": 1500.00,
                    "spent": 1200.00
                }
            }
        }
    ],
    "message": "Budget trends retrieved successfully"
}
```

### 10. Get Active Budgets
**GET** `/api/budgets/active`

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "amount": 1500.00,
            "start_date": "2024-01-01",
            "end_date": "2024-01-31",
            "category": {
                "id": 1,
                "name": "Food & Dining"
            }
        }
    ],
    "message": "Active budgets retrieved successfully"
}
```

### 11. Check Budget Overlaps
**POST** `/api/budgets/check-overlaps`

**Request Body:**
```json
{
    "category_id": 1,
    "start_date": "2024-01-01",
    "end_date": "2024-01-31",
    "budget_id": 2
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "has_overlaps": false,
        "overlapping_budgets": []
    },
    "message": "Budget overlap check completed"
}
```

### 12. Bulk Delete Budgets
**POST** `/api/budgets/bulk-delete`

**Request Body:**
```json
{
    "budget_ids": [1, 2, 3]
}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "deleted_count": 3
    },
    "message": "Successfully deleted 3 budget(s)"
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
- `422` - Validation errors
- `500` - Server error

## Features

### Security & Authorization
- All endpoints require valid Sanctum token
- User isolation - users can only access their own budgets
- Proper ownership validation for all operations
- Input validation for all requests

### Advanced Filtering
- Search functionality across budget data
- Date range filtering
- Category filtering
- Status filtering (active, inactive, expired)
- Frequency filtering
- Sorting by multiple fields

### Business Logic
- Automatic budget overlap detection
- Validation of category ownership
- Safe deletion with history cleanup
- Database transactions for data integrity
- Comprehensive error handling

### Performance Features
- Efficient pagination for large datasets
- Optimized queries with proper eager loading
- Indexed database operations
- Minimal API response payloads

## Service Layer Architecture

The Budget API is built using a service layer pattern that separates business logic from controller logic:

- **BudgetController** - Handles HTTP requests/responses and validation
- **BudgetService** - Contains all business logic and database operations
- **Models** - Budget, BudgetHistory, Category models with relationships

This architecture provides:
- Better testability
- Code reusability
- Separation of concerns
- Easier maintenance
- Consistent error handling
