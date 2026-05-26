<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Redirect public path to public_html on Hostinger (production only).
        // On local development (Windows), keep the default 'public' folder.
        if (app()->environment('production') && !windows_os()) {
            $this->app->bind('path.public', function () {
                return base_path('public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix for `php artisan serve` on Windows.
        // Windows stores env vars with mixed-case names in $_ENV
        // (e.g. "SystemRoot", "Path", "windir") but Laravel's
        // ServeCommand passthrough list uses UPPERCASE versions.
        // Since PHP array keys are case-sensitive, the critical
        // vars don't match and get stripped from the subprocess,
        // causing "Failed to listen" errors.
        // The fix: copy the values into $_ENV under their UPPERCASE
        // keys so the passthrough matching works correctly.
        if (windows_os()) {
            $needed = [
                'SYSTEMROOT', 'PATH', 'WINDIR', 'COMSPEC',
                'TEMP', 'TMP', 'OS', 'PATHEXT',
                'APPDATA', 'LOCALAPPDATA', 'PROGRAMFILES',
                'COMPUTERNAME', 'USERPROFILE',
                'HOMEDRIVE', 'HOMEPATH',
                'NUMBER_OF_PROCESSORS', 'PROCESSOR_ARCHITECTURE',
            ];

            foreach ($needed as $key) {
                if (!isset($_ENV[$key])) {
                    $val = getenv($key);
                    if ($val !== false) {
                        $_ENV[$key] = $val;
                    }
                }
            }

            ServeCommand::$passthroughVariables = array_merge(
                ServeCommand::$passthroughVariables,
                $needed
            );
        }
    }
}
