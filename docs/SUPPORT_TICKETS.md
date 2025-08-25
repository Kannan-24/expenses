# Support Tickets API Documentation

## Overview

The Support Tickets API provides comprehensive functionality for managing customer support tickets with role-based access control, automated notifications, and advanced filtering capabilities. This API supports both customer and admin workflows with proper authorization and security measures.

## Base URL
```
/api/support-tickets
```

## Authentication

All endpoints require authentication using Laravel Sanctum tokens.

**Header Required:**
```
Authorization: Bearer {token}
```

## Table of Contents

1. [Core CRUD Operations](#core-crud-operations)
2. [Ticket Management](#ticket-management)
3. [Analytics & Statistics](#analytics--statistics)
4. [Helper Endpoints](#helper-endpoints)
5. [Data Models](#data-models)
6. [Role-Based Access](#role-based-access)
7. [Error Responses](#error-responses)

---

## Core CRUD Operations

### 1. List Support Tickets

**GET** `/api/support-tickets`

Retrieve a paginated list of support tickets with comprehensive filtering options. Non-admin users can only see their own tickets.

#### Query Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `search` | string | No | Search in ticket subject or user name/email |
| `user_id` | integer | No | Filter by user ID (admin only) |
| `status` | string | No | Filter by status (`opened`, `customer_replied`, `admin_replied`, `closed`) |
| `show_deleted` | boolean | No | Include deleted tickets (admin only) |
| `filter` | string | No | Quick date filters (`7days`, `15days`, `1month`) |
| `start_date` | date | No | Filter tickets created from this date (YYYY-MM-DD) |
| `end_date` | date | No | Filter tickets created until this date (YYYY-MM-DD) |
| `sort_by` | string | No | Sort field (default: `created_at`) |
| `sort_order` | string | No | Sort order (`asc`, `desc`, default: `desc`) |
| `per_page` | integer | No | Items per page (default: 6) |

#### Example Request
```bash
GET /api/support-tickets?search=login&status=opened&filter=7days&per_page=10
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
        "subject": "Login Issue",
        "status": "customer_replied",
        "created_at": "2024-08-20T10:00:00.000000Z",
        "updated_at": "2024-08-21T14:30:00.000000Z",
        "closed_at": null,
        "user": {
          "id": 5,
          "name": "John Doe",
          "email": "john@example.com"
        },
        "messages": [
          {
            "id": 1,
            "message": "I cannot log into my account",
            "is_admin": false,
            "created_at": "2024-08-20T10:00:00.000000Z",
            "user": {
              "id": 5,
              "name": "John Doe"
            }
          },
          {
            "id": 2,
            "message": "Please try resetting your password",
            "is_admin": true,
            "created_at": "2024-08-20T15:30:00.000000Z",
            "user": {
              "id": 1,
              "name": "Admin User"
            }
          }
        ]
      }
    ],
    "per_page": 10,
    "total": 25
  },
  "message": "Support tickets retrieved successfully"
}
```

---

### 2. Create Support Ticket

**POST** `/api/support-tickets`

Create a new support ticket. Requires 'request support' permission.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `subject` | string | Yes | Ticket subject (max: 255 chars) |
| `message` | string | Yes | Initial message content (max: 5000 chars) |

#### Example Request
```json
{
  "subject": "Payment Processing Issue",
  "message": "I'm having trouble processing payments through the app. The payment fails at the final step."
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 26,
    "subject": "Payment Processing Issue",
    "status": "opened",
    "created_at": "2024-08-25T10:00:00.000000Z",
    "updated_at": "2024-08-25T10:00:00.000000Z",
    "closed_at": null,
    "user": {
      "id": 5,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "messages": [
      {
        "id": 45,
        "message": "I'm having trouble processing payments through the app. The payment fails at the final step.",
        "is_admin": false,
        "created_at": "2024-08-25T10:00:00.000000Z",
        "user": {
          "id": 5,
          "name": "John Doe"
        }
      }
    ]
  },
  "message": "Support ticket created successfully"
}
```

---

### 3. Get Support Ticket Details

**GET** `/api/support-tickets/{id}`

Retrieve detailed information about a specific support ticket including all messages. Users can only access their own tickets unless they are admins.

#### Example Request
```bash
GET /api/support-tickets/1
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "subject": "Login Issue",
    "status": "admin_replied",
    "created_at": "2024-08-20T10:00:00.000000Z",
    "updated_at": "2024-08-21T14:30:00.000000Z",
    "closed_at": null,
    "user": {
      "id": 5,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "messages": [
      {
        "id": 1,
        "message": "I cannot log into my account",
        "is_admin": false,
        "created_at": "2024-08-20T10:00:00.000000Z",
        "user": {
          "id": 5,
          "name": "John Doe"
        }
      },
      {
        "id": 2,
        "message": "Please try resetting your password using the 'Forgot Password' link.",
        "is_admin": true,
        "created_at": "2024-08-21T14:30:00.000000Z",
        "user": {
          "id": 1,
          "name": "Admin User"
        }
      }
    ]
  },
  "message": "Support ticket retrieved successfully"
}
```

---

### 4. Delete Support Ticket

**DELETE** `/api/support-tickets/{id}`

Delete a support ticket. Users can only delete their own tickets unless they are admins.

#### Example Response
```json
{
  "success": true,
  "message": "Support ticket deleted successfully"
}
```

---

## Ticket Management

### 1. Add Reply to Ticket

**POST** `/api/support-tickets/{id}/reply`

Add a reply message to an existing support ticket. Automatically updates ticket status and sends notifications.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `message` | string | Yes | Reply message content (max: 5000 chars) |

#### Example Request
```json
{
  "message": "Thank you for the suggestion. I tried resetting my password and it worked!"
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "message": {
      "id": 47,
      "message": "Thank you for the suggestion. I tried resetting my password and it worked!",
      "is_admin": false,
      "created_at": "2024-08-25T11:00:00.000000Z",
      "user": {
        "id": 5,
        "name": "John Doe"
      }
    },
    "ticket": {
      "id": 1,
      "subject": "Login Issue",
      "status": "customer_replied",
      "updated_at": "2024-08-25T11:00:00.000000Z",
      "user": {
        "id": 5,
        "name": "John Doe"
      }
    }
  },
  "message": "Reply added successfully"
}
```

---

### 2. Close Support Ticket

**POST** `/api/support-tickets/{id}/close`

Mark a support ticket as closed. Sets the status to 'closed' and records the closure timestamp.

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "subject": "Login Issue",
    "status": "closed",
    "closed_at": "2024-08-25T11:30:00.000000Z",
    "updated_at": "2024-08-25T11:30:00.000000Z"
  },
  "message": "Support ticket closed successfully"
}
```

---

### 3. Reopen Support Ticket

**POST** `/api/support-tickets/{id}/reopen`

Reopen a closed support ticket. Sets the status to 'opened' and clears the closure timestamp.

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "subject": "Login Issue",
    "status": "opened",
    "closed_at": null,
    "updated_at": "2024-08-25T12:00:00.000000Z"
  },
  "message": "Support ticket reopened successfully"
}
```

---

### 4. Recover Deleted Ticket

**POST** `/api/support-tickets/{id}/recover`

Recover a soft-deleted support ticket. **Admin access only.**

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 1,
    "subject": "Login Issue",
    "status": "opened",
    "deleted_at": null,
    "updated_at": "2024-08-25T12:30:00.000000Z"
  },
  "message": "Support ticket recovered successfully"
}
```

---

## Analytics & Statistics

### 1. Get Support Ticket Statistics

**GET** `/api/support-tickets/stats`

Retrieve comprehensive statistics about support tickets. Admins see global stats, users see personal stats.

#### Example Response
```json
{
  "success": true,
  "data": {
    "total_tickets": 125,
    "opened_tickets": 15,
    "closed_tickets": 85,
    "customer_replied_tickets": 20,
    "admin_replied_tickets": 5,
    "recent_tickets_30_days": 45,
    "avg_response_time": 4.5
  },
  "message": "Support ticket statistics retrieved successfully"
}
```

---

### 2. Get Tickets by Status

**GET** `/api/support-tickets/by-status`

Get ticket counts grouped by status for dashboard widgets.

#### Example Response
```json
{
  "success": true,
  "data": {
    "opened": 15,
    "customer_replied": 20,
    "admin_replied": 5,
    "closed": 85
  },
  "message": "Tickets by status retrieved successfully"
}
```

---

### 3. Bulk Operations

**POST** `/api/support-tickets/bulk-update`

Perform bulk operations on multiple support tickets.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `ticket_ids` | array | Yes | Array of ticket IDs to update |
| `action` | string | Yes | Action to perform (`close`, `reopen`, `delete`) |

#### Example Request
```json
{
  "ticket_ids": [1, 2, 3, 5],
  "action": "close"
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "updated_count": 4
  },
  "message": "Successfully closed 4 ticket(s)"
}
```

---

## Helper Endpoints

### 1. Get Users List

**GET** `/api/support-tickets/users`

Get list of all users for admin filtering. **Admin access only.**

#### Example Response
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com"
    },
    {
      "id": 5,
      "name": "John Doe",
      "email": "john@example.com"
    },
    {
      "id": 8,
      "name": "Jane Smith",
      "email": "jane@example.com"
    }
  ],
  "message": "Users retrieved successfully"
}
```

---

## Data Models

### Support Ticket Model

```json
{
  "id": "integer",
  "user_id": "integer",
  "subject": "string",
  "status": "enum:opened,customer_replied,admin_replied,closed",
  "closed_at": "timestamp|null",
  "created_at": "timestamp",
  "updated_at": "timestamp",
  "deleted_at": "timestamp|null"
}
```

### Support Message Model

```json
{
  "id": "integer",
  "support_ticket_id": "integer",
  "user_id": "integer",
  "message": "text",
  "is_admin": "boolean",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

### User Model (Related)

```json
{
  "id": "integer",
  "name": "string",
  "email": "string"
}
```

---

## Role-Based Access

### User Permissions

**Regular Users:**
- Can create support tickets (with 'request support' permission)
- Can view only their own tickets
- Can reply to their own tickets
- Can close/reopen their own tickets
- Can delete their own tickets
- Cannot access admin-only endpoints
- Cannot see other users' tickets

**Admin Users:**
- Can view all support tickets
- Can filter tickets by any user
- Can reply to any ticket
- Can close/reopen any ticket
- Can delete any ticket
- Can recover deleted tickets
- Can access global statistics
- Can view users list for filtering
- Can see deleted tickets

### Status Flow

```
opened → customer_replied → admin_replied → closed
   ↑                                          ↓
   ←-----------------reopen------------------←
```

- **opened**: Initial state when ticket is created
- **customer_replied**: Customer has added a reply
- **admin_replied**: Admin has responded to the ticket
- **closed**: Ticket has been resolved and closed

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
| `201` | Created | Support ticket created successfully |
| `400` | Bad Request | Invalid request parameters |
| `401` | Unauthorized | Missing or invalid authentication token |
| `403` | Forbidden | Access denied to resource or insufficient permissions |
| `404` | Not Found | Support ticket not found |
| `422` | Validation Error | Invalid input data |
| `500` | Internal Server Error | Server-side error |

### Validation Errors

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "subject": ["The subject field is required."],
    "message": ["The message field is required."]
  }
}
```

### Authorization Errors

```json
{
  "success": false,
  "message": "Unauthorized access to this support ticket."
}
```

```json
{
  "success": false,
  "message": "You do not have permission to create a support ticket"
}
```

---

## Notification System

The Support Tickets API includes an automated notification system:

### Ticket Creation
- **Triggered**: When a new ticket is created
- **Recipients**: All admin users
- **Notification**: `SupportTicketCreated`

### Ticket Replies
- **Admin Reply**: Notifies the ticket creator
- **Customer Reply**: Notifies the last admin who replied, or all admins if no previous admin interaction
- **Notification**: `SupportTicketReplied`

### Notification Channels
- Email notifications
- In-app notifications
- Push notifications (if configured)

---

## Rate Limiting

- All API endpoints are subject to rate limiting
- Current limit: 60 requests per minute per user
- Rate limit headers are included in responses:
  - `X-RateLimit-Limit`: Maximum requests per minute
  - `X-RateLimit-Remaining`: Remaining requests in current window

## Security Features

- **Authentication**: Laravel Sanctum token-based authentication
- **Authorization**: Role-based access control using Spatie Permission
- **Validation**: Comprehensive input validation and sanitization
- **Ownership Validation**: Users can only access their own tickets (non-admins)
- **Permission Checks**: Support creation permission validation
- **Audit Trail**: Complete message history with timestamps

## Best Practices

### For Developers
1. Always check user roles before displaying admin-only features
2. Implement proper error handling for all API calls
3. Use pagination for ticket lists to improve performance
4. Cache statistics data when possible
5. Implement real-time updates for active ticket conversations

### For API Consumers
1. Check the `status` field to determine appropriate actions
2. Use filtering and pagination for better performance
3. Implement proper error handling for network failures
4. Respect rate limits to avoid being blocked
5. Use bulk operations for multiple ticket updates

---

## Support

For technical support or questions about the Support Tickets API, please contact the development team or refer to the main application documentation.

**Last Updated:** August 25, 2025  
**API Version:** 1.0  
**Framework:** Laravel 11 with Sanctum Authentication and Spatie Permission