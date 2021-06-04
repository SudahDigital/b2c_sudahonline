<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$roles)
    {
        //return $next($request);
        if($request->user()->roles == $roles){
            return $next($request);
        }
        
        /*
        $role = $request->user()->roles ;
        $allowed_roles = array_slice(func_get_args(), 2);

        if( in_array($role, $allowed_roles) ) {
            return $next($request);
        }
        */

        /*
        if (!Auth::check()) // This isnt necessary, it should be part of your 'auth' middleware
         return redirect('/');

        $users = Auth::user();
        if($users->roles== $roles)
        return $next($request);
        */
    
  
        return redirect('/login'); 
    } 
        /*
        $user = \App\User::where('email', $request->email)->first();
        if (in_array($request->user()->roles, ['SALES']))
         {
            return redirect('/home_customer');
        } 
        else if(in_array($request->user()->roles, ['SUPERADMIN','ADMIN'])) {
            return redirect('/home');
        }*/
    
}
