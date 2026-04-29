@echo off
title Iniciando Laravel con Docker

echo ========================================
echo Iniciando Laravel con Docker
echo ========================================

echo [1/6] Deteniendo contenedores existentes...
docker-compose down -v
timeout /t 2 /nobreak >nul

echo [2/6] Limpiando cache de Docker...
docker system prune -f
timeout /t 2 /nobreak >nul

echo [3/6] Construyendo imagen Docker...
docker-compose build --no-cache
if %errorlevel% neq 0 (
    echo Error en la construccion
    pause
    exit /b 1
)

echo [4/6] Iniciando contenedor...
docker-compose up -d
if %errorlevel% neq 0 (
    echo Error al iniciar contenedor
    pause
    exit /b 1
)

echo [5/6] Esperando que el contenedor este listo...
timeout /t 10 /nobreak >nul

echo [6/6] Configurando la aplicacion...
docker exec laravel_app cp .env.docker .env 2>nul
docker exec laravel_app php artisan key:generate
docker exec laravel_app php artisan config:clear
docker exec laravel_app php artisan cache:clear
docker exec laravel_app php artisan view:clear
docker exec laravel_app php artisan storage:link || echo "Storage link issue, but continuing"
docker exec laravel_app php artisan migrate --force || echo "Migration may have issues, check database connection"

echo.
echo ========================================
echo PROYECTO INICIADO
echo ========================================
echo.
echo Acceso local: http://localhost:8080
echo Acceso red: http://192.168.18.23:8080
echo.
echo Para detener: docker-compose down
echo Para ver logs: docker logs laravel_app
echo ========================================
pause