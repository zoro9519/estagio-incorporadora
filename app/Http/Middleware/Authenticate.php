<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $guardSelected = implode(";",Route::current()->middleware());

        if (! $request->expectsJson()) {
            
            return str_contains($guardSelected, 'admin') ? route('admin.auth') : route('user.auth');
        }
    }
}
