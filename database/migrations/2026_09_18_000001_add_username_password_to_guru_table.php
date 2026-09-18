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
        Schema::table('guru', function (Blueprint $table) {
            if (!Schema::hasColumn('guru', 'username')) {
                $table->string('username', 100)->nullable()->after('nip_nuptk');
            }
            if (!Schema::hasColumn('guru', 'password')) {
                $table->string('password')->nullable()->after('username');
            }
            if (!Schema::hasColumn('guru', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            if (Schema::hasColumn('guru', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('guru', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('guru', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
