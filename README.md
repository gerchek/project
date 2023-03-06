<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel v9.16.0

## Зафиксированная версия PHP - 8.1.3

## СУБД - MariaDB

## Используемые модули

- Node 10.19.0
- npm 6.14.4

## Используемые laravel плагины
- SleepingOwl (ветка "dev-development")

## Применение миграций на сервере

/usr/bin/php8.1 artisan migrate

## Установка composer зависимостей

/usr/bin/php8.1 /usr/local/bin/composer install

#### Если лимита памяти не хватает на установку зависимостей
COMPOSER_MEMORY_LIMIT=-1 /usr/bin/php8.1 /usr/local/bin/composer install

## Очистка кэша на сервере

/usr/bin/php8.1 artisan cache:clear && 
/usr/bin/php8.1 artisan view:clear && 
/usr/bin/php8.1 artisan route:clear && 
/usr/bin/php8.1 artisan config:cache

## Для локальной разработки
php artisan cache:clear && php artisan config:cache && php artisan view:clear && php artisan route:clear
