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
        Schema::table('kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('kelas', 'username')) {
                $table->string('username', 100)->nullable()->after('kode_member');
            }
            if (!Schema::hasColumn('kelas', 'password')) {
                $table->string('password', 255)->nullable()->after('username');
            }
            if (!Schema::hasColumn('kelas', 'remember_token')) {
                $table->string('remember_token', 100)->nullable()->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('kelas', 'username')) {
                $columns[] = 'username';
            }
            if (Schema::hasColumn('kelas', 'password')) {
                $columns[] = 'password';
            }
            if (Schema::hasColumn('kelas', 'remember_token')) {
                $columns[] = 'remember_token';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
