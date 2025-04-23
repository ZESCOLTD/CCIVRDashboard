<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(5);
            Cache::put('user-is-online-' . Auth::id(), true, $expiresAt);
        }
        return $next($request);
    }

    protected $middlewareGroups = [
        'web' => [
            // ... other middleware
            \App\Http\Middleware\TrackUserActivity::class,
        ],
    ];
}

