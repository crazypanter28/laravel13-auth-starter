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
## Choose your CSS framework

After cloning, run the install command and choose your preferred framework:

```bash
php artisan auth:install
```

Options:
- **Tailwind CSS** — default, included out of the box
- **Bootstrap** — installs Bootstrap 5 automatically
- **None** — plain HTML, bring your own styles

You can switch frameworks anytime by running the command again.

## Wizard installer

The `auth:install` command is a full setup wizard:

```bash
php artisan auth:install
```

It will ask you:

1. **CSS framework** — Tailwind CSS, Bootstrap, or None
2. **OAuth** — Enable GitHub and Google login
3. **2FA** — Enable Two-Factor Authentication (TOTP)

Everything is configured automatically based on your choices.

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

## Testing email in local development

By default this starter uses the `log` driver for mail — no email server needed.

In your `.env` make sure you have:

```env
MAIL_MAILER=log
```

After requesting a password reset, find the link in:

storage/logs/laravel.log

Search for `reset-password` — copy the full URL and paste it in your browser.

For production change `MAIL_MAILER` to `smtp`, `mailgun`, `ses`, or any driver Laravel supports.

## Contributing

PRs and issues are welcome. Please open an issue first to discuss what you'd like to change.

This project follows [Semantic Versioning](https://semver.org/).

---

## License

MIT