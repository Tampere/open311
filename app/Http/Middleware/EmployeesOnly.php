<?php

namespace App\Http\Middleware;

use Closure;

class EmployeesOnly
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
        if($request->user()->isModerator()) {
            return $next($request);
        }

        return redirect('login');
    }
}
