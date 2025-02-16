<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    /** @use HasFactory<\Database\Factories\ComentarioFactory> */
    use HasFactory;

    protected $fillable = ['noticia_id', 'user_id', 'contenido', 'parent_id'];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación recursiva: Un comentario puede tener un padre
    public function parent()
    {
        return $this->belongsTo(Comentario::class, 'parent_id');
    }

    // Relación recursiva: Un comentario puede tener muchas respuestas (hijos)
    public function replies()
    {
        return $this->hasMany(Comentario::class, 'parent_id')->with('replies'); // Carga respuestas recursivamente
    }
}
