<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->boolean('repeat_weekly')->default(false)->after('notas_tutor');
            $table->date('repeat_until')->nullable()->after('repeat_weekly');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['repeat_weekly', 'repeat_until']);
        });
    }
};
