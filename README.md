# Laravel React Auth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/your-vendor/laravel-react-auth.svg?style=flat-square)](https://packagist.org/packages/your-vendor/laravel-react-auth)
[![Total Downloads](https://img.shields.io/packagist/dt/your-vendor/laravel-react-auth.svg?style=flat-square)](https://packagist.org/packages/your-vendor/laravel-react-auth)
[![License](https://img.shields.io/github/license/your-vendor/laravel-react-auth?style=flat-square)](LICENSE)

A **Laravel package** that drops in a complete React + Inertia.js authentication system — login, register, and a protected dashboard — ready to install and customise.

---

## Features

-  Login page with remember-me
-  Register page with validation
-  Protected dashboard (Inertia.js)
- Session-based auth (no tokens needed)
- One-command install: `php artisan react-auth:install`
-  Fully publishable views, config, and migrations
- Tailwind CSS + React 18
- Toggle registration on/off via config

---

## Requirements

| Dependency | Version |
|---|---|
| PHP | ^8.1 |
| Laravel | ^10 or ^11 |
| Node.js | ^18 |
| inertiajs/inertia-laravel | ^1.0 |

---

## Installation

### 1 — Install via Composer

```bash
composer require your-vendor/laravel-react-auth
```

### 2 — Run the install command

```bash
php artisan react-auth:install
```

This publishes the config, React pages, and migrations.

### 3 — Run migrations

```bash
php artisan migrate
```

### 4 — Install JS dependencies and build

```bash
npm install
npm run dev
```

### 5 — Configure Inertia

Make sure your app uses the Inertia middleware. In `bootstrap/app.php` (Laravel 11) or `app/Http/Kernel.php` (Laravel 10):

```php
// Laravel 11 — bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \Inertia\Middleware::class,
    ]);
})
```

Set the root Blade view in `config/inertia.php`:

```php
'root_view' => 'app', // resources/views/app.blade.php
```

---

## Usage

Once installed, three routes are available:

| Route | URL | Name |
|---|---|---|
| Login | `/auth/login` | `react-auth.login` |
| Register | `/auth/register` | `react-auth.register` |
| Dashboard | `/auth/dashboard` | `react-auth.dashboard` |
| Logout | `POST /auth/logout` | `react-auth.logout` |

Visit `/auth/login` in your browser to get started.

---

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=react-auth-config
```

`config/react-auth.php`:

```php
return [
    'route_prefix'       => 'auth',            // URL prefix for all routes
    'user_model'         => \App\Models\User::class,
    'allow_registration' => true,              // set false to disable /register
    'middleware'         => ['web'],
];
```

---

## Customising the React pages

Publish the React components to your project:

```bash
php artisan vendor:publish --tag=react-auth-assets
```

Pages are copied to `resources/js/vendor/react-auth/pages/Auth/`:

```
resources/js/vendor/react-auth/
├── pages/
│   └── Auth/
│       ├── Login.jsx
│       ├── Register.jsx
│       └── Dashboard.jsx
└── components/
    └── InputField.jsx
```

Edit freely — the package will not overwrite them after publishing.

---

## Testing

```bash
composer test
```

The test suite covers login, register, logout, dashboard access, and validation.

---

## Changelog

See [CHANGELOG.md](CHANGELOG.md).

---

## Contributing

Pull requests are welcome. For major changes, please open an issue first.

---

## License

[MIT](LICENSE)
