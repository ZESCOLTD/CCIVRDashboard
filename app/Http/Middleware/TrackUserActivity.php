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
            $userId = Auth::id();
            $expiresAt = now()->addMinutes(5);

            // Mark user as online
            Cache::put("user-is-online-{$userId}", true, $expiresAt);

            // Store last seen time
            Cache::put("last-seen-{$userId}", now(), $expiresAt);
        }

        return $next($request);
    }
}


