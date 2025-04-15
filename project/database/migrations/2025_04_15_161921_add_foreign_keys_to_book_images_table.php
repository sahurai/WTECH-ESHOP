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
        Schema::table('book_images', function (Blueprint $table) {
            $table->foreign(['book_id'], 'book_images_book_id_fkey')->references(['id'])->on('books')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_images', function (Blueprint $table) {
            $table->dropForeign('book_images_book_id_fkey');
        });
    }
};
