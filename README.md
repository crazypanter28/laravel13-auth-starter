# laravel13-auth-starter

A minimal, ready-to-use authentication starter for Laravel 13 using Fortify, Livewire 3, and Tailwind CSS.

> **Honest note:** This starter uses Laravel Fortify as the auth engine. Once Laravel Breeze or Jetstream officially support Laravel 13, we'll evaluate migrating. PRs and issues are welcome.

---

## Stack

- Laravel 13
- Laravel Fortify
- Livewire 3
- Tailwind CSS 4 (default)
- Bootstrap 5 (optional via wizard)
- Laravel Socialite (optional via wizard)
- Spatie Laravel Permission (optional via wizard)
- SQLite (default) — MySQL/PostgreSQL also supported

---

## What's included

| Feature | Version |
|---------|---------|
| Login, Registration, Forgot/Reset password | v0.0.1 |
| OAuth — GitHub and Google | v0.2.0 |
| CSS framework selector (Tailwind, Bootstrap, None) | v0.3.0 |
| Two-Factor Authentication (TOTP) | v0.4.0 |
| Roles & Permissions (Spatie) | v0.5.0 |

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
php artisan auth:install
npm run build
php artisan serve
```

Open http://localhost:8000 in your browser.

---

## Wizard installer

The `auth:install` command is a full setup wizard:

```bash
php artisan auth:install
```

It will ask you:

1. **CSS framework** — Tailwind CSS, Bootstrap, or None
2. **OAuth** — Enable GitHub and Google login
3. **2FA** — Enable Two-Factor Authentication (TOTP)
4. **Roles & Permissions** — Enable Spatie roles (admin, user)

Everything is configured automatically based on your choices.

---

## OAuth local development note

Google OAuth does not accept `.test` domains. For local testing use:

```env
GOOGLE_REDIRECT_URI=http://127.0.0.1:80/auth/google/callback
```

Or use [ngrok](https://ngrok.com) to expose your local app with a public domain.

GitHub OAuth works fine with `.test` domains.

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
php artisan db:seed --class=RolesAndPermissionsSeeder
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

---

## Contributing

PRs and issues are welcome. Please open an issue first to discuss what you'd like to change.

This project follows [Semantic Versioning](https://semver.org/).

---

## License

MIT