<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->timestamps();
        });

        DB::table('categorias')->insert([
            ['nombre' => 'Actualidad', 'created_at' => now()],
            ['nombre' => 'Política', 'created_at' => now()],
            ['nombre' => 'Deportes', 'created_at' => now()],
            ['nombre' => 'Tecnología', 'created_at' => now()],
            ['nombre' => 'Ciencia', 'created_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
