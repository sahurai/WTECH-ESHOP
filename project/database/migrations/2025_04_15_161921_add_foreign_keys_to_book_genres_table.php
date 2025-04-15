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
        Schema::table('book_genres', function (Blueprint $table) {
            $table->foreign(['book_id'], 'book_genres_book_id_fkey')->references(['id'])->on('books')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['genre_id'], 'book_genres_genre_id_fkey')->references(['id'])->on('genres')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_genres', function (Blueprint $table) {
            $table->dropForeign('book_genres_book_id_fkey');
            $table->dropForeign('book_genres_genre_id_fkey');
        });
    }
};
