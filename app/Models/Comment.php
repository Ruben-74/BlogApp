<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    //--------------------URL PERSONNALISATION---------------------
    // EAGER LOADING CHARGE TOUS LES TAGS ET CATEGORY ---- POUR OPTIMISATION 
    protected $with = ['user'];

    //Active le Mass Assigment pour ces 3 champs (on choisit soit fillable soit guarded)
    //protected $fillable = ['content', 'post_id', 'user_id'];

    // Désactive le Mass Assigment pour ces champs 
    protected $guarded = ['id', 'created_at', 'updated_at']; // induit que les 3 champs en haut sont en Mass Assigment par defaut 

    // Belongs to One to Many (inversé) avec les users 
    public function user() : BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }   

}
