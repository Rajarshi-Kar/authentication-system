# HAWK API Documentation

## Overview
HAWK (Full-Stack Authentication Web Controller) is a demonstration of modern authentication practices using JWT tokens with a 1-to-1 relationship between users and their profiles.

## Base URL
```
http://localhost:8080/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer <your_jwt_token>
```

---

## Public Endpoints

### 1. Register User
**Endpoint:** `POST /auth/register`

**Description:** Register a new user along with their teacher profile.

**Request Body:**
```json
{
  "email": "john@example.com",
  "first_name": "John",
  "last_name": "Doe",
  "password": "password123",
  "university_name": "KIIT University",
  "gender": "Male",
  "year_joined": 2018
}
```

**Success Response (201 Created):**
```json
{
  "status": true,
  "message": "User registered successfully",
  "data": {
    "user_id": 1,
    "email": "john@example.com",
    "first_name": "John",
    "last_name": "Doe",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
  }
}
```

**Error Response (422 Unprocessable Entity):**
```json
{
  "status": false,
  "message": "Validation failed",
  "errors": {
    "email": "Email already registered",
    "password": "Password must be at least 6 characters"
  }
}
```

---

### 2. Login User
**Endpoint:** `POST /auth/login`

**Description:** Authenticate user with email and password.

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Success Response (200 OK):**
```json
{
  "status": true,
  "message": "Login successful",
  "data": {
    "user_id": 1,
    "email": "john@example.com",
    "first_name": "John",
    "last_name": "Doe",
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
  }
}
```

**Error Response (401 Unauthorized):**
```json
{
  "status": false,
  "message": "Invalid credentials"
}
```

---

## Protected Endpoints

### 3. Get User Profile
**Endpoint:** `GET /profile`

**Headers:**
```
Authorization: Bearer <token>
```

**Success Response (200 OK):**
```json
{
  "status": true,
  "message": "Profile retrieved successfully",
  "data": {
    "user": {
      "id": 1,
      "email": "john@example.com",
      "first_name": "John",
      "last_name": "Doe",
      "created_at": "2024-01-15 10:30:00",
      "updated_at": "2024-01-15 10:30:00"
    },
    "teacher": {
      "id": 1,
      "user_id": 1,
      "university_name": "KIIT University",
      "gender": "Male",
      "year_joined": 2018,
      "specialization": "Computer Science",
      "created_at": "2024-01-15 10:30:00",
      "updated_at": "2024-01-15 10:30:00"
    }
  }
}
```

**Error Response (401 Unauthorized):**
```json
{
  "status": false,
  "message": "Unauthorized - Invalid token"
}
```

---

### 4. Get All Teachers
**Endpoint:** `GET /teachers`

**Headers:**
```
Authorization: Bearer <token>
```

**Success Response (200 OK):**
```json
{
  "status": true,
  "message": "Teachers retrieved successfully",
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "university_name": "KIIT University",
      "gender": "Male",
      "year_joined": 2018,
      "specialization": "Computer Science",
      "email": "john@example.com",
      "first_name": "John",
      "last_name": "Doe",
      "created_at": "2024-01-15 10:30:00",
      "updated_at": "2024-01-15 10:30:00"
    },
    {
      "id": 2,
      "user_id": 2,
      "university_name": "Delhi University",
      "gender": "Female",
      "year_joined": 2019,
      "specialization": "Information Technology",
      "email": "jane@example.com",
      "first_name": "Jane",
      "last_name": "Smith",
      "created_at": "2024-01-15 10:35:00",
      "updated_at": "2024-01-15 10:35:00"
    }
  ]
}
```

---

## Response Status Codes

| Code | Description |
|------|-------------|
| 200 | successful GET request |
| 201 | Successful POST request (resource created) |
| 400 | Bad request |
| 401 | Unauthorized (missing/invalid token) |
| 404 | Resource not found |
| 405 | Method not allowed |
| 422 | Validation failed |
| 500 | Server error |

---

## JWT Token Details

- **Algorithm:** HS256 (HMAC with SHA256)
- **Expiration:** 24 hours
- **Payload:**
  - `iat`: Issued at timestamp
  - `exp`: Expiration timestamp
  - `user_id`: User's database ID
  - `email`: User's email address

---

## Testing with cURL

### Register User:
```bash
curl -X POST http://localhost:8080/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "first_name": "Test",
    "last_name": "User",
    "password": "password123",
    "university_name": "Test University",
    "gender": "Male",
    "year_joined": 2020
  }'
```

### Login:
```bash
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Get Profile (Protected):
```bash
curl -X GET http://localhost:8080/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

### Get Teachers (Protected):
```bash
curl -X GET http://localhost:8080/api/teachers \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## Error Handling

All endpoints return consistent error responses:

```json
{
  "status": false,
  "message": "Error description",
  "errors": {
    "field_name": "Field-specific error"
  }
}
```

---

## Security Notes

1. Always use HTTPS in production
2. Change the JWT_SECRET_KEY in .env
3. Validate and sanitize all inputs
4. Use strong passwords (minimum 6 characters)
5. Passwords are hashed using bcrypt
6. Tokens automatically verify signature before processing

---

## Testing Tools

- **Postman:** Import API endpoints for easy testing
- **cURL:** Use provided examples above
- **Insomnia:** Alternative REST client
- **Thunder Client:** VSCode extension

---

**Last Updated:** 2024
