#!/bin/bash

echo ""
echo "========================================"
echo "HAWK - Full Stack Application Setup"
echo "========================================"
echo ""

# Backend Setup
echo "[1/3] Setting up Backend..."
cd hawk-backend

# Check if PHP is available
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

# Copy environment file
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created. Please configure database settings."
fi

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install

if [ $? -ne 0 ]; then
    echo "Composer installation failed"
    exit 1
fi

# Run migrations
echo "Running database migrations..."
php spark migrate

# Create necessary directories
mkdir -p writable/session writable/logs

cd ..

# Frontend Setup
echo ""
echo "[2/3] Setting up Frontend..."
cd hawk-frontend

# Check if Node is available
if ! command -v node &> /dev/null; then
    echo "Node.js is not installed. Please install Node.js first."
    exit 1
fi

# Install Node dependencies
echo "Installing Node.js dependencies..."
npm install

if [ $? -ne 0 ]; then
    echo "NPM installation failed"
    exit 1
fi

cd ..

# Database setup
echo ""
echo "[3/3] Database Setup Complete"
echo ""
echo "========================================"
echo "Setup Summary"
echo "========================================"
echo ""
echo "Backend:  http://localhost:8080"
echo "Frontend: http://localhost:3000"
echo ""
echo "To start the application:"
echo ""
echo "1. Backend:  cd hawk-backend && php spark serve"
echo "2. Frontend: cd hawk-frontend && npm start"
echo ""
echo "Default Credentials:"
echo "Email: john@example.com"
echo "Password: password123"
echo ""
echo "========================================"
echo ""
