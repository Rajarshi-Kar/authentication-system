# Troubleshooting Guide

Quick solutions to common issues during setup and development.

---

## Installation & Setup Issues

### Issue: Composer not found
**Error:** `composer : The term 'composer' is not recognized`

**Solutions:**
1. Install Composer from https://getcomposer.org/download/
2. Add Composer to PATH environment variable
3. Restart terminal and try again
4. Or use `php composer.phar install` (if composer.phar exists)

---

### Issue: PHP not found
**Error:** `php : The term 'php' is not recognized`

**Solutions:**
1. Install PHP from https://windows.php.net/download/
2. Add PHP to PATH environment variable
3. Use `where php` to verify installation
4. Check PHP version: `php -v`

---

### Issue: Node.js not found
**Error:** `node : The term 'node' is not recognized` or `npm command not found`

**Solutions:**
1. Install Node.js from https://nodejs.org/ (LTS version recommended)
2. Add Node to PATH
3. Restart terminal
4. Verify: `node -v` and `npm -v`

---

### Issue: Database connection failed
**Error:** `Error connecting to database. Check your database config.`

**Solutions:**
```bash
# 1. Check database server is running
# MySQL
mysql -u root -p
# Or check Windows Services for MySQL

# 2. Verify credentials in .env file
database.default.hostname=localhost
database.default.database=hawk_db
database.default.username=root
database.default.password=yourpassword

# 3. Create database if not exists
CREATE DATABASE hawk_db;

# 4. Import SQL file
mysql -u root -p hawk_db < database/hawk_db_mysql.sql

# 5. Test connection
php spark db:ping
```

---

## Backend Issues

### Issue: "Port 8080 is already in use"
**Error:** `Address already in use`

**Solutions:**
```bash
# Option 1: Use different port
php spark serve --port 8081

# Option 2: Kill process using port 8080
# Windows
netstat -ano | findstr :8080
taskkill /PID <PID> /F

# Linux/Mac
lsof -i :8080
kill -9 <PID>
```

---

### Issue: Migration fails
**Error:** `Migration failed to run` or `Table already exists`

**Solutions:**
```bash
# List all migrations
php spark migrate:status

# Rollback last migration
php spark migrate:refresh

# Fresh migration
php spark migrate --group core
php spark migrate --group app
```

---

### Issue: 403 Forbidden or CORS Error
**Error:** `CORS policy: No 'Access-Control-Allow-Origin' header`

**Solutions:**
1. Check `app/Config/Cors.php` has correct origins
2. Verify `BaseController.php` has CORS headers
3. Check frontend API URL in `.env.example`
4. Frontend API URL should be: `http://localhost:8080/api`

---

### Issue: 500 Internal Server Error
**Error:** `HTTP 500 Internal Server Error`

**Solutions:**
```bash
# Check logs
tail -f hawk-backend/writable/logs/log-*.log

# Common causes:
# 1. Database connection issue
# 2. Missing dependencies
# 3. PHP error in code
# 4. File permissions

# Fix file permissions
chmod -R 755 hawk-backend
chmod -R 775 hawk-backend/writable
```

---

### Issue: Token verification fails
**Error:** `401 Unauthorized - Invalid token` on valid token

**Solutions:**
1. Check JWT_SECRET_KEY in .env matches
2. Verify token format in Authorization header: `Bearer <token>`
3. Check token expiration (24 hours)
4. Ensure token copied completely (no spaces)

---

## Frontend Issues

### Issue: "npm: command not found"
**Error:** npm: command not found

**Solutions:**
- Reinstall Node.js
- Add npm to PATH
- Use `npx` (comes with newer Node versions)

---

### Issue: Port 3000 already in use
**Error:** `Something is already using port 3000`

**Solutions:**
```bash
# Kill process on port 3000
# Windows
netstat -ano | findstr :3000
taskkill /PID <PID> /F

# Linux/Mac
lsof -i :3000
kill -9 <PID>

# Or use different port
PORT=3001 npm start
```

---

### Issue: Module not found in React
**Error:** `Module not found: Can't resolve 'module-name'`

**Solutions:**
```bash
# Clean install dependencies
rm -rf node_modules package-lock.json
npm install

# For specific module
npm install bootstrap react-bootstrap axios

# Check package.json has all dependencies
```

---

### Issue: API calls returning 404
**Error:** `404 Not Found` when calling API

**Solutions:**
1. Verify backend is running: `php spark serve`
2. Check API URL in `.env`:
   ```
   REACT_APP_API_URL=http://localhost:8080/api
   ```
3. Verify endpoint in backend routes
4. Check request method (GET, POST, etc.)

---

### Issue: Login token not persisting
**Error:** Token lost on page refresh

**Solutions:**
Check `src/pages/Login.js`:
```javascript
// Should save token to localStorage
localStorage.setItem('token', response.data.data.token);
// Should persist in App.js useEffect
const token = localStorage.getItem('token');
```

---

### Issue: Blank page or white screen
**Error:** React app shows white screen

**Solutions:**
1. Open browser console (F12)
2. Check for JavaScript errors
3. Verify index.html is being served
4. Check network requests
5. Try hard refresh: `Ctrl+Shift+R`

---

### Issue: Styling not applied
**Error:** Components render but CSS is missing

