<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallAuthCommand extends Command
{
    protected $signature = 'auth:install';

    protected $description = 'Install the authentication views with your preferred CSS framework';

    public function handle(): void
    {
        $framework = $this->choice(
            'Which CSS framework would you like to use?',
            ['Tailwind CSS', 'Bootstrap', 'None (plain HTML)'],
            0
        );

        $this->info("Installing auth views with {$framework}...");

        match ($framework) {
            'Tailwind CSS'      => $this->installTailwind(),
            'Bootstrap'         => $this->installBootstrap(),
            'None (plain HTML)' => $this->installNone(),
        };

        // Limpiar build anterior
        $this->newLine();
        $this->line('  Cleaning previous build...');
        File::deleteDirectory(public_path('build'));
        $this->line('  ✓ Previous build cleaned');

        // Build assets automáticamente
        $this->line('  Building assets...');
        exec('npm install');
        exec('npm run build');
        $this->line('  ✓ Assets built');

        $this->newLine();
        $this->info('✅ Auth views installed successfully!');
        $this->newLine();
        $this->warn('⚠  If styles did not change, run manually:');
        $this->line('     npm run build');
        $this->newLine();
        $this->line('Next steps:');
        $this->line('  - Run: php artisan serve');
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

        File::copy(
            base_path("stubs/auth/{$framework}/layouts/guest.blade.php"),
            resource_path('views/components/layouts/guest.blade.php')
        );
    }
}
