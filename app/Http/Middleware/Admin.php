<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->type_user == 1){
            $user = Auth::user();
            $request = $request->merge(['user' => $user]);
            //return $next($request);
            $urlIntended = Session::pull('url.intended', '/');
            return redirect()->to($urlIntended);
        } else {
           if(!Auth::check()){
                return redirect('/login');
           }
           return redirect()->back()->with('error', 'Você não tem privilégios para esta ação');
        }
    }
}
