<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        //verifie si la personne est bien authentifié et (&&) possede le role admin
        if (Auth::check() && Auth::user()->isAdmin()) { //retourne true ou false
     
            return $next($request);
        }

        return redirect(RouteServiceProvider::HOME);
    }

    //Ajouter ce middleware dans le Kernel pour etre pris en compte 
}
