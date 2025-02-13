<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    /** @use HasFactory<\Database\Factories\NoticiaFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'titular',
        'url',
        'descripcion',
        'imagen',
        'categoria_id',
        'user_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRutaImagen()
    {
        return $this->imagen ?? asset('storage/imagenes/' . $this->id . '.jpg'); //para que salgan las imagenes del noticiaFactory
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
