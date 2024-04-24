<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminController extends Controller // pour creer toutes les methodes direnctement : php artisan make:controller AdminController --resource --model=Post
{

    public function __construct()
    {
        $this->middleware('admin'); 
    }

    /**
     * ----------------AFFICHAGE POSTS ------------------------------
     */
    public function index() : View
    {
        return view('admin.posts.index', [
            'posts' => Post::without('category', 'tags')->latest()->get(),//désactiver le EAGER LOADING chargement par defaut de la method with ['categorie' , 'tags'] dans le model Post
        ]);
    }

    protected function showForm(Post $post = new Post) : View //sert a afficher un nouveau post ou un post edité
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(), //sa va creer une collection manipulable par la variable $categories par ordre alphabetique 
            'tags'=> Tag::orderBy('name')->get(), 
        ]);
    }

    /**
     * Show : Affichage du formulaire .
     */
    public function create() : View
    {
        return $this->showForm();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return $this->showForm($post);
    }

    /*--------------------------------------------------------------------*/

    /**
     * ------------------ CREATION / MISE A JOUR POSTS ------------------------------
     */

    //on passe un post en parametre ou sinon elle sera null en cas d'enregistrement pour la premiere fois
    protected function save(array $data, Post $post = null) : RedirectResponse //sert a la creation mais aussi a la maj
    {
        // on souhaite pas obliger l'user de changer une image dans une edition
       if (isset($data['thumbnail'])) { //si j'ai une valeur qui correspond dans le tableau data à la clé thumbnail (si oui une image a été passé par l'user)
             
            //si le post passé en parametre instancié a edité existe sinon il a la valeur null et rentre pas dans le if (cas de la creation)
            if (isset($post->thumbnail)) { 
                //on rentre que si j'ai une mise a jour et il existe une valeur image
                Storage::delete($post->thumbnail);
            }
            $data['thumbnail'] = $data['thumbnail']->store('thumbnails'); // enregistre le chemin de l'image stocké dans storage/app/public 
       
    }
        
        $data['excerpt'] = Str::limit($data['content'], 150); //on extrait 150 caractere du champ content pour l'affecter au champ excerpt
        
        //updateOrCreate va identifé si le post passé posséde un id (maj) sinon il va creer le post
        $post = Post::updateOrCreate(['id'=>$post?->id], $data);
        //on prefixe la valeur null a notre objet par un ? "$post?" afin d'eviter une erreur dans le cas d'une creation 
        // si laravel trouve un post qui a un identifiant passé par $post?->id dans la table post (maj) sinon $post?->id = null du coup il va la creer

        //associer les differents tags dans post_tag
        $post->tags()->sync($data['tag_id'] ?? null); //sync vient syncroniser et rafraichir dans le cas ou des etiquetes étaient deja affilié a ce post
        // si les tags ne sont pas renseigné par l'user ils seront par defaut null
        
        return redirect()->route('posts.show', ['post' => $post])
        //wasRecentlyCreated retourne true si le post vient d'etre publié avec le msg Status : (sinon) false en cas de maj
        ->withStatus($post->wasRecentlyCreated ? 'Post publié !' : 'Post mis à jour !');
    }

    /**
     * CREATION : enregistrement du formulaire et validation s'il est bien rempli.
     * On vient creer notre propre class request = PostRequest (permet d'isoler la validation)
     */
    public function store(PostRequest $request) : RedirectResponse
    {
        return $this->save($request->validated());
    }

    /**
     * MISE A JOUR the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post) : RedirectResponse
    {
        return $this->save($request->validated(), $post); //on passe le post en second parametre qui sera mis a jour car c'est pas une creation
    }

    /*-----------------------------------------------------------------------------------------*/


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //supprime l'image de l'article d'abord
        Storage::delete($post->thumbnail);

        //supprimer un post
        $post->delete();

        return redirect()->route('admin.posts.index')->withStatus('Post supprimé avec succés !');

        //extension=fileinfo dans php.ini doit etre activé

    }

}
