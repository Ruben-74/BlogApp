<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

//Inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//Envoi du formulaire d'inscription
Route::post('/register', [RegisterController::class, 'register']);

//Connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//Envoi du formulaire de connexion 
Route::post('/login', [LoginController::class, 'login']);

//Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//page d'accueil de notre utilisateur 
Route::get('/home', [HomeController::class, 'index'])->name('home');

//Modification de mot de passe utilisateur 
Route::patch('/home', [HomeController::class, 'updatePassword'])->name('home');

// Affichage page accueil
Route::get('/', [PostController::class,'index'])->name('index');

// Afficher les post par category
Route::get('/categories/{category}', [PostController::class,'postsByCategory'])->name('posts.byCategory');

// Afficher les post par tag
Route::get('/tags/{tag}', [PostController::class,'postsByTag'])->name('posts.byTag');

// Afficher un post
Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');

//Ajouter un commentaire 
Route::post('/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');

//route qui permet de gerer le CRUD pour les posts au niveau Admin
Route::resource('/admin/posts', AdminController::class)->except('show')->names('admin.posts');