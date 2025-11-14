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
        Schema::create('beer_embeddings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beer_id')->constrained()->cascadeOnDelete();
            $table->longText('text');
            $table->json('metadata');
            $table->vector('embedding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beer_embeddings');
    }
};
