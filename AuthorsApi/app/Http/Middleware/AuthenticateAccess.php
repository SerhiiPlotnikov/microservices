<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class AuthenticateAccess
{
    public function handle($request, Closure $next)
    {
        $validSecrets = explode(',', env('ACCEPTED_SECRETS'));
        if (in_array($request->header('Authorization'), $validSecrets)) {
            return $next($request);
        }

       throw new AuthenticationException();
    }
}