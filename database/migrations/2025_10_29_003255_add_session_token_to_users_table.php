<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'session_token')) {
                $table->string('session_token')->nullable()->after('remember_token');
                $table->index('session_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'session_token')) {
                $table->dropIndex(['session_token']);
                $table->dropColumn('session_token');
            }
        });
    }
};