# laravel13-auth-starter

A minimal, ready-to-use authentication starter for Laravel 13 using Fortify, Livewire 3, and Tailwind CSS.

> **Honest note:** This starter uses Laravel Fortify as the auth engine. Once Laravel Breeze or Jetstream officially support Laravel 13, we'll evaluate migrating. PRs and issues are welcome.

---

## Stack

- Laravel 13
- Laravel Fortify
- Livewire 3
- Tailwind CSS 4
- SQLite (default) — MySQL/PostgreSQL also supported

---

## What's included (v0.0.1)

- Login
- Registration
- Forgot password
- Reset password
- Email verification

## What's NOT included (yet)

- OAuth / Social login → v0.2
- Two-factor authentication → v0.3
- Role & permissions → v0.4

---

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+

---

## Getting started

```bash
git clone https://gitlab.com/alonso.montiel/laravel13-auth-starter.git my-project
cd my-project
cp .env.example .env
composer install
npm install
php artisan key:generate
php artisan migrate
npm run dev
```

Open http://localhost:8000 in your browser.

---

## Switching to MySQL

In your `.env` file, replace:

```env
DB_CONNECTION=sqlite
```

With:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Then run:

```bash
php artisan migrate:fresh
```

---

## Contributing

PRs and issues are welcome. Please open an issue first to discuss what you'd like to change.

This project follows [Semantic Versioning](https://semver.org/).

---

## License

MIT