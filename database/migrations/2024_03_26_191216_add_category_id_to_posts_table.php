<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //after() permet de placer la category_id juste apres le champs id dans la table post
            //nullOnDelete() permet de mettre a null les post qui contenait la valeur de la category qui a été supprimé dans la table Categorie
            //nullable() permet de rendre null la valeur category a la suppression d'une categorie pour eviter que tous les post avec la meme categ. soit aussi supprimé
            $table->foreignId('category_id')->after('id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) { 
            $table->dropForeign(['category_id']);
            $table->dropColumn(('category_id'));
        });
    }
};
