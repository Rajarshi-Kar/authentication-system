# Deployment Guide

Guide for deploying HAWK to production servers.

## Table of Contents
1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Backend Deployment](#backend-deployment)
3. [Frontend Deployment](#frontend-deployment)
4. [Environment Setup](#environment-setup)
5. [Database Migration](#database-migration)
6. [SSL/HTTPS Setup](#ssltls-setup)
7. [Monitoring](#monitoring)

---

## Pre-Deployment Checklist

- [ ] All tests passing
- [ ] Environment variables configured
- [ ] Database backups created
- [ ] SSL certificates obtained
- [ ] Domain DNS configured
- [ ] Server resources verified
- [ ] Firewall rules set
- [ ] Email configuration ready

---

## Backend Deployment

### Option 1: Linux Server with Apache

#### 1. Clone Repository
```bash
cd /var/www
git clone https://github.com/your-username/hawk-authentication.git
cd hawk-authentication/hawk-backend
```

#### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

#### 3. Configure Environment
```bash
cp .env.example .env
nano .env
```

Set production values:
```
CI_ENVIRONMENT=production
database.default.hostname=<your-db-host>
database.default.database=hawk_production
database.default.username=<db-user>
database.default.password=<strong-password>
JWT_SECRET_KEY=<long-random-secret>
```

#### 4. Set File Permissions
```bash
chown -R www-data:www-data /var/www/hawk-authentication
chmod -R 755 /var/www/hawk-authentication
chmod -R 775 /var/www/hawk-authentication/writable
```

#### 5. Configure Apache VirtualHost
```apache
<VirtualHost *:80>
    ServerName api.yourdomain.com
    DocumentRoot /var/www/hawk-authentication/hawk-backend/public

    <Directory /var/www/hawk-authentication/hawk-backend/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted

        # Rewrite Rules for CodeIgniter
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^ index.php [L]
        </IfModule>
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/hawk_error.log
    CustomLog ${APACHE_LOG_DIR}/hawk_access.log combined
</VirtualHost>
```

#### 6. Enable Required Modules
```bash
a2enmod rewrite
a2enmod headers
a2enmod ssl
systemctl restart apache2
```

---

### Option 2: Linux Server with Nginx

#### 1. Nginx Configuration
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name api.yourdomain.com;

    root /var/www/hawk-authentication/hawk-backend/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    access_log /var/log/nginx/hawk_access.log;
    error_log /var/log/nginx/hawk_error.log;
}
```

#### 2. Test Configuration
```bash
nginx -t
systemctl restart nginx
```

---

## Frontend Deployment

### Option 1: Static Hosting (Netlify/Vercel)

#### 1. Build React App
```bash
cd hawk-frontend
npm run build
```

#### 2. Deploy to Netlify
```bash
npm install -g netlify-cli
netlify deploy --prod --dir=build
```

Or manually upload `build/` folder.

#### 3. Configure Environment
Create `public/_redirects`:
```
/* /index.html 200
```

---

### Option 2: Traditional Web Server

#### 1. Build App
```bash
cd hawk-frontend
npm run build
```

#### 2. Upload to Server
```bash
scp -r build/* user@your-server:/var/www/hawk-frontend/
```

#### 3. Apache Configuration
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/hawk-frontend

    <Directory /var/www/hawk-frontend>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted

        # Redirect all requests to index.html
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} -f [OR]
            RewriteCond %{REQUEST_FILENAME} -d
            RewriteRule ^ - [L]
            RewriteRule ^ index.html [QSA,L]
        </IfModule>
    </Directory>
</VirtualHost>
```

---

## Environment Setup

### Backend Environment Variables

**Production `.env`:**
```bash
CI_ENVIRONMENT=production
encryption.key=<base64-encoded-32-chars>
database.default.hostname=<production-db-host>
database.default.database=hawk_prod
database.default.username=<secure-username>
database.default.password=<very-strong-password>
database.default.DBDriver=MySQLi  # or Postgre
JWT_SECRET_KEY=<very-long-random-secret>
JWT_ALGORITHM=HS256
CSPEnabled=true
allow_cors=true
cors_allowed_origins=https://yourdomain.com
```

### Frontend Environment Variables

**Production `.env`:**
```bash
REACT_APP_API_URL=https://api.yourdomain.com/api
REACT_APP_ENV=production
```

---

## Database Migration

### 1. Backup Current Database
```bash
mysqldump -u root -p hawk_db > hawk_db_backup_$(date +%Y%m%d).sql
```

### 2. Create Production Database
```sql
CREATE DATABASE hawk_production;
CREATE USER 'hawk_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON hawk_production.* TO 'hawk_user'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Import Schema
```bash
mysql -u hawk_user -p hawk_production < database/hawk_db_mysql.sql
```

### 4. Run Migrations
```bash
cd hawk-backend
php spark migrate --database production
```

---

## SSL/TLS Setup

### Using Let's Encrypt (Free)

#### Apache
```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d api.yourdomain.com -d yourdomain.com
```

#### Nginx
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d api.yourdomain.com -d yourdomain.com
```

#### Auto-Renewal
```bash
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

### Force HTTPS

**Backend (.htaccess):**
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

**Nginx:**
```nginx
server {
    listen 80;
    server_name api.yourdomain.com;
    return 301 https://$server_name$request_uri;
}
```

---

## Performance Optimization

### Backend

1. **Enable Caching**
   ```php
   // app/Config/Cache.php
   public $default = 'redis';
   ```

2. **Database Optimization**
   ```sql
   CREATE INDEX idx_auth_email ON auth_user(email);
   CREATE INDEX idx_teacher_user ON teachers(user_id);
   ```

3. **Gzip Compression**
   ```apache
   <IfModule mod_deflate.c>
       AddOutputFilterByType DEFLATE text/plain
       AddOutputFilterByType DEFLATE text/html
       AddOutputFilterByType DEFLATE application/json
   </IfModule>
   ```

### Frontend

1. **Enable Service Worker**
   ```bash
   npm install workbox-cli
   ```

2. **Browser Caching**
   ```apache
   <FilesMatch "\.(jpg|jpeg|png|gif|css|js|woff|woff2)$">
       Header set Cache-Control "max-age=31536000, public"
   </FilesMatch>
   ```

---

## Monitoring & Logging

### Backend Logs
```bash
tail -f /var/www/hawk-authentication/hawk-backend/writable/logs/log-*.log
```

### Server Monitoring
```bash
# System resources
top
htop
df -h

# Network connections
netstat -tuln | grep :8080
netstat -tuln | grep :80

# Process status
systemctl status apache2
systemctl status nginx
systemctl status php8.1-fpm
```

### Error Tracking
Set up error monitoring with:
- Sentry
- Rollbar
- New Relic
- DataDog

---

## Security Hardening

### 1. Firewall Rules
```bash
# UFW (Ubuntu)
ufw allow 22/tcp      # SSH
ufw allow 80/tcp      # HTTP
ufw allow 443/tcp     # HTTPS
ufw enable
```

### 2. SSH Hardening
```bash
# /etc/ssh/sshd_config
PermitRootLogin no
PasswordAuthentication no
PubkeyAuthentication yes
Port 2222  # Change default port
```

### 3. Database Security
- Use strong passwords
- Limit database user permissions
- Enable binary logging
- Regular backups

### 4. Application Security
- Keep dependencies updated: `composer update`, `npm update`
- Use environment-based secrets
- Enable HTTPS everywhere
- Regular security audits

---

## Backup & Recovery

### Automated Backups
```bash
#!/bin/bash
# /usr/local/bin/backup-hawk.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/hawk"

# Database backup
mysqldump -u hawk_user -p$DB_PASSWORD hawk_production > $BACKUP_DIR/db_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz /var/www/hawk-authentication

# Cleanup old backups (keep 30 days)
find $BACKUP_DIR -name "*.sql" -o -name "*.tar.gz" -mtime +30 -delete
```

Schedule with cron:
```bash
0 2 * * * /usr/local/bin/backup-hawk.sh
```

---

## Deployment Checklist

- [ ] Code pushed to production branch
- [ ] Environment variables configured
- [ ] Database migrated and tested
- [ ] SSL certificates installed
- [ ] Firewall configured
- [ ] Backups created
- [ ] Monitoring enabled
- [ ] DNS records updated
- [ ] Health checks configured
- [ ] Team notified

---

## Rollback Plan

If issues occur:

```bash
# Backup current production
git tag release-v1.0-rollback

# Rollback to previous version
git checkout previous-version
composer install --no-dev
npm install
npm run build

# Restart services
systemctl restart apache2
systemctl restart php8.1-fpm
```

---

## Production Support

- Monitor logs regularly
- Set up alerts for errors
- Have incident response plan
- Document all changes
- Maintain detailed runbooks
- Keep contact information updated

---

For questions, refer to the main [README.md](README.md) file.
