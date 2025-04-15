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
        Schema::table('book_categories', function (Blueprint $table) {
            $table->foreign(['book_id'], 'book_categories_book_id_fkey')->references(['id'])->on('books')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['category_id'], 'book_categories_category_id_fkey')->references(['id'])->on('categories')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_categories', function (Blueprint $table) {
            $table->dropForeign('book_categories_book_id_fkey');
            $table->dropForeign('book_categories_category_id_fkey');
        });
    }
};
