<?php

use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('la página principal funciona', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('logueado se puede crear una noticia', function () {
    $usuario = User::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->get('/noticias/create');

    $response->assertOk();
});

test('como invitado no se puede crear una noticia', function () {
    $response = $this->get('/noticias/create');

    $response->assertRedirect('/login');
});

test('el usuario crea una noticia', function () {
    $usuario = User::factory()->create();
    $categoria = Categoria::factory()->create();

    $response = $this
        ->actingAs($usuario)
        ->from('/noticias/create')
        ->post('/noticias', [
            'titular' => 'titular de prueba',
            'descripcion' => 'descripción de prueba',
            'url' => 'url de prueba',
            'categoria_id' => $categoria->id,
            'user_id' => $usuario->id,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('noticias', [
        'titular' => 'titular de prueba',
        'descripcion' => 'descripción de prueba',
        'url' => 'url de prueba',
        'categoria_id' => $categoria->id,
        'user_id' => $usuario->id,
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');
});

test('el usuario crea una noticia con imagen', function () {
    $usuario = User::factory()->create();
    $categoria = Categoria::factory()->create();
    Storage::fake('public');

    $archivo = UploadedFile::fake()->image('prueba.jpg');

    $response = $this
        ->actingAs($usuario)
        ->from('/noticias/create')
        ->post('/noticias', [
            'titular' => 'titular de prueba',
            'descripcion' => 'descripción de prueba',
            'url' => 'url de prueba',
            'categoria_id' => $categoria->id,
            'user_id' => $usuario->id,
            'imagen' => $archivo,
        ]);

    $this->assertAuthenticated();
    $this->assertDatabaseHas('noticias', [
        'id' => 2,
        'titular' => 'titular de prueba',
        'descripcion' => 'descripción de prueba',
        'url' => 'url de prueba',
        'categoria_id' => $categoria->id,
        'user_id' => $usuario->id,
    ]);

    Storage::disk('public')->assertExists('imagenes/2.jpg');

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');
});
