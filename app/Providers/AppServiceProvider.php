<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($rootUrl = config('app.url')) {
            URL::forceRootUrl(rtrim($rootUrl, '/'));
        }

        // Auto-creación de columnas de verificación para evitar errores en el servidor
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('user')) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('user', 'email_verified_at')) {
                    \Illuminate\Support\Facades\Schema::table('user', function ($table) {
                        $table->timestamp('email_verified_at')->nullable();
                    });
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('user', 'verification_token')) {
                    \Illuminate\Support\Facades\Schema::table('user', function ($table) {
                        $table->string('verification_token')->nullable();
                    });
                }
            }
            if (!\Illuminate\Support\Facades\Schema::hasTable('password_reset_tokens')) {
                \Illuminate\Support\Facades\Schema::create('password_reset_tokens', function ($table) {
                    $table->string('email')->primary();
                    $table->string('token');
                    $table->timestamp('created_at')->nullable();
                });
            }
        } catch (\Exception $e) {
            // Silenciar errores de conexión durante comandos de consola o antes de conectar la DB
        }
    }
}
