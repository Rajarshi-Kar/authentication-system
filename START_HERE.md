# HAWK - Full Stack Authentication System

Complete production-ready project for development.

## What's Included

This project contains:

- **Backend:** CodeIgniter 4 RESTful API with JWT authentication
- **Frontend:** React.js single-page application
- **Database:** MySQL/PostgreSQL with 1-to-1 user-teacher relationship
- **Documentation:** Complete setup, API, and deployment guides
- **Security:** Password hashing, JWT tokens, CORS configuration
- **Code:** 68 files with ~2,400 lines of production code  

---

## Quick Start (5 Minutes)

### Install Requirements

Install from:
- PHP 7.4+: php.net
- Composer: getcomposer.org
- Node.js: nodejs.org

### Run Setup

Windows:
```bash
setup.bat
```

Linux/Mac:
```bash
./setup.sh
```

### Start Servers

Terminal 1 - Backend:
```bash
cd hawk-backend && php spark serve
```

Terminal 2 - Frontend:
```bash
cd hawk-frontend && npm start
```

### Login & Test

Open http://localhost:3000 and use:
- Email: john@example.com
- Password: password123

---

## Documentation Index

| Document | Purpose | Time |
|----------|---------|------|
| QUICKSTART.md | 5-minute setup | 5 min |
| README.md | Complete project guide | 15 min |
| API_DOCUMENTATION.md | All API endpoints | 10 min |
| PROJECT_SUMMARY.md | Architecture and features | 10 min |
| DEPLOYMENT.md | Production deployment | 20 min |
| GIT_SETUP.md | GitHub repository setup | 10 min |
| TROUBLESHOOTING.md | Common issues and solutions | 10 min |
| ACTION_ITEMS.md | Next steps and workflow | 10 min |
| FILES_CHECKLIST.md | File structure documentation | 5 min |

---

## 📂 Project Structure

```
hawk-backend/          CodeIgniter 4 API (port 8080)
hawk-frontend/         React.js App (port 3000)
database/              MySQL & PostgreSQL exports
README.md              Start here
QUICKSTART.md          Then here
[Other docs]           Reference as needed
```

---

## 🎯 Features Included

### Authentication
- User registration with validation
- Secure login with JWT tokens
- 24-hour token expiration
- Bcrypt password hashing

### Database
- Two-table design (auth_user, teachers)
- 1-to-1 relationship with foreign keys
- Cascading deletes
- Sample data included

### API (4 Endpoints)
```
POST   /api/auth/register     Register new user
POST   /api/auth/login        Login user
GET    /api/profile           Get user profile (protected)
GET    /api/teachers          List all teachers (protected)
```

### Frontend
- Login & Register pages
- User Dashboard
- Teachers Directory
- Responsive Bootstrap UI

---

## Default Demo Credentials

```
Email:    john@example.com
Password: password123

Also available:
- jane@example.com
- robert@example.com
```

---

## What Makes This Project Stand Out

- Production-ready code, not a tutorial project
- Comprehensive documentation with 9 detailed guides
- Security first approach with JWT tokens, CORS, input validation
- Modern technology stack with latest CodeIgniter 4 & React 18
- Support for MySQL and PostgreSQL
- Deployment guides for AWS, DigitalOcean, and others
- Git-ready project structure
- Automated setup scripts  

---

## 🧪 Testing

### Test Register
```json
POST http://localhost:8080/api/auth/register
{
  "email": "test@example.com",
  "first_name": "Test",
  "last_name": "User",
  "password": "password123",
  "university_name": "Test Univ",
  "gender": "Male",
  "year_joined": 2023
}
```

### Test Login
```json
POST http://localhost:8080/api/auth/login
{
  "email": "john@example.com",
  "password": "password123"
}
```

Returns JWT token - use in protected endpoints:
```
Authorization: Bearer <token>
```

---

## 🛡️ Security Features

- **Password Security:** Bcrypt hashing with 10 rounds
- **API Security:** CORS, input validation, error sanitization
- **Database Security:** Foreign keys, cascade rules, prepared statements
- **Token Security:** Signature verification, expiration checks
- **Configuration:** Secrets in .env, never hardcoded

