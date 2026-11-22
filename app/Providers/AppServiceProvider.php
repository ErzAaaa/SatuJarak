<?php

namespace App\Providers;

use App\Listeners\LimitAdminSessions;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
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
     *
     * Mendaftarkan LimitAdminSessions agar setiap kali admin berhasil
     * login, jumlah sesi aktifnya dibatasi maksimal 2 sesi. Sesi lama
     * yang melebihi batas akan otomatis dihapus.
     */
    public function boot(): void
    {
        if ($this->app->environment('production') || isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL'])) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Event::listen(Login::class, LimitAdminSessions::class);
    }
}
