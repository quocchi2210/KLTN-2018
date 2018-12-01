<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStore
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
        if (Auth::check()){
            $user = Auth::user();
            if ($user && $user->roleId == 1)
            {
                return $next($request);

            }
            else{
                Auth::logout();
                return response()->view('handleError.unauthorized',['role' => 'Owner Store']);
            }
        }
        return redirect('store/login');
    }
}
