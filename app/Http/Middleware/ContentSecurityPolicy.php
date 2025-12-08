<?php

namespace App\Http\Middleware;

use Closure;

class ContentSecurityPolicy
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // Jika halaman tracking surat, izinkan eval untuk PDF.js
        if ($request->is('surat/*/tracking') || $request->is('pengajuan-surat/*')) {
            $response->headers->set(
                'Content-Security-Policy',
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com; object-src 'self';"
            );
        }
        
        return $response;
    }
}