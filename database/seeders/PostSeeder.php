<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // ------ On recupere la totalité des tags et categories et commentaires
        $categories = Category::all();
        $tags = Tag::all();
        $users = User::all();


        Post::factory(20)// on cree 20 post
        ->sequence(fn () =>[ //sequence permet de recuperer une valeur aleatoire pour un champ ici category_id
            'category_id' => $categories->random()
             // affecter de façon aleatoire l'id d'une categorie creer précedement
        ])
        
        //HasComment est une methode magic qui permet de recuperer la method comments() du model post et de lui charger les commentaires generer aleatoires
        // les users sont differents pour chaque commentaire donc on utilise une fonction fleché qui sera executé pour chaque commentaire et generer un id different d'user
        ->hasComments(5, fn () => ['user_id' => $users->random()])
        ->create() // vient creer une collection de 20 posts en BDD 

        // each va recuperer les posts creé en BDD et avec une fonction fleché attacher des tags a des posts
        // random() si on indique rien recupere que 1 element aleatoire / par contre si on indique 3 va generer 3 tag mais ils seront ne varienront pas entre 0 et 3
        // la methode rand() ici va pouvoir generer aleatoirement entre 0 et 3 tags pour chaque post
        // on attache avec la method attach() aux posts generées le ou les tags stockés dans la variable $tags qui seront attribuées pour chaque post
        ->each(fn ($post) => $post->tags()->attach($tags->random(rand(0,3))));
        // on a acces a tags() car on a creer la method tags() dans le model post
    }
}
