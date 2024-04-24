<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //miidleware qui empeche l'acces au formulaire d'inscription une fois inscrit
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home.index');
    }

    public function updatePassword(Request $request) : RedirectResponse
    {
        $user = Auth::user(); // use($user) permet de charger $user au sein de la fonction 

        $validated = $request->validate([
            'current_password' => 
            [
                'required', 
                'string',  
                function (string $attribute, mixed $value, Closure $fail) use($user) {
                    if (! Hash::check($value , $user->password)) {
                        $fail("Le :attribute est erroné.");
                    }
                },
            ],
            
            'password' => ['required', 'string' , 'min:8','confirmed'],
        ]);

        // update() met a jour un champs d'une table ici password
        $user->update([
            
            'password'=> Hash::make($validated['password'])
        ]);

        return redirect()->route('home')->withStatus('Mot de passe modifié !');
    }
}