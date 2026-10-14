# Laravel React Auth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/leo76/laravel-react-auth.svg?style=flat-square)](https://packagist.org/packages/leo76/laravel-react-auth)
[![Total Downloads](https://img.shields.io/packagist/dt/leo76/laravel-react-auth.svg?style=flat-square)](https://packagist.org/packages/leo76/laravel-react-auth)
[![PHP Version](https://img.shields.io/packagist/php-v/leo76/laravel-react-auth?style=flat-square)](https://packagist.org/packages/leo76/laravel-react-auth)
[![License](https://img.shields.io/github/license/leo76/laravel-react-auth?style=flat-square)](LICENSE)

> A Laravel package that drops in a complete **React + Inertia.js** authentication system in minutes — login, register, and a protected dashboard, all ready to customise.

---

##  Features

| | |
|---|---|
| | Login with email, password & remember-me |
| | Register with validation & password confirmation |
| | Protected dashboard page |
| | Logout with session invalidation |
| | One-command install: `php artisan react-auth:install` |
| | Tailwind CSS + React 18 + Inertia.js |
| | Fully publishable views, config & migrations |
| | Toggle registration on/off via config |
| | Full PHPUnit feature test suite included |

---

##  Requirements

| Dependency | Version |
|---|---|
| PHP | `^8.1` |
| Laravel | `^10.0` or `^11.0` |
| Node.js | `^18` |
| inertiajs/inertia-laravel | `^1.0` |

---

##  Installation

### 1 — Install via Composer

```bash
composer require leo76/laravel-react-auth
```

### 2 — Run the install command

```bash
php artisan react-auth:install
```

This publishes the **config**, **React pages**, and **migrations** into your project.

### 3 — Run migrations

```bash
php artisan migrate
```

### 4 — Install JS dependencies and build

```bash
npm install
npm run dev
```

### 5 — Configure Inertia middleware

**Laravel 11** — `bootstrap/app.php` :

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \Inertia\Middleware::class,
    ]);
})
```

**Laravel 10** — `app/Http/Kernel.php` :

```php
protected $middlewareGroups = [
    'web' => [
        // ...
        \Inertia\Middleware::class,
    ],
];
```

Set the root Blade view in `config/inertia.php` :

```php
'root_view' => 'app',
```

---

##  Available Routes

| Method | URL | Route name | Access |
|---|---|---|---|
| `GET` | `/auth/login` | `react-auth.login` | Guest |
| `POST` | `/auth/login` | `react-auth.login.post` | Guest |
| `GET` | `/auth/register` | `react-auth.register` | Guest |
| `POST` | `/auth/register` | `react-auth.register.post` | Guest |
| `GET` | `/auth/dashboard` | `react-auth.dashboard` | Auth |
| `POST` | `/auth/logout` | `react-auth.logout` | Auth |

Visit `/auth/login` in your browser to get started.

---

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=react-auth-config
```

`config/react-auth.php` :

```php
return [

    // URL prefix for all routes → /auth/login, /auth/register ...
    'route_prefix' => env('REACT_AUTH_PREFIX', 'auth'),

    // Eloquent model used for authentication
    'user_model' => \App\Models\User::class,

    // Set to false to disable the /register page and endpoint
    'allow_registration' => env('REACT_AUTH_REGISTRATION', true),

    // Middleware applied to all package routes
    'middleware' => ['web'],

];
```

---

## Customising the React pages

```bash
php artisan vendor:publish --tag=react-auth-assets
```

Files are copied to :

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

Edit freely — the package will **never overwrite** published files.

---

##  Publish individually

```bash
php artisan vendor:publish --tag=react-auth-config       # Config only
php artisan vendor:publish --tag=react-auth-assets        # React pages + CSS
php artisan vendor:publish --tag=react-auth-migrations    # Migrations only
```

---

##  Testing

```bash
composer test
```

The test suite covers login, register, logout, dashboard access, validation, and the registration toggle.

---

##  Package Structure

```
laravel-react-auth/
├── composer.json
├── config/react-auth.php
├── routes/auth.php
├── src/
│   ├── LaravelReactAuthServiceProvider.php
│   ├── Console/InstallCommand.php
│   ├── Http/
│   │   ├── Controllers/AuthController.php
│   │   └── Middleware/RedirectIfAuthenticated.php
│   └── database/migrations/
├── resources/
│   ├── views/app.blade.php
│   ├── css/app.css
│   └── js/
│       ├── app.jsx
│       ├── components/InputField.jsx
│       └── pages/Auth/
│           ├── Login.jsx
│           ├── Register.jsx
│           └── Dashboard.jsx
└── tests/Feature/AuthTest.php
```

---

##  Changelog

See [CHANGELOG.md](CHANGELOG.md) for recent changes.

---

##  Contributing

Pull requests are welcome! For major changes, please open an issue first.

1. Fork the repository
2. Create your branch: `git checkout -b feature/my-feature`
3. Commit: `git commit -m 'feat: add my feature'`
4. Push: `git push origin feature/my-feature`
5. Open a Pull Request

---

## 📄 License

The MIT License (MIT). See [LICENSE](LICENSE) for more information.

---

Made with ❤️ for the Laravel community
