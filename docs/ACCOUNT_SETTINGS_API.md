# Account Settings API Documentation

## Overview

The Account Settings API provides comprehensive functionality for managing user account information, security settings, notification preferences, and profile data. This API enables users to customize their account experience with secure authentication and validation.

## Base URL
```
/api/account
```

## Authentication

All endpoints require authentication using Laravel Sanctum tokens.

**Header Required:**
```
Authorization: Bearer {token}
```

## Table of Contents

1. [Profile Management](#profile-management)
2. [Security & Authentication](#security--authentication)
3. [Notification Management](#notification-management)
4. [Account Analytics](#account-analytics)
5. [Configuration Options](#configuration-options)
6. [Data Models](#data-models)
7. [Error Responses](#error-responses)

---

## Profile Management

### 1. Get User Profile

**GET** `/api/account/profile`

Retrieve the authenticated user's profile information.

#### Example Request
```bash
GET /api/account/profile
Authorization: Bearer your-token-here
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 5,
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "address": "123 Main St, City, State 12345",
    "email_verified_at": "2024-01-15T10:30:00.000000Z",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-08-20T14:30:00.000000Z",
    "has_set_password": true,
    "password_updated_at": "2024-07-15T09:20:00.000000Z"
  },
  "message": "Profile retrieved successfully"
}
```

---

### 2. Update User Profile

**PUT** `/api/account/profile`

Update the authenticated user's profile information.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `name` | string | Yes | User's full name (max: 255 chars) |
| `email` | string | Yes | User's email address (must be unique) |
| `phone` | string | No | Phone number (max: 20 chars) |
| `address` | string | No | Physical address (max: 500 chars) |

#### Example Request
```json
{
  "name": "John Smith",
  "email": "johnsmith@example.com",
  "phone": "+1987654321",
  "address": "456 Oak Avenue, New City, State 54321"
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "id": 5,
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "phone": "+1987654321",
    "address": "456 Oak Avenue, New City, State 54321",
    "email_verified_at": "2024-01-15T10:30:00.000000Z",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-08-25T15:45:00.000000Z",
    "has_set_password": true,
    "password_updated_at": "2024-07-15T09:20:00.000000Z"
  },
  "message": "Profile updated successfully"
}
```

---

### 3. Get All Account Settings

**GET** `/api/account/settings`

Retrieve all account settings in a single response including profile, notifications, security, and activity data.

#### Example Response
```json
{
  "success": true,
  "data": {
    "profile": {
      "id": 5,
      "name": "John Smith",
      "email": "johnsmith@example.com",
      "phone": "+1987654321",
      "address": "456 Oak Avenue, New City, State 54321"
    },
    "notifications": {
      "wants_reminder": true,
      "reminder_frequency": "daily",
      "reminder_time": "09:00",
      "timezone": "America/New_York",
      "email_reminders": true,
      "push_reminders": false,
      "custom_weekdays": null,
      "random_min_days": null,
      "random_max_days": null,
      "last_reminder_sent": "2024-08-24T09:00:00.000000Z"
    },
    "security": {
      "has_set_password": true,
      "password_updated_at": "2024-07-15T09:20:00.000000Z",
      "email_verified_at": "2024-01-15T10:30:00.000000Z",
      "two_factor_enabled": false,
      "last_login_at": "2024-08-25T08:30:00.000000Z"
    },
    "activity": {
      "total_transactions": 156,
      "total_budgets": 8,
      "total_wallets": 3,
      "account_created": "2024-01-01T00:00:00.000000Z",
      "last_activity": "2024-08-25T15:45:00.000000Z",
      "streak_days": 25,
      "longest_streak": 45
    }
  },
  "message": "All account settings retrieved successfully"
}
```

---

## Security & Authentication

### 1. Update Password

**PUT** `/api/account/password`

Update the user's password with current password verification.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `current_password` | string | Yes | Current password for verification |
| `password` | string | Yes | New password (min: 8 chars) |
| `password_confirmation` | string | Yes | Password confirmation (must match) |

#### Example Request
```json
{
  "current_password": "oldpassword123",
  "password": "newSecurePassword456",
  "password_confirmation": "newSecurePassword456"
}
```

#### Example Response
```json
{
  "success": true,
  "message": "Password updated successfully"
}
```

#### Error Response (Invalid Current Password)
```json
{
  "success": false,
  "message": "Current password is incorrect",
  "errors": {
    "current_password": ["The current password is incorrect."]
  }
}
```

---

### 2. Get Account Security

**GET** `/api/account/security`

Retrieve account security information and status.

#### Example Response
```json
{
  "success": true,
  "data": {
    "has_set_password": true,
    "password_updated_at": "2024-08-25T16:00:00.000000Z",
    "email_verified_at": "2024-01-15T10:30:00.000000Z",
    "two_factor_enabled": false,
    "last_login_at": "2024-08-25T08:30:00.000000Z"
  },
  "message": "Account security information retrieved successfully"
}
```

---

### 3. Delete Account

**DELETE** `/api/account/delete`

Permanently delete the user's account with password confirmation.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `password` | string | Yes | Current password for verification |
| `confirmation` | string | Yes | Must be exactly "DELETE" |

#### Example Request
```json
{
  "password": "userpassword123",
  "confirmation": "DELETE"
}
```

#### Example Response
```json
{
  "success": true,
  "message": "Account deleted successfully"
}
```

---

## Notification Management

### 1. Get Notification Preferences

**GET** `/api/account/notifications`

Retrieve the user's notification preferences and reminder settings.

#### Example Response
```json
{
  "success": true,
  "data": {
    "wants_reminder": true,
    "reminder_frequency": "custom_weekdays",
    "reminder_time": "09:00",
    "timezone": "America/New_York",
    "email_reminders": true,
    "push_reminders": false,
    "custom_weekdays": [1, 2, 3, 4, 5],
    "random_min_days": null,
    "random_max_days": null,
    "last_reminder_sent": "2024-08-23T09:00:00.000000Z"
  },
  "message": "Notification preferences retrieved successfully"
}
```

---

### 2. Update Notification Preferences

**PUT** `/api/account/notifications`

Update the user's notification preferences with comprehensive validation.

#### Request Body

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `wants_reminder` | boolean | No | Enable/disable reminders |
| `reminder_frequency` | string | Yes | Frequency type (see options below) |
| `reminder_time` | string | Yes | Time in HH:MM format (24-hour) |
| `timezone` | string | Yes | Valid timezone identifier |
| `email_reminders` | boolean | No | Enable email notifications |
| `push_reminders` | boolean | No | Enable push notifications |
| `custom_weekdays` | array | No | Weekday numbers (0-6, required if frequency is custom_weekdays) |
| `random_min_days` | integer | No | Min days for random frequency (1-30) |
| `random_max_days` | integer | No | Max days for random frequency (1-30) |

#### Reminder Frequency Options
- `daily` - Every day
- `every_2_days` - Every 2 days
- `every_3_days` - Every 3 days
- `every_4_days` - Every 4 days
- `every_5_days` - Every 5 days
- `every_6_days` - Every 6 days
- `weekly` - Once per week
- `custom_weekdays` - Specific weekdays (requires custom_weekdays array)
- `random` - Random intervals (requires random_min_days and random_max_days)
- `never` - No reminders

#### Example Request (Custom Weekdays)
```json
{
  "wants_reminder": true,
  "reminder_frequency": "custom_weekdays",
  "reminder_time": "09:30",
  "timezone": "America/Los_Angeles",
  "email_reminders": true,
  "push_reminders": false,
  "custom_weekdays": [1, 2, 3, 4, 5]
}
```

#### Example Request (Random Frequency)
```json
{
  "wants_reminder": true,
  "reminder_frequency": "random",
  "reminder_time": "10:00",
  "timezone": "Europe/London",
  "email_reminders": false,
  "push_reminders": true,
  "random_min_days": 2,
  "random_max_days": 5
}
```

#### Example Response
```json
{
  "success": true,
  "data": {
    "wants_reminder": true,
    "reminder_frequency": "custom_weekdays",
    "reminder_time": "09:30",
    "timezone": "America/Los_Angeles",
    "email_reminders": true,
    "push_reminders": false,
    "custom_weekdays": [1, 2, 3, 4, 5],
    "random_min_days": null,
    "random_max_days": null,
    "last_reminder_sent": "2024-08-23T09:00:00.000000Z"
  },
  "message": "Notification preferences updated successfully"
}
```

---

## Account Analytics

### 1. Get Account Activity

**GET** `/api/account/activity`

Retrieve account activity summary and usage statistics.

#### Example Response
```json
{
  "success": true,
  "data": {
    "total_transactions": 156,
    "total_budgets": 8,
    "total_wallets": 3,
    "account_created": "2024-01-01T00:00:00.000000Z",
    "last_activity": "2024-08-25T15:45:00.000000Z",
    "streak_days": 25,
    "longest_streak": 45
  },
  "message": "Account activity retrieved successfully"
}
```

---

## Configuration Options

### 1. Get Configuration Options

**GET** `/api/account/config-options`

Retrieve available configuration options for timezones, frequencies, and weekdays.

#### Example Response
```json
{
  "success": true,
  "data": {
    "timezones": {
      "UTC": "UTC",
      "America/New_York": "Eastern Time",
      "America/Chicago": "Central Time",
      "America/Denver": "Mountain Time",
      "America/Los_Angeles": "Pacific Time",
      "Europe/London": "London",
      "Europe/Paris": "Paris",
      "Europe/Berlin": "Berlin",
      "Asia/Tokyo": "Tokyo",
      "Asia/Shanghai": "Shanghai",
      "Asia/Kolkata": "Mumbai/Kolkata",
      "Asia/Dubai": "Dubai",
      "Australia/Sydney": "Sydney",
      "Pacific/Auckland": "Auckland"
    },
    "reminder_frequencies": {
      "daily": "Daily",
      "every_2_days": "Every 2 Days",
      "every_3_days": "Every 3 Days",
      "every_4_days": "Every 4 Days",
      "every_5_days": "Every 5 Days",
      "every_6_days": "Every 6 Days",
      "weekly": "Weekly",
      "custom_weekdays": "Custom Weekdays",
      "random": "Random",
      "never": "Never"
    },
    "weekdays": {
      "0": "Sunday",
      "1": "Monday",
      "2": "Tuesday",
      "3": "Wednesday",
      "4": "Thursday",
      "5": "Friday",
      "6": "Saturday"
    }
  },
  "message": "Configuration options retrieved successfully"
}
```

---

## Data Models

### User Profile Model

```json
{
  "id": "integer",
  "name": "string",
  "email": "string",
  "phone": "string|null",
  "address": "string|null",
  "email_verified_at": "timestamp|null",
  "created_at": "timestamp",
  "updated_at": "timestamp",
  "has_set_password": "boolean",
  "password_updated_at": "timestamp|null"
}
```

### Notification Preferences Model

```json
{
  "wants_reminder": "boolean",
  "reminder_frequency": "enum",
  "reminder_time": "string (HH:MM)",
  "timezone": "string",
  "email_reminders": "boolean",
  "push_reminders": "boolean",
  "custom_weekdays": "array|null",
  "random_min_days": "integer|null",
  "random_max_days": "integer|null",
  "last_reminder_sent": "timestamp|null"
}
```

### Account Security Model

```json
{
  "has_set_password": "boolean",
  "password_updated_at": "timestamp|null",
  "email_verified_at": "timestamp|null",
  "two_factor_enabled": "boolean",
  "last_login_at": "timestamp|null"
}
```

### Account Activity Model

```json
{
  "total_transactions": "integer",
  "total_budgets": "integer",
  "total_wallets": "integer",
  "account_created": "timestamp",
  "last_activity": "timestamp",
  "streak_days": "integer",
  "longest_streak": "integer"
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

### Validation Error Format

```json
{
  "success": false,
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email has already been taken."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Common HTTP Status Codes

| Code | Description | Example Scenario |
|------|-------------|------------------|
| `200` | Success | Profile retrieved successfully |
| `400` | Bad Request | Invalid request parameters |
| `401` | Unauthorized | Missing or invalid authentication token |
| `422` | Validation Error | Invalid input data or constraints violated |
| `500` | Internal Server Error | Server-side error |

---

## Validation Rules

### Profile Update Validation
- **name**: Required, string, maximum 255 characters
- **email**: Required, valid email format, unique across users
- **phone**: Optional, string, maximum 20 characters
- **address**: Optional, string, maximum 500 characters

### Password Update Validation
- **current_password**: Required, must match user's current password
- **password**: Required, minimum 8 characters, must be confirmed
- **password_confirmation**: Required, must match password field

### Notification Preferences Validation
- **reminder_frequency**: Must be one of the valid frequency options
- **reminder_time**: Must be in HH:MM format (24-hour)
- **timezone**: Must be a valid timezone identifier
- **custom_weekdays**: Required array if frequency is 'custom_weekdays', values 0-6
- **random_min_days**: Integer between 1-30 if frequency is 'random'
- **random_max_days**: Integer between 1-30, must be ≥ random_min_days

### Account Deletion Validation
- **password**: Required, must match user's current password
- **confirmation**: Required, must be exactly "DELETE"

---

## Security Features

### Authentication & Authorization
- **Sanctum Authentication**: All endpoints require valid API token
- **User Isolation**: Users can only access their own account data
- **Password Verification**: Sensitive operations require current password

### Data Protection
- **Email Uniqueness**: Prevents duplicate email addresses
- **Password Security**: Secure hashing and verification
- **Token Management**: Automatic token cleanup on account deletion

### Validation & Sanitization
- **Input Validation**: Comprehensive validation rules for all fields
- **Data Sanitization**: Automatic data cleaning and formatting
- **Error Handling**: Detailed error messages for debugging

---

## Best Practices

### For Developers
1. **Profile Updates**: Always validate email uniqueness before updating
2. **Password Changes**: Implement proper current password verification
3. **Notification Settings**: Handle complex frequency validations properly
4. **Error Handling**: Implement comprehensive error handling for all scenarios
5. **Security**: Never expose sensitive data in API responses

### For API Consumers
1. **Authentication**: Always include valid Bearer token in requests
2. **Validation**: Handle validation errors gracefully in UI
3. **Passwords**: Implement secure password input fields
4. **Notifications**: Provide clear UI for complex notification settings
5. **Account Deletion**: Implement proper confirmation flows

### Security Recommendations
1. **Token Management**: Regularly rotate API tokens
2. **Password Policy**: Enforce strong password requirements
3. **Session Security**: Implement proper session management
4. **Data Backup**: Consider data export before account deletion
5. **Audit Logging**: Track security-related account changes

---

## Usage Examples

### Complete Profile Update Flow
```javascript
// 1. Get current profile
const profile = await fetch('/api/account/profile', {
  headers: { 'Authorization': 'Bearer ' + token }
});

// 2. Update profile with new data
const updateResponse = await fetch('/api/account/profile', {
  method: 'PUT',
  headers: {
    'Authorization': 'Bearer ' + token,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    name: 'Updated Name',
    email: 'newemail@example.com',
    phone: '+1234567890'
  })
});
```

### Password Change Flow
```javascript
const passwordUpdate = await fetch('/api/account/password', {
  method: 'PUT',
  headers: {
    'Authorization': 'Bearer ' + token,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    current_password: 'currentPassword',
    password: 'newSecurePassword',
    password_confirmation: 'newSecurePassword'
  })
});
```

### Complex Notification Setup
```javascript
const notificationUpdate = await fetch('/api/account/notifications', {
  method: 'PUT',
  headers: {
    'Authorization': 'Bearer ' + token,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    wants_reminder: true,
    reminder_frequency: 'custom_weekdays',
    reminder_time: '09:00',
    timezone: 'America/New_York',
    email_reminders: true,
    push_reminders: false,
    custom_weekdays: [1, 2, 3, 4, 5] // Monday to Friday
  })
});
```

---

## Support

For technical support or questions about the Account Settings API, please contact the development team or refer to the main application documentation.

**Last Updated:** August 25, 2025  
**API Version:** 1.0  
**Framework:** Laravel 11 with Sanctum Authentication
