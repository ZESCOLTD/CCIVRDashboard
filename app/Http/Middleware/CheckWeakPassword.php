<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class CheckWeakPassword
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return $next($request);
        }

        $weakPasswords = Config::get('weak_passwords', [
            'password', '123456', '12345678', 'qwerty', 'letmein', 'admin123', 'abc123', 'welcome'
        ]);

        foreach ($weakPasswords as $weakPassword) {
            if (Hash::check($weakPassword, $user->password)) {
                session()->flash('warning', 'Your password is weak or compromised. Please change it.');
                return redirect()->route('password.change');
            }
        }

        return $next($request);
    }
}


