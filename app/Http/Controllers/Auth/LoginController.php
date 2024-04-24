<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    //Middleware qui empeche d'acceder a la route login une fois connecté 
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Bonne pratique a travers un constructeur mais il faut implementer les use use AuthorizesRequests, ValidatesRequests dans Controller.php pour lire les middlewares
        $this->middleware('auth')->only('logout');
        // except() va permettre de pouvoir utiliser la method se deconnecter sans nous rediriger en etant guest
        // only() va donner le role auth juste pour le logout afin de permettre la deconnexion
    }

    public function showLoginForm() : View
    {

        return view('auth.login');
    }

    // Connecter un membre
    public function Login(Request $request) : RedirectResponse
    {
        //Verification du formulaire de connexion
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required','string'],
        ]);

 
        if (Auth::attempt($credentials, (bool) $request->remenber )) { //si jamais la methode attempt renvoi true = authentifié | 
            // (bool) permet de convertir la valeur on en chaine de caractere en valeur boolean afin de creer le cookie remenber
            $request->session()->regenerate(); // on regenre son id de session 
 
            return redirect()->intended(RouteServiceProvider::HOME); // redirige vers la constante Home
        }
 
        return back()->withErrors([ // si jamais l'authentification a échoué on retourne vers la precedente url en creant une variable de session flash error
            'email' => 'Identifiants érronés',
        ])->onlyInput('email'); // on repeuplera seulement la valeur du champ email et pas le mdp en cas d'erreur (force l'user a remettre le mdp)

    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }


}

//Pour se deconnecter manuellement -> aller dans inspecter de Chrome
// - Onglet application -> Cookies -> localhost -> on supprime le cookie blogapp_session
