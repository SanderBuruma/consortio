<?php

namespace App\Http\Middleware;

use Closure;
use App\Role;
use App\User;
use Illuminate\Foundation\Auth\User as Authenticable;
use Session;

class CheckRole 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $checkRole)
    {
        
        $saveCheckString = $checkRole."";

        $user = $request->user();
        if ($user->hasRole($user,$checkRole)) {
            return $next($request);
        };
        
        //error reporting
        $saveCheckString = preg_replace(['/\|/', '/\!/', '/\&/'], [" OR "," NOT:", " AND "], $saveCheckString);
        Session::flash('error', "role check failed, access denied. Roles $saveCheckString required");
        return redirect('/home');

    }
}
