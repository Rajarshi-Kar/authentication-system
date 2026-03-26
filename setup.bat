@echo off
echo.
echo ========================================
echo HAWK - Full Stack Application Setup
echo ========================================
echo.

REM Backend Setup
echo [1/3] Setting up Backend...
cd hawk-backend

REM Check if PHP is available
php -v >nul 2>&1
if errorlevel 1 (
    echo PHP is not installed or not in PATH
    echo Please install PHP and add it to your system PATH
    pause
    exit /b 1
)

REM Copy environment file
if not exist .env (
    copy .env.example .env
    echo .env file created. Please configure database settings.
)

REM Install PHP dependencies
echo Installing PHP dependencies...
call composer install

if errorlevel 1 (
    echo Composer installation failed
    pause
    exit /b 1
)

REM Run migrations
echo Running database migrations...
php spark migrate

REM Create necessary directories
if not exist writable (
    mkdir writable
)
if not exist writable\session (
    mkdir writable\session
)
if not exist writable\logs (
    mkdir writable\logs
)

cd ..

REM Frontend Setup
echo.
echo [2/3] Setting up Frontend...
cd hawk-frontend

REM Check if Node is available  
node -v >nul 2>&1
if errorlevel 1 (
    echo Node.js is not installed or not in PATH
    echo Please install Node.js
    pause
    exit /b 1
)

REM Install Node dependencies
echo Installing Node.js dependencies...
call npm install

if errorlevel 1 (
    echo NPM installation failed
    pause
    exit /b 1
)

cd ..

REM Database setup
echo.
echo [3/3] Database Setup Complete
echo.
echo ========================================
echo Setup Summary
echo ========================================
echo.
echo Backend:  http://localhost:8080
echo Frontend: http://localhost:3000
echo.
echo To start the application:
echo.
echo 1. Backend:  cd hawk-backend ^&^& php spark serve
echo 2. Frontend: cd hawk-frontend ^&^& npm start
echo.
echo Default Credentials:
echo Email: john@example.com
echo Password: password123
echo.
echo ========================================
echo.
pause
