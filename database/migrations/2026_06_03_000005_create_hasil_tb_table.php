<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_tb', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_menu')->constrained('menu_tb', 'id_menu')->onDelete('cascade');
            $table->decimal('skor', 10, 6);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_tb');
    }
};
