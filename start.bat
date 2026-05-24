@echo off
title Thomas Apartment - Starting System...
color 0A

echo =========================================
echo   Thomas Apartment Management System
echo =========================================
echo.
echo [0/5] Stopping any old PHP processes...
taskkill /F /IM php.exe >nul 2>&1
timeout /t 1 /nobreak >nul

echo [1/5] Clearing view cache...
php artisan view:clear

echo [2/5] Clearing route cache...
php artisan route:clear

echo [3/5] Clearing config cache...
php artisan config:clear

echo [4/5] Clearing application cache...
php artisan cache:clear

echo [5/5] Starting server...
echo.
echo =========================================
echo   Server running at: http://127.0.0.1:8000
echo   Press Ctrl+C to stop the server
echo =========================================
echo.

php artisan serve --port=8000
pause
