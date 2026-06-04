<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->text('experiencia')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'subject_id']);
        });

        Schema::create('tutor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->unique();
            $table->text('biografia')->nullable();
            $table->string('formacion_academica', 500)->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('total_sesiones')->default(0);
            $table->decimal('tarifa_por_hora', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_profiles');
        Schema::dropIfExists('tutor_subject');
    }
};
