<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add deleted_at (SoftDeletes) to all 7 tables as specified
     * in the project concept document.
     */
    public function up(): void
    {
        $tables = [
            'admin',
            'user_tb',
            'kriteria',
            'sub_kriteria',
            'menu_tb',
            'penilaian_tb',
            'hasil_tb',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->softDeletes(); // Adds nullable deleted_at TIMESTAMP column
            });
        }
    }

    /**
     * Remove deleted_at from all 7 tables.
     */
    public function down(): void
    {
        $tables = [
            'admin',
            'user_tb',
            'kriteria',
            'sub_kriteria',
            'menu_tb',
            'penilaian_tb',
            'hasil_tb',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->dropSoftDeletes();
            });
        }
    }
};
