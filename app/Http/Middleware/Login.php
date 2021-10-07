<?php
namespace App\Http\Middleware;
use Closure;
use Session;
class Login
{
    public function handle($request, Closure $next)
    {
        if(Session::has('Login')) {
            return $next($request);
        }
        else {
            return redirect()->route('login');
        }
    }
}