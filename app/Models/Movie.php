<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $table = 'movies';

    protected $fillable = [
        'title',
        'image_url',
        'published_year',
        'description',
        'is_showing',
        'genre_id',
    ];

    protected $dates =  ['created_at', 'updated_at'];

    protected $casts = [
        'is_showing' => 'boolean',
     ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

}
