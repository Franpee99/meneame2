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

    //Relación polimórfica
    public function comentable(){
        return $this->morphTo();
    }

    //Un comentario puede tener muchos comentarios
    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentable');
    }
}
