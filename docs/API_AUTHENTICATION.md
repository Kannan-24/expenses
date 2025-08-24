# API Authentication with Laravel Sanctum

This application now supports API authentication using Laravel Sanctum alongside the existing web authentication system.

## Authentication Endpoints

### Base URL
All API endpoints are prefixed with `/api`

### Public Endpoints

#### Register
```
POST /api/auth/register
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "device_name": "Mobile App" // optional
}
```

**Response:**
```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "roles": []
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

#### Login
```
POST /api/auth/login
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123",
    "device_name": "Mobile App" // optional
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "roles": []
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

### Protected Endpoints

All protected endpoints require the `Authorization` header:
```
Authorization: Bearer YOUR_TOKEN_HERE
```

#### Get User Information
```
GET /api/auth/user
```

**Response:**
```json
{
    "success": true,
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "roles": []
        }
    }
}
```

#### Logout (Current Device)
```
POST /api/auth/logout
```

**Response:**
```json
{
    "success": true,
    "message": "Logout successful"
}
```

#### Logout All Devices
```
POST /api/auth/logout-all
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out from all devices"
}
```

#### Get Active Tokens
```
GET /api/auth/tokens
```

**Response:**
```json
{
    "success": true,
    "data": {
        "tokens": [
            {
                "id": 1,
                "name": "Mobile App",
                "last_used_at": "2025-08-24T10:30:00.000000Z",
                "created_at": "2025-08-24T10:00:00.000000Z"
            }
        ]
    }
}
```

#### Revoke Specific Token
```
POST /api/auth/revoke-token
```

**Request Body:**
```json
{
    "token_id": 1
}
```

**Response:**
```json
{
    "success": true,
    "message": "Token revoked successfully"
}
```

## Error Responses

All endpoints return errors in this format:
```json
{
    "success": false,
    "message": "Error description",
    "errors": {
        "field": ["Error message"]
    }
}
```

## Usage Examples

### Using cURL

#### Login
```bash
curl -X POST http://your-domain.com/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123",
    "device_name": "API Client"
  }'
```

#### Access Protected Route
```bash
curl -X GET http://your-domain.com/api/auth/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json"
```

### Using JavaScript/Fetch

#### Login
```javascript
const response = await fetch('/api/auth/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        email: 'john@example.com',
        password: 'password123',
        device_name: 'Web App'
    })
});

const data = await response.json();
if (data.success) {
    localStorage.setItem('token', data.data.token);
}
```

#### Access Protected Route
```javascript
const token = localStorage.getItem('token');
const response = await fetch('/api/auth/user', {
    headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    }
});

const data = await response.json();
```

## Security Features

- **Token-based authentication**: Uses Laravel Sanctum's secure token system
- **Multiple device support**: Users can have multiple active tokens
- **Token management**: Users can view and revoke specific tokens
- **Automatic token cleanup**: Laravel handles token expiration and cleanup
- **Rate limiting**: Built-in Laravel rate limiting applies to API routes
- **CORS support**: Configured for cross-origin requests

## Integration with Existing System

The API authentication system:
- **Does NOT affect** the existing web authentication
- **Uses the same User model** and database table
- **Respects existing roles and permissions** (when using Spatie permissions)
- **Maintains all existing user relationships** and data
- **Can be used alongside** web authentication

Users can authenticate via both web sessions and API tokens simultaneously without conflicts.
