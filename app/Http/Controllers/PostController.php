<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // public function index(Request $request): View
    // {

    //     $posts = Post::query(); // query() permet de d'initialiser un querybuilder pour notre model vide

    //     // On va verifier si l'utilisateur active le parametre search dans barre de recherche 
    //     if($search = $request->search){
    //         //isoler un where global
    //         $posts->where(fn (Builder $query) => $query 
    //         ->where('title', 'LIKE', '%' . $search . '%')
    //         ->orWhere('content', 'LIKE', '%' . $search . '%')
    //         );
    //     }


    //     return view('posts.index', [
    //         'posts' => $posts->latest()->paginate(10), //affiche les post les plus recents au plus anciens
    //     ]);
    // }

    public function __construct()
    {
        $this->middleware('auth')->only('comment');
    }

    protected function postView(array $filters) : View {

        return view('posts.index', [
            'posts' => Post::filters($filters)->latest()->paginate(10)
        ]);
    }


    public function index(Request $request): View{

        return $this->postView($request->search ? ['search' => $request->search ] : []);
    }

    // Fontion pour filtrer les posts par category
    public function postsByCategory(Category $category): View
    {
        return $this->postView(['category' => $category]);

        // return view('posts.index', [

        //     'posts' => $category->posts()->latest()->paginate(10),
        //     'posts' => Post::where(

        //         'category_id',$category->id,

        //     )->latest()->paginate(10)
        // ]);
    }

    // Fontion pour filtrer les posts par tag (attention le where tout seul marche pas pq il y a une relation Many To Many)
    public function postsByTag(Tag $tag): View
    {
        return $this->postView(['tag' => $tag]);

        // return view('posts.index', [

        //     'posts' => $tag->posts()->latest()->paginate(10),
        //     'posts' => Post::whereRelation(
        //         'tags', 'id', $tag->id //model Post relation tags() possede l'id = a l'id du tag qu'on vise
        //     )->latest()->paginate(10)
        // ]);
    }

    public function show(Post $post): View
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    //Ajouter un commentaire
    public function comment(Post $post, Request $request ) : RedirectResponse {
        
        $validated =$request->validate([
            'comment' => ['required', 'string', 'between:2,255']
        ]);

        //Ajout du commentaire sans le Mass Assigment
        // $comment = new Comment();

        // $comment->content = $validated['comment'];
        // $comment->post_id = $post->id;
        // $comment->user_id = Auth::id();
        // $comment->save();

        // Ajout avec le Mass Assigment activé 
        Comment::create([
            'content' => $validated['comment'],
            'post_id' => $post->id,
            'user_id' => Auth::id()
        ]);

        //redirection avec message flash
        return back()->withStatus('Commentaire publié !');

    }
}
