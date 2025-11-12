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
        Schema::table('teams', function (Blueprint $table) {
            $table->string('domain')->unique()->nullable()->after('slug');
            $table->string('mobile')->nullable()->after('domain');
            $table->string('email')->nullable()->after('mobile');
            $table->string('password')->nullable()->after('email');
            $table->boolean('is_active')->default(true)->after('personal_team');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['domain', 'mobile', 'email', 'password', 'is_active']);
        });
    }
};
