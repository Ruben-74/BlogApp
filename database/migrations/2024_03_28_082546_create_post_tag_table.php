<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * TABLE PIVOT POUR UNE RELATION MANY TO MANY AVEC LA TABLE TAG
     * UNE TABLE PIVOT N'A PAS BESOIN D'UN MODEL
     * php artisan make:migration create_post_tag_table : 
     * la syntax c'est d'abord la table qui commence par la premiere lettre de l'alphabet P qui vient avant T pour Tag
     * Le tout en minuscule
     * Run the migrations.
     */
    public function up(): void
    {
        // Cette table pivot va contenir 2 clé etrangere (ID) qui lit les deux tables Post et Tag
        Schema::create('post_tag', function (Blueprint $table) {
            
            $table->foreignId('post_id')->constrained()->cascadeOnDelete(); 
            // cascadeOnDelete va permettre lorsqu'on supprime un post avec le tag 2 de supprimer le tag 2 dans la table Tag
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
