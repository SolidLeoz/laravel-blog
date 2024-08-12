<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['title', 'content', 'image', 'video'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    protected static function boot()
{
    parent::boot();

    static::deleting(function ($post) {
        $post->tags()->detach();
        // Aggiungi qui altre operazioni di pulizia se necessario
    });
}

}
