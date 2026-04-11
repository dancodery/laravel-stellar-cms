# Laravel Stellar CMS

A simple blog content management system built with Laravel.

## Current stack

- Laravel `13.4`
- PHP `8.3+`
- Vite `6`
- Bootstrap `5`
- Sanctum `4`
- PHPUnit `11`

## Features

- Authentication (login/register/logout)
- Create, edit, and delete posts
- Unique post titles enforced by validation/database constraints
- Comment creation on posts
- Authorization via Laravel Policies
- Request validation via Form Requests
- Basic XSS hardening by sanitizing user-provided post/comment content
- English UI and validation messages

## Requirements

- PHP `>= 8.3`
- Composer `>= 2`
- Node.js `>= 18`
- npm
- SQLite (default local setup in this repo)

## Installation

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

## Run locally

```bash
php artisan serve
npm run dev
```

Open: `http://127.0.0.1:8000`

## Build assets

```bash
npm run build
```

## Tests

```bash
php artisan test
```

## PHP version troubleshooting (macOS + Homebrew)

If `php artisan` fails with `Your Composer dependencies require a PHP version ">= 8.3.0"`:

```bash
brew unlink php@8.0
brew link php@8.3 --force --overwrite
php -v
```

The reported version must be `8.3.x` before running Artisan commands.
