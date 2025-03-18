<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Tambahkan header keamanan yang diperlukan
        $response->headers->set('X-XSS-Protection', '1; mode=block');  // Melindungi dari XSS
        $response->headers->set('X-Content-Type-Options', 'nosniff');  // Mencegah MIME-sniffing
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');      // Melindungi dari Clickjacking
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains'); // Paksa HTTPS (opsional)

        return $response;
    }
}
