// app/Http/Kernel.php
protected $routeMiddleware = [
    // ... middleware lainnya
    'admin' => \App\Http\Middleware\AdminAuthenticated::class, // <-- Tambahkan ini
];