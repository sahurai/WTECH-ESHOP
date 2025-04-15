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
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign(['role_id'], 'role_user_role_id_fkey')->references(['id'])->on('roles')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'], 'role_user_user_id_fkey')->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign('role_user_role_id_fkey');
            $table->dropForeign('role_user_user_id_fkey');
        });
    }
};
