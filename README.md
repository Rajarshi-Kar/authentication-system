# HAWK - Full Stack Authentication System

A complete full-stack authentication system built with **CodeIgniter 4** (Backend) and **ReactJS** (Frontend) with token-based JWT authentication, demonstrating modern web development practices.

## Features

### Authentication
- User registration with validation
- Secure login with JWT tokens
- Password hashing using bcrypt
- Token-based API authentication

### Database
- Two-table design with 1-to-1 relationship
- `auth_user` table for authentication data
- `teachers` table for profile information
- Foreign key constraints with cascade delete

### API Features
- RESTful API endpoints
- Bearer token authentication
- Environment-based configuration
- CORS enabled

### Frontend
- Modern React with React Router
- Bootstrap 5 styling
- Responsive design
- Token-based state management

## Project Structure

```
HAWC/
├── hawk-backend/              # CodeIgniter 4 Backend
│   ├── app/
│   │   ├── Controllers/       # API Controllers
│   │   ├── Models/            # Database Models
│   │   ├── Config/            # Configuration files
│   │   └── Database/
│   │       ├── Migrations/    # Database migrations
│   │       └── Seeds/         # Database seeders
│   ├── public/                # Public assets
│   ├── composer.json          # PHP dependencies
│   └── .env.example           # Environment configuration
│
├── hawk-frontend/             # ReactJS Frontend
│   ├── src/
│   │   ├── components/        # Reusable components
│   │   ├── pages/             # Page components
│   │   ├── services/          # API services
│   │   ├── App.js             # Main App component
│   │   └── index.js           # Entry point
│   ├── public/                # Static files
│   └── package.json           # NPM dependencies
│
└── database/                  # Database exports
    ├── hawk_db_mysql.sql      # MySQL dump
    └── hawk_db_postgres.sql   # PostgreSQL dump
```

## Prerequisites

- PHP 7.4 or higher
- Composer (PHP package manager)
- Node.js 14+ and npm
- MySQL 5.7+ or PostgreSQL
- Git

## Installation & Setup

### 1. Database Setup

Choose one of the databases:

#### MySQL:
```bash
mysql -u root -p
mysql> SOURCE database/hawk_db_mysql.sql;
```

#### PostgreSQL:
```bash
psql -U postgres
postgres=# \i database/hawk_db_postgres.sql;
```

### 2. Backend Setup (CodeIgniter 4)

```bash
# Navigate to backend directory
cd hawk-backend

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Configure database in .env
# Update: database.default.hostname, database.default.database, etc.

# Set JWT secret key in .env
# Update: JWT_SECRET_KEY = your_secret_key_here

# Run migrations (if not using SQL import)
php spark migrate

# Seed sample data (optional)
php spark db:seed DatabaseSeeder
```

#### Running the Backend Server:

```bash
# Using PHP built-in server (development only)
php spark serve

# Server will run at: http://localhost:8080
```

### 3. Frontend Setup (ReactJS)

```bash
# Navigate to frontend directory
cd hawk-frontend

# Install dependencies
npm install

# Create .env file (if needed)
# Update API_URL if backend is on different port
echo "REACT_APP_API_URL=http://localhost:8080/api" > .env

# Start development server
npm start

# App will open at: http://localhost:3000
```

## API Endpoints

### Authentication (Public)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/register` | Register new user |
| POST | `/api/auth/login` | Login user |

#### Register Request:
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

#### Login Request:
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

### Protected Endpoints (Require JWT Token)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/profile` | Get user profile |
| GET | `/api/teachers` | Get all teachers |

**Header Required:**
```
Authorization: Bearer <token>
```

## Database Schema

### auth_user Table
```sql
- id: Primary Key (AUTO_INCREMENT)
- email: VARCHAR(255) UNIQUE
- first_name: VARCHAR(100)
- last_name: VARCHAR(100)
- password: VARCHAR(255) - Bcrypt hashed
- created_at: DATETIME
- updated_at: DATETIME
```

### teachers Table
```sql
- id: Primary Key (AUTO_INCREMENT)
- user_id: Foreign Key (auth_user.id)
- university_name: VARCHAR(255)
- gender: ENUM('Male', 'Female', 'Other')
- year_joined: INT
- specialization: VARCHAR(255) - Optional
- created_at: DATETIME
- updated_at: DATETIME
```

## Default Demo Credentials

```
Email: john@example.com
Password: password123

Email: jane@example.com
Password: password123

Email: robert@example.com
Password: password123
```

## Frontend Pages

### Public Pages
- `/login` - User login page
- `/register` - User registration page

### Protected Pages (Requires Authentication)
- `/dashboard` - User profile dashboard
- `/teachers` - Teachers directory with data table

## Key Features Showcase

### 1. Authentication Flow
- User registers with personal and teacher data
- Both records are created simultaneously
- JWT token returned on successful registration/login
- Token stored in localStorage for subsequent requests

### 2. Token-Based Security
- All protected endpoints require Bearer token
- Token verified before processing requests
- Automatic token attachment in API requests
- Token expiry: 24 hours

### 3. One-to-One Relationship
- Each user has exactly one teacher profile
- Cascade delete: removing user removes teacher data
- Foreign key constraint ensures data integrity

### 4. Data Display
- Dashboard shows user's personal and teacher information
- Teachers page displays all registered teachers
- Join tables to show combined user and teacher data

## Development & Deployment

### For Production

1. **Backend (CodeIgniter)**
   - Set `CI_ENVIRONMENT = production` in `.env`
   - Enable HTTPS
   - Use strong JWT secret key
   - Set secure database credentials
   - Configure CORS properly

2. **Frontend (React)**
   - Build optimized production bundle: `npm run build`
   - Set correct API URL for production
   - Deploy to web server (Apache, Nginx, etc.)

## Troubleshooting

### CORS Issues
- Ensure backend is running on correct port
- Check CORS configuration in CodeIgniter routes

### Database Connection Errors
- Verify database credentials in `.env`
- Ensure database server is running
- Check database user permissions

### Token Expiry
- Tokens expire after 24 hours
- User needs to login again for new token
- Implement token refresh logic for better UX

## Technologies Used

**Backend:**
- PHP 7.4+
- CodeIgniter 4
- MySQL/PostgreSQL
- JWT for authentication

**Frontend:**
- React 18
- React Router 6
- Bootstrap 5
- Axios for API calls

## File Locations

- Backend: `./hawk-backend/`
- Frontend: `./hawk-frontend/`
- Database Scripts: `./database/`
- This README: `./README.md`

## Git Repository

To initialize Git repository:

```bash
git init
git add .
git commit -m "Initial commit: Full-stack authentication system"
git branch -M main
git remote add origin https://your-repo-url.git
git push -u origin main
```

## License

This project is open source and available for educational purposes.

## Author

Created as an internship project - Full Stack Developer Position

---

**Need Help?**
- Check backend logs: `tail -f hawk-backend/writable/logs/log-*.log`
- Check console errors: Press F12 in browser
- Review API responses in Network tab
