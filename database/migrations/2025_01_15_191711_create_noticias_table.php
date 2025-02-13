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
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();
            $table->string('titular');
            $table->string('url');
            $table->text('descripcion');
            $table->string('imagen', 4000)->nullable();
            $table->foreignId('categoria_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->integer('meneos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
