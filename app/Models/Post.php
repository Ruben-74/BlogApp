<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;


    //--------------------URL PERSONNALISATION---------------------
    // EAGER LOADING CHARGE TOUS LES TAGS ET CATEGORY ---- POUR OPTIMISATION 
    // FONCTION WITH POUR CHARGER TOUT LE TEMPS LA RELATION CATEGORY ET EVITER DE FAIRE 13 REQUETES ------- OPTIMISATION
    protected $with = ['category', 'tags']; // c'est le meme nom de la function category() et tags();

    // Proteger les champs du Mass Assignement 
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //modification de l'URL du post on remplace l'id par un titre slug => localhost:8000/slug
    public function getRouteKeyName() : string 
    {
        return 'slug';
    }

    //-------------------SCOPE FILTERS ----------------------------
    public function scopeFilters(Builder $query, $filters) : void
    {
        if(isset($filters['search'])){

            $query->where(fn (Builder $query) => $query 
            ->where('title', 'LIKE', '%' . $filters['search'] . '%')
            ->orWhere('content', 'LIKE', '%' . $filters['search'] . '%')
            );
        }

        if(isset($filters['category'])){

            $query->where(
                'category_id', $filters['category']->id ?? $filters['category']
            );
        }

        if(isset($filters['tag'])){

            $query->whereRelation(
                'tags', 'id', $filters['tag']->id ?? $filters['tag']
            );
        }
    }

    //method exist qui permet d'identifier par un boolean true ou false si l'id du post est existant ou on l'a crée
    public function exists() : bool  
    {
        return (bool) $this->id;
    }

    //---------------------RELATIONS-----------------------------------
    // La table ou la clé etrangere est situé ici sur la table post doit avoir la relation Inverse
    // Belong To pour une relation One To Many du coup (Inverse) permet d'accéder à toutes les categories d'un post
    // et de définir une relation pour permettre à une categorie d'accéder à son post parent.
    public function category(): BelongsTo
    {

        return $this->belongsTo(Category::class);
    }

    // Tags au pluriel car on peut recuperer une infinité de tags
   
    public function tags(): BelongsToMany{ // Many To Many (inverse) 

        return $this->belongsToMany(Tag::class);
    }

    // Une relation One To Many (sans inverse) -- est utilisée pour définir des relations 
    // dans lesquelles un seul modèle est le parent d'un ou plusieurs modèles enfants
    public function comments(): HasMany 
    {
        return $this->hasMany(Comment::class)->latest(); // les derniers commentaires en premiers 
    }



}
