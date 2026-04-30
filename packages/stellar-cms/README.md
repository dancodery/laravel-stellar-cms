# Stellar CMS (Laravel Package)

This folder contains the reusable **Stellar CMS blog** as a Laravel package.

## Install in another Laravel app

### Option A: as a real Composer package (recommended)

1. Put this package in its own git repository (or split it out with subtree).
2. Set the package `name` in `packages/stellar-cms/composer.json` (currently `stellar/stellar-cms`).
3. Install it in your target app:

```bash
composer require stellar/stellar-cms
php artisan migrate
```

### Option B: path repository (local dev)

In your target app `composer.json`:

```json
{
  "repositories": [
    { "type": "path", "url": "../laravel-stellar-cms/packages/stellar-cms", "options": { "symlink": true } }
  ],
  "require": {
    "stellar/stellar-cms": "*"
  }
}
```

Then:

```bash
composer update stellar/stellar-cms
php artisan migrate
```

## Configuration / Publishing

```bash
php artisan vendor:publish --tag=stellar-cms-config
php artisan vendor:publish --tag=stellar-cms-views
php artisan vendor:publish --tag=stellar-cms-migrations
```

Default routes:

- Public blog index: `/blog`
- Public post: `/blog/{slug}`
- Authenticated CRUD: `/blog/posts/*`

Adjust `route_prefix`, middleware and layout in `config/stellar-cms.php`.