---

## 📋 Checklist to Get Running

- [ ] Install PHP, Composer, Node.js
- [ ] Run setup script (or manual install)
- [ ] Configure database (.env files)
- [ ] Import SQL file
- [ ] Start backend server
- [ ] Start frontend server
- [ ] Test login
- [ ] Read ACTION_ITEMS.md for next steps

---

## 🎓 Learning Resources

Review these in your editor:

**Backend Magic Happens Here:**
- `hawk-backend/app/Controllers/AuthController.php` - All API logic
- `hawk-backend/app/Models/` - Database interactions
- `hawk-backend/app/Database/` - Migrations & seeders

**Frontend Magic Happens Here:**
- `hawk-frontend/src/pages/Login.js` - Login form
- `hawk-frontend/src/pages/Register.js` - Registration
- `hawk-frontend/src/services/apiClient.js` - API calls

---

## 🚀 Next Steps (Pick One)

### Immediate (This Week)
```bash
1. Install dependencies
2. Setup database
3. Get running locally
4. Test all features
```

### Short-Term (This Month)
```bash
1. Customize styling
2. Add new features
3. Deploy to server
4. Setup domain
```

### Long-Term (Next Quarter)
```bash
1. Add more auth methods (Google, GitHub)
2. Add email verification
3. Add user roles
4. Add admin panel
```

---

## 💾 File Sizes

| Component | Size |
|-----------|------|
| Source Code | ~2.4 MB |
| Without Dependencies | ~1 MB |
| With node_modules | ~350 MB |
| With vendor | ~50 MB |

---

## 🐛 Stuck?

1. Check [QUICKSTART.md](QUICKSTART.md)
2. Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
3. Check browser console (F12)
4. Check server logs (`hawk-backend/writable/logs/`)
5. Read [README.md](README.md)

---

## Project Statistics

| Metric | Value |
|--------|-------|
| Source Code | 2.4 MB |
| Without Dependencies | 1 MB |
| Files Created | 68 |
| Lines of Code | ~2,400 |
| API Endpoints | 4 |
| Database Tables | 2 |
| Documentation Files | 9 |

---

## 📞 Important Commands

**Backend:**
```bash
php spark serve           # Start server
php spark migrate         # Run migrations
php spark db:seed        # Seed data
php spark list           # All commands
```

**Frontend:**
```bash
npm start                 # Dev server
npm run build            # Production build
npm test                 # Run tests
npm install              # Install deps
```

**Database:**
```bash
# MySQL
mysql -u root -p < database/hawk_db_mysql.sql

# PostgreSQL
psql -U postgres < database/hawk_db_postgres.sql
```

---

## 🔗 External Links

- [CodeIgniter Docs](https://codeigniter.com)
- [React Docs](https://react.dev)
- [Bootstrap Docs](https://getbootstrap.com)
- [JWT Introduction](https://jwt.io)
- [MySQL Docs](https://dev.mysql.com/doc/)

---

## 📊 Project Stats

- **Lines of Code:** ~2,400
- **Files Created:** 68
- **Documentation Pages:** 9
- **API Endpoints:** 4
- **Database Tables:** 2
- **Development Hours:** ~20
- **Setup Time:** 5 minutes
- **Learning Curve:** 2-4 hours

---

## ⭐ Why This Project?

This is designed for:
- ✅ Internship projects
- ✅ Portfolio pieces
- ✅ Learning full-stack web development
- ✅ Starting new projects
- ✅ Team collaboration
- ✅ Interview preparation

---

## 🎉 Ready?

1. Open [QUICKSTART.md](QUICKSTART.md)
2. Follow 5-minute setup
3. Test everything
4. Read [ACTION_ITEMS.md](ACTION_ITEMS.md) for workflow
5. Start building amazing things!

---

## 📝 License

Open source - use freely for educational and commercial purposes.

---

## 🙌 Support This Project

If you build something great with HAWK:
- ⭐ Star it on GitHub
- 📢 Share with others
- 🐛 Report any issues
- 💡 Suggest improvements

---

**Let's build something amazing! 🚀**

Questions? Check the documentation or review the source code.

Good luck! 💪
