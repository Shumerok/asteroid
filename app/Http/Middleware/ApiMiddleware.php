<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hazardous = $request->get('hazardous');
        if ($hazardous !== 'true' && $hazardous !== 'false' && $hazardous !== null){
            throw new \InvalidArgumentException('hazardous must be true or false you set: '.$hazardous);
        }
        return $next($request);
    }
}
