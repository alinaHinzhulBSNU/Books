<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function author(){
        return $this->belongsTo(
            Author::class,
            'author_id',
            'id'
        );
    }

    public function genre(){
        return $this->belongsTo(
            Genre::class,
            'genre_id',
            'id'
        );
    }

    public function publisher(){
        return $this->belongsTo(
            Publisher::class,
            'publisher_id',
            'id'
        );
    }

    public function comments(){
        return $this->hasMany(
            Comment::class,
            'book_id',
            'id'
        );
    }
}
