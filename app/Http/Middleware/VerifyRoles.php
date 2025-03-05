<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class VerifyRoles
{
    public function handle($request, Closure $next, ...$roles)
{
    if (!Session::has('user_role')) {
        return redirect('login');
    }

    $userRole = Session::get('user_role');
    
    if ($userRole === 'Super Admin') {
        return $next($request);
    }
    
    if (!in_array($userRole, $roles)) {
        return redirect()->route('unauthorized');
    }

    return $next($request);
}
}