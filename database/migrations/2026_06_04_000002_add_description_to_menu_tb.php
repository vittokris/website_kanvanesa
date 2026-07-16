<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_tb', function (Blueprint $table) {
            // Add nullable description column after menu_name
            $table->text('menu_description')->nullable()->after('menu_name');
        });
    }

    public function down(): void
    {
        Schema::table('menu_tb', function (Blueprint $table) {
            $table->dropColumn('menu_description');
        });
    }
};
