# EMI Loans API Documentation

## Overview

The EMI Loans API provides comprehensive functionality for managing Equated Monthly Installment (EMI) loans with automatic schedule generation, payment tracking, and financial calculations. This API supports both fixed and reducing balance loan types with sophisticated EMI calculations.

## Base URL
```
/api/emi-loans
```

## Authentication

All endpoints require authentication using Laravel Sanctum tokens.

**Header Required:**
```
Authorization: Bearer {token}
```

## Table of Contents

1. [Core CRUD Operations](#core-crud-operations)
2. [Helper Endpoints](#helper-endpoints)
3. [Schedule Management](#schedule-management)
4. [Statistics & Analytics](#statistics--analytics)
5. [Data Models](#data-models)
6. [Error Responses](#error-responses)

---

## Core CRUD Operations

### 1. List EMI Loans

**GET** `/api/emi-loans`

Retrieve a paginated list of EMI loans with comprehensive filtering options.

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `search` | string | No | Search in loan name or category name |
| `category_id` | integer | No | Filter by category ID |
| `status` | string | No | Filter by status (`active`, `closed`, `cancelled`) |
| `loan_type` | string | No | Filter by loan type (`fixed`, `reducing_balance`) |
| `start_date` | date | No | Filter loans starting from this date (YYYY-MM-DD) |
| `end_date` | date | No | Filter loans starting until this date (YYYY-MM-DD) |
| `min_amount` | number | No | Minimum total loan amount |
| `max_amount` | number | No | Maximum total loan amount |
| `is_auto_deduct` | boolean | No | Filter by auto deduction setting |
| `sort_by` | string | No | Sort field (default: `created_at`) |
| `sort_order` | string | No | Sort order (`asc`, `desc`, default: `desc`) |
| `per_page` | integer | No | Items per page (default: 15) |

#### Example Request
```bash
GET /api/emi-loans?search=home&status=active&loan_type=reducing_balance&per_page=10
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Home Loan",
        "total_amount": 500000.00,
        "interest_rate": 8.50,
        "start_date": "2024-01-01",
        "tenure_months": 240,
        "monthly_emi": 4321.50,
        "loan_type": "reducing_balance",
        "status": "active",
        "is_auto_deduct": true,
        "default_wallet_id": 2,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "category": {
          "id": 5,
          "name": "Housing",
          "color": "#FF5722"
        },
        "emi_schedules": [
          {
            "id": 1,
            "due_date": "2024-02-01",
            "principal_amount": 2654.83,
            "interest_amount": 1666.67,
            "total_amount": 4321.50,
            "status": "paid",
            "paid_date": "2024-02-01",
            "paid_amount": 4321.50
          }
        ]
      }
    ],
    "per_page": 10,
    "total": 1
  },
  "message": "EMI loans retrieved successfully"
}
```

---

### 2. Create EMI Loan

**POST** `/api/emi-loans`

Create a new EMI loan with automatic schedule generation.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | Yes | Loan name (max: 255 chars) |
| `total_amount` | number | Yes | Total loan amount (min: 0) |
| `interest_rate` | number | Yes | Annual interest rate percentage (0-100) |
| `start_date` | date | Yes | Loan start date (YYYY-MM-DD) |
| `tenure_months` | integer | Yes | Loan tenure in months (min: 1) |
| `category_id` | integer | No | Category ID for categorization |
| `monthly_emi` | number | No | Custom EMI amount (auto-calculated if not provided) |
| `is_auto_deduct` | boolean | No | Enable auto deduction (default: false) |
| `loan_type` | string | No | Loan type (`fixed`, `reducing_balance`, default: `fixed`) |
| `status` | string | No | Initial status (default: `active`) |
| `default_wallet_id` | integer | No | Default wallet for payments |

#### Example Request
```json
{
  "name": "Car Loan",
  "total_amount": 250000.00,
  "interest_rate": 9.5,
  "start_date": "2024-03-01",
  "tenure_months": 60,
  "category_id": 3,
  "loan_type": "reducing_balance",
  "is_auto_deduct": true,
  "default_wallet_id": 1
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 2,
    "name": "Car Loan",
    "total_amount": 250000.00,
    "interest_rate": 9.50,
    "start_date": "2024-03-01",
    "tenure_months": 60,
    "monthly_emi": 5247.50,
    "loan_type": "reducing_balance",
    "status": "active",
    "is_auto_deduct": true,
    "default_wallet_id": 1,
    "category": {
      "id": 3,
      "name": "Transportation"
    },
    "emi_schedules": []
  },
  "message": "EMI loan created successfully"
}
```

---

### 3. Get EMI Loan Details

**GET** `/api/emi-loans/{id}`

Retrieve detailed information about a specific EMI loan including paginated schedules.

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `per_page` | integer | No | Schedules per page (default: 10) |

#### Example Request
```bash
GET /api/emi-loans/1?per_page=5
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "emi_loan": {
      "id": 1,
      "name": "Home Loan",
      "total_amount": 500000.00,
      "interest_rate": 8.50,
      "start_date": "2024-01-01",
      "tenure_months": 240,
      "monthly_emi": 4321.50,
      "loan_type": "reducing_balance",
      "status": "active",
      "category": {
        "id": 5,
        "name": "Housing"
      }
    },
    "schedules": {
      "current_page": 1,
      "data": [
        {
          "id": 1,
          "due_date": "2024-02-01",
          "principal_amount": 2654.83,
          "interest_amount": 1666.67,
          "total_amount": 4321.50,
          "status": "paid",
          "paid_date": "2024-02-01",
          "paid_amount": 4321.50,
          "wallet": {
            "id": 2,
            "name": "SBI Account",
            "currency": {
              "code": "INR",
              "symbol": "₹"
            }
          }
        }
      ],
      "per_page": 5,
      "total": 240
    }
  },
  "message": "EMI loan retrieved successfully"
}
```

---

### 4. Update EMI Loan

**PUT** `/api/emi-loans/{id}`

Update an existing EMI loan. This will regenerate all schedules.

#### Request Body
Same as create EMI loan request body.

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Updated Home Loan",
    "total_amount": 550000.00,
    "interest_rate": 8.75,
    "monthly_emi": 4756.25,
    "category": {
      "id": 5,
      "name": "Housing"
    }
  },
  "message": "EMI loan updated successfully"
}
```

---

### 5. Delete EMI Loan

**DELETE** `/api/emi-loans/{id}`

Delete an EMI loan and all associated schedules.

#### Example Response
```json
{
  "success": true,
  "message": "EMI loan deleted successfully"
}
```

---

## Helper Endpoints

### 1. Get Categories

**GET** `/api/emi-loans/categories`

Retrieve user's categories for EMI loan categorization.

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Housing",
      "color": "#FF5722"
    },
    {
      "id": 2,
      "name": "Transportation",
      "color": "#2196F3"
    }
  ],
  "message": "Categories retrieved successfully"
}
```

---

### 2. Get Wallets

**GET** `/api/emi-loans/wallets`

Retrieve user's active wallets for EMI payments.

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "SBI Checking",
      "balance": 50000.00,
      "currency_id": 1
    },
    {
      "id": 2,
      "name": "HDFC Savings",
      "balance": 75000.00,
      "currency_id": 1
    }
  ],
  "message": "Wallets retrieved successfully"
}
```

---

### 3. Get Upcoming Schedules

**GET** `/api/emi-loans/upcoming-schedules`

Retrieve upcoming EMI payments for notifications.

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `notification_days` | integer | No | Days ahead to check (default: 3) |

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "id": 25,
      "due_date": "2024-03-01",
      "total_amount": 4321.50,
      "status": "upcoming",
      "emi_loan": {
        "id": 1,
        "name": "Home Loan"
      },
      "wallet": {
        "id": 2,
        "name": "SBI Account",
        "currency": {
          "code": "INR",
          "symbol": "₹"
        }
      }
    }
  ],
  "message": "Upcoming schedules retrieved successfully"
}
```

---

## Schedule Management

### 1. Mark Schedule as Paid

**POST** `/api/emi-loans/{loanId}/schedules/{scheduleId}/mark-paid`

Record a payment for an EMI schedule.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `wallet_id` | integer | Yes | Wallet ID for payment |
| `paid_amount` | number | Yes | Amount paid (min: 0) |
| `paid_date` | date | Yes | Payment date (YYYY-MM-DD) |
| `notes` | string | No | Payment notes (max: 500 chars) |

#### Example Request
```json
{
  "wallet_id": 2,
  "paid_amount": 4321.50,
  "paid_date": "2024-03-01",
  "notes": "Paid via online banking"
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "schedule": {
      "id": 25,
      "due_date": "2024-03-01",
      "principal_amount": 2654.83,
      "interest_amount": 1666.67,
      "total_amount": 4321.50,
      "status": "paid",
      "paid_date": "2024-03-01",
      "paid_amount": 4321.50,
      "notes": "Paid via online banking",
      "wallet": {
        "id": 2,
        "name": "SBI Account",
        "currency": {
          "code": "INR",
          "symbol": "₹"
        }
      }
    },
    "emi_loan": {
      "id": 1,
      "name": "Home Loan",
      "status": "active"
    }
  },
  "message": "EMI payment recorded successfully"
}
```

---

### 2. Update Schedule Payment

**PUT** `/api/emi-loans/{loanId}/schedules/{scheduleId}/update-payment`

Update payment details for an already paid schedule.

#### Request Body
Same as mark schedule as paid.

#### Example Response
```json
{
  "success": true,
  "data": {
    "schedule": {
      "id": 25,
      "status": "paid",
      "paid_date": "2024-03-02",
      "paid_amount": 4321.50,
      "notes": "Updated payment date"
    },
    "emi_loan": {
      "id": 1,
      "name": "Home Loan"
    }
  },
  "message": "EMI payment updated successfully"
}
```

---

### 3. Mark Schedule as Unpaid

**POST** `/api/emi-loans/{loanId}/schedules/{scheduleId}/mark-unpaid`

Reverse a payment and restore wallet balance.

#### Example Response
```json
{
  "success": true,
  "data": {
    "schedule": {
      "id": 25,
      "status": "upcoming",
      "paid_date": null,
      "paid_amount": null,
      "wallet_id": null,
      "notes": null
    },
    "emi_loan": {
      "id": 1,
      "name": "Home Loan"
    }
  },
  "message": "EMI payment reversed successfully"
}
```

---

## Statistics & Analytics

### 1. Get EMI Loan Statistics

**GET** `/api/emi-loans/stats`

Retrieve comprehensive statistics about EMI loans.

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `start_date` | date | No | Filter from this date |
| `end_date` | date | No | Filter until this date |

#### Example Response
```json
{
  "success": true,
  "data": {
    "total_loans": 5,
    "active_loans": 3,
    "closed_loans": 1,
    "cancelled_loans": 1,
    "total_loan_amount": 1250000.00,
    "total_monthly_emi": 12500.00,
    "total_paid_amount": 75000.00,
    "total_pending_amount": 1175000.00,
    "total_schedules": 360,
    "paid_schedules": 15,
    "upcoming_schedules": 345
  },
  "message": "EMI loan statistics retrieved successfully"
}
```

---

### 2. Bulk Delete EMI Loans

**POST** `/api/emi-loans/bulk-delete`

Delete multiple EMI loans at once.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `loan_ids` | array | Yes | Array of loan IDs to delete |

#### Example Request
```json
{
  "loan_ids": [1, 2, 3]
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "deleted_count": 3
  },
  "message": "Successfully deleted 3 EMI loan(s)"
}
```

---

## Data Models

### EMI Loan Model

```json
{
  "id": "integer",
  "user_id": "integer",
  "category_id": "integer|null",
  "name": "string",
  "total_amount": "decimal",
  "interest_rate": "decimal",
  "start_date": "date",
  "tenure_months": "integer",
  "monthly_emi": "decimal",
  "is_auto_deduct": "boolean",
  "loan_type": "enum:fixed,reducing_balance",
  "status": "enum:active,closed,cancelled",
  "default_wallet_id": "integer|null",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### EMI Schedule Model

```json
{
  "id": "integer",
  "user_id": "integer",
  "emi_loan_id": "integer",
  "due_date": "date",
  "principal_amount": "decimal",
  "interest_amount": "decimal",
  "total_amount": "decimal",
  "status": "enum:upcoming,paid,overdue",
  "paid_date": "date|null",
  "paid_amount": "decimal|null",
  "wallet_id": "integer|null",
  "notes": "string|null",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

---

## Error Responses

### Standard Error Format

```json
{
  "success": false,
  "message": "Error description",
  "error": "Detailed error message"
}
```

### Common HTTP Status Codes

| Code | Description | Example Scenario |
|------|-------------|------------------|
| `200` | Success | Successful operation |
| `201` | Created | EMI loan created successfully |
| `400` | Bad Request | Invalid request parameters |
| `401` | Unauthorized | Missing or invalid authentication token |
| `403` | Forbidden | Access denied to resource |
| `404` | Not Found | EMI loan or schedule not found |
| `422` | Validation Error | Invalid input data |
| `500` | Internal Server Error | Server-side error |

### Validation Errors

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "total_amount": ["The total amount field is required."],
    "interest_rate": ["The interest rate must be between 0 and 100."]
  }
}
```

---

## Rate Limiting

- All API endpoints are subject to rate limiting
- Current limit: 60 requests per minute per user
- Rate limit headers are included in responses:
  - `X-RateLimit-Limit`: Maximum requests per minute
  - `X-RateLimit-Remaining`: Remaining requests in current window

## Security Features

- **Authentication**: Laravel Sanctum token-based authentication
- **Authorization**: User-based resource isolation
- **Validation**: Comprehensive input validation
- **Database Transactions**: Atomic operations for financial data
- **Balance Verification**: Automatic wallet balance checks
- **Ownership Validation**: All resources validated against authenticated user

## Loan Type Calculations

### Fixed Loan Type
- Simple interest calculation
- Principal per month: `Total Amount / Tenure`
- Interest per month: `(Total Amount × Interest Rate / 100) / Tenure`
- EMI = Principal + Interest

### Reducing Balance Loan Type
- Compound interest calculation
- Uses standard EMI formula: `P × r × (1+r)^n / ((1+r)^n - 1)`
- Where P = Principal, r = Monthly rate, n = Number of months
- Interest reduces as principal is paid off

---

## Support

For technical support or questions about the EMI Loans API, please contact the development team or refer to the main application documentation.

**Last Updated:** August 25, 2025  
**API Version:** 1.0  
**Framework:** Laravel 11 with Sanctum Authentication
