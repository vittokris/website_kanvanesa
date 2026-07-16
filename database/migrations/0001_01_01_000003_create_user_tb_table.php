<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_tb', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('user_username')->unique();
            $table->string('user_password');
            $table->string('user_name');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tb');
    }
};
