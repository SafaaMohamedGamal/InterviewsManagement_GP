<?php

namespace App\Http\Middleware;

use Closure;

class VerifyPhone
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
        $seeker = $request->user()->userable;
        if (! $seeker->isVerified) {
            return  response()->json(['error' => 'Your Phone Number is not verified.'], 400);
        }
        return $next($request);
    }
}
