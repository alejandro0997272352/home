<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['tutor_id', 'estado', 'fecha']);
            $table->index(['student_id', 'estado', 'fecha']);
            $table->index(['fecha', 'estado']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index(['user_id', 'read_at']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index(['conversation_id', 'sender_id', 'read']);
        });

        Schema::table('availability', function (Blueprint $table) {
            $table->index(['user_id', 'activo']);
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['tutor_id', 'estado', 'fecha']);
            $table->dropIndex(['student_id', 'estado', 'fecha']);
            $table->dropIndex(['fecha', 'estado']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'read_at']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['conversation_id', 'sender_id', 'read']);
        });

        Schema::table('availability', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'activo']);
        });
    }
};
