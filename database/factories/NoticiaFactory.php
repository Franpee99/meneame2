<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seed = Str::random(10);
        $randomCategoria = random_int(1, 5);
        return [
            'titular' => fake()->text(25),
            'url' => fake()->url(),
            'descripcion' => fake()->text(),
            'imagen' => "https://picsum.photos/seed/$seed/300/200",
            'categoria_id' => $randomCategoria,
            'user_id' => User::first()->id,
        ];
    }
}
