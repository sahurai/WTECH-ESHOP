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
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('author');
            $table->text('description')->nullable();
            $table->decimal('price', 10);
            $table->integer('quantity')->default(0);
            $table->integer('pages_count')->nullable();
            $table->integer('release_year')->nullable();
            $table->string('language', 50)->nullable();
            $table->string('format', 50)->nullable();
            $table->string('publisher', 100)->nullable();
            $table->string('isbn', 20)->nullable()->unique('books_isbn_key');
            $table->string('edition', 50)->nullable();
            $table->string('dimensions', 100)->nullable();
            $table->decimal('weight', 10)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
