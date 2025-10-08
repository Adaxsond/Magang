<?php
// app/Http/Middleware/RedirectIfAdmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika admin SUDAH login, alihkan ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        // Jika belum, lanjutkan ke halaman yang dituju (misal: halaman login)
        return $next($request);
    }
}