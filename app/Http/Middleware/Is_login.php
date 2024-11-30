<?php

namespace App\Http\Middleware;

use Closure;

class Is_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
        if (auth('api')->check()) {
            return $next($request);
        }
        $response = ['success' => false, 'message' =>__('You need to login first'),'code'=>400];
        if (!empty($errorMessages))
            $response['data'] = $errorMessages;
        return response()->json($response , 200);
      }
    
        
        
        
    
    
}