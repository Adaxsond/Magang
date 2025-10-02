<?php

namespace App\Providers;

use App\Models\Admin; // <-- TAMBAHKAN INI
use Illuminate\Support\Facades\Gate; // <-- TAMBAHKAN INI
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
        // Definisikan Gate untuk 'manage-admins' di sini
        // Gate ini akan mengembalikan true HANYA JIKA role user adalah 'superadmin'
        Gate::define('manage-admins', function (Admin $admin) {
            return $admin->role === 'superadmin';
        });
    }
}