# Laravel Admin Starter Kit

A production-minded Laravel starter kit for building authenticated admin panels quickly. It includes custom authentication flows, a Bootstrap 5 admin interface, role-based access control, profile management, database-backed settings, and feature test coverage.

## Features

- Custom login, registration, logout, email verification, forgot password, and reset password screens
- Protected admin dashboard with sidebar navigation, top bar, breadcrumbs, flash messages, and toast alerts
- User management with create, edit, delete, restore, force delete, status updates, search, filtering, pagination, and avatar upload
- Role and permission management powered by `spatie/laravel-permission`
- Profile management for account details, password updates, session cleanup, and account deletion
- Database-backed application settings for site name, branding, currency, timezone, and contact email
- Reusable Blade components for layouts, forms, breadcrumbs, headers, flash messages, and toasts
- Focused feature tests for authentication, profiles, settings, roles, permissions, and user management
- GitHub Actions workflow for automated test runs

## Tech Stack

- Laravel 13
- PHP 8.3+
- MySQL 8 or compatible MariaDB
- Bootstrap 5 Blade UI
- Vite
- PHPUnit 12
- Spatie Laravel Permission

## Requirements

Make sure these tools are installed before setting up the project:

- PHP 8.3 or newer
- Composer
- Node.js 20 or newer
- npm
- MySQL 8 or compatible MariaDB

## Installation

Clone the repository and install the backend dependencies:

```bash
composer install
```

Create your local environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Update `.env` with your database credentials, then run the migrations and seeders:

```bash
php artisan migrate --seed
```

Install frontend dependencies and build assets:

```bash
npm install
npm run build
```

## Local Development

Start the Laravel application:

```bash
php artisan serve
```

For frontend development with Vite:

```bash
npm run dev
```

The project also includes a Composer development command that starts the server, queue listener, and Vite together:

```bash
composer run dev
```

## Demo Accounts

After seeding, these accounts are available. Each uses the password `password`.

| Name | Email | Roles |
| --- | --- | --- |
| Admin User | `admin@example.com` | `super_admin`, `admin` |
| Reviewer User | `reviewer@example.com` | `reviewer` |
| Customer User | `customer@example.com` | `customer`, `user` |

## Useful Commands

```bash
php artisan migrate:fresh --seed
php artisan test
composer run test
npm run build
```

## Project Structure

| Path | Purpose |
| --- | --- |
| `app/Http/Controllers/Auth` | Authentication flow controllers |
| `app/Http/Controllers/Admin` | Admin dashboard, users, roles, permissions, settings, and profile controllers |
| `app/Http/Requests` | Form request validation |
| `app/Models` | User, role, permission, and setting models |
| `app/Policies` | Authorization policies |
| `app/Services/SettingService.php` | Settings persistence and lookup logic |
| `app/Support/helpers.php` | Global helper functions, including `setting()` |
| `database/migrations` | Database schema changes |
| `database/seeders` | Default roles, permissions, settings, and demo users |
| `resources/views/auth` | Authentication views |
| `resources/views/admin` | Admin panel views |
| `resources/views/components` | Shared Blade UI components |
| `tests/Feature` | Feature test coverage for core workflows |

## Authorization

Access control is built around roles and permissions. The default permissions include:

- `dashboard.view`
- `users.view`
- `users.create`
- `users.update`
- `users.delete`
- `roles.manage`
- `permissions.manage`
- `settings.manage`
- `profile.manage`

The `super_admin` and `admin` roles receive all permissions by default. Reviewer, customer, and user roles receive a smaller permission set suitable for limited access.

## Settings

Application settings are stored in the database and can be managed from the admin area by users with the `settings.manage` permission. Use the global helper to read settings in application code:

```php
setting('site_name', 'Starter Kit');
```

## Testing

Run the full test suite with:

```bash
php artisan test
```

Or use the Composer test script:

```bash
composer run test
```

The included GitHub Actions workflow runs tests against MySQL 8 on pushes to `main` and pull requests.

## Deployment Notes

Before deploying, make sure to:

- Configure production environment variables in `.env`
- Set `APP_ENV=production` and `APP_DEBUG=false`
- Run `composer install --no-dev --optimize-autoloader`
- Run `php artisan migrate --force`
- Build frontend assets with `npm run build`
- Cache configuration, routes, and views as appropriate for your hosting environment

## License

This project is open-sourced software licensed under the MIT license.
