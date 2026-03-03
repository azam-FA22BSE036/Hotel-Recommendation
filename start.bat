@echo off
echo Starting Hotel Recommendation System...
echo.
echo ---------------------------------------------------
echo Login Credentials:
echo Email: test@example.com
echo Password: password
echo ---------------------------------------------------
echo.
echo Starting Python Recommendation Server...
start "Hotel Recommendation Server" cmd /k ".\python-bin\python.exe server/app.py"

echo Starting Laravel Application...
echo Access the application at: http://localhost:8000
php artisan serve
