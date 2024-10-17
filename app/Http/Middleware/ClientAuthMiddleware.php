<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// app/Http/Middleware/ClientAuthMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('client')->check()) {
            return $next($request);
        }

        return redirect()->route('client.login');
    }
}

