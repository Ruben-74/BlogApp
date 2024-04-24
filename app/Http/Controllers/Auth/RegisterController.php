<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    //Middleware qui empeche d'acceder a la route login une fois inscrit 
    public function __construct()
    {
        $this->middleware('guest');
    }

    //Montre le formulaire d'inscription 
    public function showRegistrationForm() : View { 
        
        return view('auth.register');
    }

    // Incrire un membre | Request permet de stocker ce que le membre va saisir dans le formulaire
    public function register(Request $request) : RedirectResponse
    { 
        //Pour se proteger du c surf (csrf) : a travers l'url faire des actions sur les tables sans permission
        //Eviter de faire des requetes get | transmettre un token a l'utilisateur qu'il devra le retransmettre s'il veut pouvoir effectuer son action
        
        
        //Validation du formulaire | regles de validation
        $validated = $request->validate([ //validate() valide dans un tableau passé directement 
            'name' => ['required', 'string', 'between:5,255'], //le champ est requis sinon ça renvoi une erreur
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string' , 'min:8', 'max:12','confirmed'], //'confirmed' permet de dire que ce champ password a un champs de confirmation les deux doivent matcher
        ], [ //Permet de modifier un message par defaut Laravel
            'password.min' => 'Pour des raisons de sécurité, votre mot de passe doit faire :min caractères au minimum.'
        ]);

        // on va crypter le mot de passe pour stocker dans notre bdd
        $validated['password'] = Hash::make($validated['password']);

        // on va creer notre utilisateur 
        $user = User::create($validated); //les valeurs sont verifés en amont (on valide avant d'utiliser le Mass Assignement create sinon faille de sécurité)

        // l'user est authentifié avec le compte passé en argument $user 
        Auth::login($user);

        //rediriger notre utilisateur sur ça page d'acceuil
        return redirect()->route('home')->withStatus('Inscription reussi !');

    }
}
