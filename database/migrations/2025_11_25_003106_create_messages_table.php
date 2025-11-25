<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
            $table->text('message'); // Isi pesan
            $table->timestamps(); // Created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
