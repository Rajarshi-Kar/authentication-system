# Git Setup Guide

## Initialize Repository & Push to GitHub

### Step 1: Initialize Local Git Repository
```bash
cd HAWC
git init
git config user.name "Your Name"
git config user.email "your.email@example.com"
```

### Step 2: Add All Files
```bash
git add .
```

### Step 3: Create Initial Commit
```bash
git commit -m "Initial commit: HAWK - Full Stack Authentication System

- Backend: CodeIgniter 4 with JWT authentication
- Frontend: React with Bootstrap
- Database: MySQL/PostgreSQL with 1-to-1 user-teacher relationship
- Features: Register, Login, Profile Dashboard, Teachers Directory"
```

### Step 4: Create GitHub Repository

1. Go to [GitHub](https://github.com) and login
2. Click **New** button to create new repository
3. Name it: `hawk-authentication` (or your preferred name)
4. Add description: Full-Stack Authentication System with CodeIgniter & React
5. Choose **Public** for public repository
6. Click **Create repository**

### Step 5: Connect to Remote Repository
```bash
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/hawk-authentication.git
```

Replace `YOUR_USERNAME` with your GitHub username

### Step 6: Push to GitHub
```bash
git push -u origin main
```

### Step 7: Verify on GitHub

Visit `https://github.com/YOUR_USERNAME/hawk-authentication` to see your repository.

---

## Create Additional Branches (Optional)

### Development Branch
```bash
git checkout -b develop
git push -u origin develop
```

### Feature Branch
```bash
git checkout -b feature/add-teachers-edit
git push -u origin feature/add-teachers-edit
```

---

## Useful Git Commands

### Check Status
```bash
git status
```

### View Commit History
```bash
git log --oneline
```

### Add Specific Files
```bash
git add hawk-backend/
git add hawk-frontend/
git add database/
git add README.md
```

### Make New Commit
```bash
git commit -m "Description of changes"
```

### Push Changes
```bash
git push origin main
```

### Pull Latest Changes
```bash
git pull origin main
```

### Create & Switch to New Branch
```bash
git checkout -b new-feature-name
```

### Merge Branch
```bash
git checkout main
git merge feature-branch-name
```

---

## GitHub Repository Configuration

### Setup Branch Protection (Optional)
1. Go to Repository Settings
2. Click **Branches**
3. Add rule for `main` branch
4. Require pull request reviews
5. Dismiss stale reviews

### Add Topics
In repository settings, add topics:
- `authentication`
- `codeigniter`
- `reactjs`
- `jwt`
- `api`
- `full-stack`

### Add Repository Description
In repository settings, add:
**Description:** Full-Stack Authentication System - CodeIgniter 4 Backend + React Frontend with JWT Token-Based Auth

### Add Website Link (If hosting)
```
https://your-deployed-site.com
```

---

## Ignoring Files Already in Git

If you accidentally committed `.env` or `node_modules/`, remove them:

```bash
# Remove from git (without deleting local files)
git rm --cached .env
git rm -r --cached node_modules/

# Commit the removal
git commit -m "Remove sensitive files from tracking"

# Push changes
git push origin main
```

---

## Clone Repository Later

To clone this repository on another machine:

```bash
git clone https://github.com/YOUR_USERNAME/hawk-authentication.git
cd hawk-authentication
```

Then follow the installation steps in README.md

---

## Deployment Tips

### Before Pushing to Production

1. Update `.env` with production settings
2. Change `CI_ENVIRONMENT` to `production`
3. Update `JWT_SECRET_KEY` with a strong key
4. Test all APIs thoroughly
5. Run frontend build: `npm run build`

### Environment Secret Management

**Never commit:**
- `.env` file with real credentials
- API keys
- Database passwords
- JWT secret keys

**Use GitHub Secrets for CI/CD:**
1. Go to Repository Settings
2. Click **Secrets and variables** → **Actions**
3. Add secrets:
   - `DB_PASSWORD`
   - `JWT_SECRET_KEY`
   - `API_URL`

---

## Setting up CI/CD (Optional)

### GitHub Actions Example

Create `.github/workflows/test.yml`:
```yaml
name: Run Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '7.4'
    
    - name: Install dependencies
      run: cd hawk-backend && composer install
    
    - name: Run tests
      run: cd hawk-backend && php spark migrate
```

---

## Need Help?

- [GitHub Help](https://help.github.com)
- [Git Documentation](https://git-scm.com/doc)
- [Connect via SSH (recommended)](https://docs.github.com/en/authentication/connecting-to-github-with-ssh)
