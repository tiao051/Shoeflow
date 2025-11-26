@echo off
title Khoi dong SHOES-DELREY
echo Dang khoi dong he thong...

:: 1. Chạy Laravel Server ở cổng 8000
start "Laravel Web" php artisan serve

:: 2. Chạy Reverb Server (WebSocket)
start "Laravel Reverb" php artisan reverb:start

:: 3. Chạy Vite (Frontend assets)
start "Vite Dev" npm run dev

echo Da bat xong!.
timeout /t 3
exit