<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_tb', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_user')->constrained('user_tb', 'id_user')->onDelete('cascade');
            $table->foreignId('id_menu')->constrained('menu_tb', 'id_menu')->onDelete('cascade');
            $table->foreignId('id_kriteria')->constrained('kriteria', 'id_kriteria')->onDelete('cascade');
            $table->foreignId('id_subkriteria')->constrained('sub_kriteria', 'id_sub_kriteria')->onDelete('cascade');
            $table->timestamps();

            // Each user can rate a menu for each criterion only once
            $table->unique(['id_user', 'id_menu', 'id_kriteria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_tb');
    }
};
