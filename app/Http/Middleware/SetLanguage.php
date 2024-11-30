<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the 'Accept-Language' header, default to 'en' if not provided
        $lang = $request->header('Accept-Language', 'en');
        
        // Set the application's locale based on the header value
        app()->setLocale($lang);

        // Proceed to the next middleware or controller
        return $next($request);
    }
}
