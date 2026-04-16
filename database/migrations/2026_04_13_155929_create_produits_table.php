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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom_produit', 255);
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2); // Check will be added via trigger/manual sql if needed, but Laravel doesn't have native check constraints in Blueprint for all DBs
            $table->integer('stock')->default(0);
            $table->string('image', 255)->nullable();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