**Solutions:**
```bash
# Check Bootstrap import in src/index.js
import 'bootstrap/dist/css/bootstrap.min.css';

# Verify CSS files are in same directory as JS
# Check for CSS typos in class names
# Clear browser cache: Ctrl+Shift+Delete
```

---

## Database Issues

### Issue: Cannot connect to PostgreSQL
**Error:** `SQLSTATE[08006]` or connection refused

**Solutions:**
1. Check PostgreSQL is running
2. Verify credentials in .env
3. Use correct port (usually 5432)
4. Check firewall allows connections

```bash
# Test connection
psql -h localhost -U postgres -d hawk_db
```

---

### Issue: Foreign key constraint fails
**Error:** `ERROR: insert or update on table "teachers" violates foreign key`

**Solutions:**
```bash
# Ensure user exists in auth_user
INSERT INTO auth_user VALUES (1, 'test@example.com', ...);
-- Then insert teacher
INSERT INTO teachers VALUES (1, 1, 'University', 'Male', 2020);
```

---

### Issue: Data not persisting
**Error:** Data disappears after connection closes

**Solutions:**
1. Check AUTOCOMMIT is ON
2. Verify INSERT statements are working
3. Commit transaction: `COMMIT;`
4. Check file permissions on database directory

---

## API Testing Issues

### Issue: Postman returns authentication errors
**Error:** `401 Unauthorized` in Postman

**Solutions:**
1. Login first to get token
2. Copy token to Authorization header
3. Format: `Bearer <token>` (no quotes)
4. Check token not expired
5. Include `Content-Type: application/json`

---

### Issue: cURL request fails
**Error:** `Connection refused` or `Empty reply`

**Solutions:**
```bash
# Test backend is running
curl http://localhost:8080/

# Correct cURL syntax
curl -X POST http://localhost:8080/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"pass"}'
```

---

## Git Issues

### Issue: Git not found
**Error:** `git : The term 'git' is not recognized`

**Solutions:**
- Install Git from https://git-scm.com/download/
- Add to PATH
- Restart terminal

---

### Issue: Cannot push to GitHub
**Error:** `Authentication failed` or `permission denied`

**Solutions:**
```bash
# Use SSH instead of HTTPS
git remote set-url origin git@github.com:username/hawk.git

# Or use personal access token
# Generate at https://github.com/settings/tokens

# Clear Git credentials cache
git credential-manager uninstall  # Windows
```

---

### Issue: .env file committed to Git
**Error:** Sensitive data exposed in repository

**Solutions:**
```bash
# Remove .env from Git tracking
git rm --cached .env
git commit -m "Remove .env file from tracking"

# Update .gitignore
echo ".env" >> .gitignore
git add .gitignore
git commit -m "Add .env to .gitignore"

# Force push (careful!)
git push -u origin main
```

---

## Performance Issues

### Issue: Slow API responses
**Error:** API calls taking 5+ seconds

**Solutions:**
1. Check database queries in logs
2. Add indexes: `CREATE INDEX ...`
3. Check server resource usage
4. Monitor network requests
5. Profile code using browser DevTools

---

### Issue: React app slow to load
**Error:** App takes 10+ seconds to load

**Solutions:**
```bash
# Production build is faster
npm run build
# Serve build folder instead

# Check bundle size
npm install -g source-map-explorer
npm run build
source-map-explorer 'build/static/js/*.js'

# Code splitting
# Use React.lazy() for larger components
```

---

## Server Issues

### Issue: Cannot start Apache/Nginx
**Error:** Service failed to start

**Solutions:**
```bash
# Check configuration
apache2ctl configtest  # Apache
nginx -t               # Nginx

# Check logs
tail /var/log/apache2/error.log
tail /var/log/nginx/error.log

# Start service
systemctl start apache2
systemctl start nginx
```

---

## Memory & Resource Issues

### Issue: "Out of memory" error
**Error:** `PHP Fatal error: Out of memory`

**Solutions:**
```php
// Increase memory limit in php.ini
memory_limit = 512M

// Or in code
ini_set('memory_limit', '512M');
```

---

## SSL/Certificate Issues

### Issue: SSL certificate error
**Error:** `ERR_CERT_AUTHORITY_INVALID`

**Solutions:**
1. In development, ignore SSL warnings
2. In production:
   - Install valid SSL certificate
   - Use Let's Encrypt (free)
   - Update HTTPS URLs
   - Force HTTPS redirects

---

## Debugging Tips

### Enable Debug Mode

**Backend:**
```php
// app/Config/App.php
public bool $debug = true;

// Check logs
tail -f hawk-backend/writable/logs/log-*.log
```

**Frontend:**
```javascript
// Check browser console
F12 → Console tab
// Check Network tab for API calls
F12 → Network tab
// Use React DevTools extension
```

### Common Debug Commands

```bash
# Check what's listening on ports
netstat -tuln | grep LISTEN

# Check process status
ps aux | grep php
ps aux | grep node

# Check disk space
df -h

# Check memory usage
free -h  # Linux
vm_stat  # Mac
```

---

## Getting Help

If issue persists:

1. 📖 Check relevant documentation file
2. 🔍 Search error message online
3. 💻 Check browser console (F12)
4. 📊 Check server logs
5. 🐛 Review source code
6. 💬 Ask in development community

---

**Still stuck?** Reference the main [README.md](README.md) or check specific documentation files.

Last Updated: 2024
