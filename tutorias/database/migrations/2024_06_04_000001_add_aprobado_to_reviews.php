<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('aprobado')->default(true)->after('comentario');
            $table->timestamp('moderated_at')->nullable()->after('aprobado');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete()->after('moderated_at');
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['aprobado', 'moderated_at', 'moderated_by']);
        });
    }
};
