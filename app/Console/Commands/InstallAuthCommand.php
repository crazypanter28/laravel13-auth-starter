<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallAuthCommand extends Command
{
    protected $signature = 'auth:install';

    protected $description = 'Install the authentication views and configure your preferred options';

    public function handle(): void
    {
        $this->info('');
        $this->info('Welcome to laravel13-auth-starter installer!');
        $this->info('');

        // Paso 1 — CSS Framework
        $framework = $this->choice(
            '1. Which CSS framework would you like to use?',
            ['Tailwind CSS', 'Bootstrap', 'None (plain HTML)'],
            0
        );

        // Paso 2 — OAuth
        $oauth = $this->confirm('2. Do you want to enable OAuth (GitHub and Google)?', true);

        // Paso 3 — 2FA
        $twoFactor = $this->confirm('3. Do you want to enable Two-Factor Authentication (2FA)?', true);

        // Paso 4 — Roles y permisos
        $roles = $this->confirm('4. Do you want to enable Roles & Permissions (Spatie)?', true);

        $this->info('');
        $this->info('Installing...');
        $this->info('');

        // Instalar CSS framework
        match ($framework) {
            'Tailwind CSS'      => $this->installTailwind(),
            'Bootstrap'         => $this->installBootstrap(),
            'None (plain HTML)' => $this->installNone(),
        };

        // Configurar OAuth
        $this->configureOAuth($oauth);

        // Configurar 2FA
        $this->configureTwoFactor($twoFactor);

        // Configurar roles y permisos
        $this->configureRoles($roles);

        // Actualizar .env.example
        $this->updateEnvExample($oauth);

        $this->info('');
        $this->info('✅ Installation complete!');
        $this->info('');

        // Resumen de configuración
        $this->line('Configuration summary:');
        $this->line('  CSS Framework : ' . $framework);
        $this->line('  OAuth         : ' . ($oauth ? 'enabled' : 'disabled'));
        $this->line('  2FA           : ' . ($twoFactor ? 'enabled' : 'disabled'));
        $this->line('  Roles & Permissions : ' . ($roles ? 'enabled' : 'disabled'));

        $this->info('');
        $this->warn('⚠  Run to apply styles:');
        $this->line('     npm run build');
        $this->info('');
        $this->line('Then:');
        $this->line('  - php artisan serve');
        $this->line('  - Open: http://localhost:8000');
    }

    private function installTailwind(): void
    {
        $this->copyStubs('tailwind');

        File::put(
            resource_path('css/app.css'),
            "@import 'tailwindcss';\n\n" .
                "@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';\n" .
                "@source '../../storage/framework/views/*.php';\n" .
                "@source '../**/*.blade.php';\n" .
                "@source '../**/*.js';\n"
        );

        File::put(resource_path('js/app.js'), "import './bootstrap';\n");

        $this->line('  ✓ Tailwind CSS views copied');
    }

    private function installBootstrap(): void
    {
        $this->copyStubs('bootstrap');

        File::put(resource_path('css/app.css'), "@import 'bootstrap/dist/css/bootstrap.min.css';\n");
        File::put(resource_path('js/app.js'), "import 'bootstrap';\n");

        $this->line('  Installing Bootstrap via npm...');
        exec('npm install bootstrap @popperjs/core');

        $this->line('  ✓ Bootstrap views copied');
        $this->line('  ✓ Bootstrap installed');
    }

    private function installNone(): void
    {
        $this->copyStubs('none');

        File::put(resource_path('css/app.css'), "/* Add your own styles here */\n");
        File::put(resource_path('js/app.js'), "import './bootstrap';\n");

        $this->line('  ✓ Plain HTML views copied');
    }

    private function configureOAuth(bool $enabled): void
    {
        $routesPath = base_path('routes/web.php');
        $content = File::get($routesPath);

        if ($enabled) {
            // Asegurarse que las rutas existen
            if (!str_contains($content, 'socialite.redirect')) {
                $oauthRoutes = "\n// OAuth Socialite\n" .
                    "Route::get('/auth/{provider}/redirect', [App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])\n" .
                    "    ->name('socialite.redirect');\n\n" .
                    "Route::get('/auth/{provider}/callback', [App\Http\Controllers\Auth\SocialiteController::class, 'callback'])\n" .
                    "    ->name('socialite.callback');\n";

                File::append($routesPath, $oauthRoutes);
            }
            $this->line('  ✓ OAuth routes enabled');
        } else {
            // Remover rutas de OAuth si existen
            $content = preg_replace('/\n\/\/ OAuth Socialite.*?->name\(\'socialite\.callback\'\);\n/s', '', $content);
            File::put($routesPath, $content);
            $this->line('  ✓ OAuth routes disabled');
        }
    }

    private function configureTwoFactor(bool $enabled): void
    {
        $stub = $enabled ? 'with-2fa' : 'without-2fa';

        File::copy(
            base_path("stubs/config/fortify.{$stub}.php"),
            config_path('fortify.php')
        );

        $this->line('  ✓ Two-factor authentication ' . ($enabled ? 'enabled' : 'disabled'));
    }

    private function updateEnvExample(bool $oauth): void
    {
        $envPath = base_path('.env.example');
        $content = File::get($envPath);

        $oauthBlock = "\n# GitHub OAuth\nGITHUB_CLIENT_ID=\nGITHUB_CLIENT_SECRET=\nGITHUB_REDIRECT_URI=http://localhost/auth/github/callback\n\n# Google OAuth\nGOOGLE_CLIENT_ID=\nGOOGLE_CLIENT_SECRET=\nGOOGLE_REDIRECT_URI=http://localhost/auth/google/callback\n";

        if ($oauth) {
            if (!str_contains($content, 'GITHUB_CLIENT_ID')) {
                File::append($envPath, $oauthBlock);
            }
            $this->line('  ✓ OAuth variables added to .env.example');
        } else {
            // Remover variables de OAuth
            $content = preg_replace('/\n# GitHub OAuth.*?GOOGLE_REDIRECT_URI=.*?\n/s', '', $content);
            File::put($envPath, $content);
            $this->line('  ✓ OAuth variables removed from .env.example');
        }
    }

    private function copyStubs(string $framework): void
    {
        $stubPath = base_path("stubs/auth/{$framework}");
        $viewPath = resource_path('views/auth');

        File::ensureDirectoryExists($viewPath);

        foreach (File::files($stubPath) as $file) {
            File::copy(
                $file->getPathname(),
                "{$viewPath}/{$file->getFilename()}"
            );
        }

        // Copiar layout
        File::copy(
            base_path("stubs/auth/{$framework}/layouts/guest.blade.php"),
            resource_path('views/components/layouts/guest.blade.php')
        );
    }

    private function configureRoles(bool $enabled): void
    {
        if ($enabled) {
            // Verificar si HasRoles ya está en el modelo
            $modelPath = app_path('Models/User.php');
            $content = File::get($modelPath);

            if (!str_contains($content, 'HasRoles')) {
                $content = str_replace(
                    'use HasFactory, Notifiable, TwoFactorAuthenticatable;',
                    'use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;',
                    $content
                );
                $content = str_replace(
                    'use Laravel\Fortify\TwoFactorAuthenticatable;',
                    "use Laravel\Fortify\TwoFactorAuthenticatable;\nuse Spatie\Permission\Traits\HasRoles;",
                    $content
                );
                File::put($modelPath, $content);
            }

            // Correr seeder
            $this->line('  Running roles seeder...');
            exec('php artisan db:seed --class=RolesAndPermissionsSeeder');
            $this->line('  ✓ Roles & Permissions enabled (admin, user)');
        } else {
            $this->line('  ✓ Roles & Permissions skipped');
        }
    }
}
