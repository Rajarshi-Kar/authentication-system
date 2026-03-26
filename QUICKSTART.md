# Quick Start Guide

Get the authentication system running in 5 minutes.

## Prerequisites
- PHP 7.4+
- Composer
- Node.js 14+
- MySQL or PostgreSQL

## Super Quick Start

### Option A: Using Setup Script (Recommended)

**Windows:**
```bash
cd HAWC
setup.bat
```

**Mac/Linux:**
```bash
cd HAWC
chmod +x setup.sh
./setup.sh
```

Then:
1. Configure `.env` file with your database credentials
2. Import SQL file into your database
3. Run backend: `cd hawk-backend && php spark serve`
4. In new terminal, run frontend: `cd hawk-frontend && npm start`

---

### Option B: Manual Setup

#### 1. Backend Setup (10 minutes)

```bash
cd hawk-backend

# Install dependencies
composer install

# Copy environment file  
cp .env.example .env

# Configure database in .env

# Create writable directories
mkdir -p writable/session writable/logs

# Run migrations (optional, if not using SQL import)
php spark migrate

# Seed database (optional)
php spark db:seed DatabaseSeeder

# Start server
php spark serve
```

Backend running at: `http://localhost:8080`

#### 2. Frontend Setup (5 minutes)

In a new terminal:

```bash
cd hawk-frontend

# Install dependencies
npm install

# Start development server
npm start
```

Frontend opens at: `http://localhost:3000`

#### 3. Database Setup (2 minutes)

Import one of the database files:

**MySQL:**
```bash
mysql -u root -p hawk_db < database/hawk_db_mysql.sql
```

**PostgreSQL:**
```bash
psql -U postgres < database/hawk_db_postgres.sql
```

---

## Test the Application

### Login with Demo Account
```
Email: john@example.com
Password: password123
```

### Test Credentials
- Email: `jane@example.com` | Password: `password123`
- Email: `robert@example.com` | Password: `password123`

---

## Key Features to Try

1. **Register New User**
   - Go to Register page
   - Fill in all fields (both auth and teacher data)
   - Click Register
   - Automatically logged in with JWT token

2. **View Profile**
   - After login, go to Dashboard
   - See personal and teacher information

3. **View All Teachers**
   - Go to Teachers List
   - See all registered teachers in sortable table

4. **API Testing**
   - Use Postman or cURL
   - See [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## Troubleshooting

### "Could not open database connection"
- Check MySQL/PostgreSQL is running
- Verify credentials in `.env`
- Ensure database `hawk_db` exists

### "localhost:3000 refused to connect"
- Check if `npm start` is running in frontend folder
- Check for port conflicts

### "API requests failing"
- Ensure backend is running on port 8080
- Check CORS configuration
- Verify JWT token in localStorage

### "Module not found" (Frontend)
- Delete `node_modules` folder
- Run `npm install` again

---

## Project Structure Summary

```
HAWC/
├── hawk-backend/        ← PHP API (port 8080)
│   └── app/Controllers/AuthController.php
├── hawk-frontend/       ← React UI (port 3000)
│   └── src/pages/
├── database/           ← SQL files
├── README.md           ← Main guide
├── API_DOCUMENTATION.md ← API reference
└── GIT_SETUP.md       ← GitHub setup
```

---

## Next Steps

1. Get running locally
2. Read [README.md](README.md) for detailed information
3. Check [API_DOCUMENTATION.md](API_DOCUMENTATION.md) for all endpoints
4. Push to GitHub using [GIT_SETUP.md](GIT_SETUP.md)
5. Deploy to production server

---

## Common Commands

**Backend**
```bash
cd hawk-backend
php spark serve                    # Start server
php spark migrate                  # Run migrations
php spark db:seed DatabaseSeeder  # Seed data
```

**Frontend**
```bash
cd hawk-frontend
npm start          # Start dev server
npm build          # Build for production
npm test           # Run tests
```

---

## Production Deployment

Before deploying:

1. Set `CI_ENVIRONMENT=production` in backend `.env`
2. Update `JWT_SECRET_KEY` with strong random key
3. Run `npm run build` for React
4. Update `.env` with production database
5. Enable HTTPS
6. Set secure database credentials

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed guide.

---

## Need Help?

- Read the [README.md](README.md)
- Check [API_DOCUMENTATION.md](API_DOCUMENTATION.md)
- Review source code in respective folders
- Check browser console (F12) for errors
- Check `hawk-backend/writable/logs/` for server logs

---

Congratulations! The authentication system is now running!

Questions? Check the documentation files or review the source code!
