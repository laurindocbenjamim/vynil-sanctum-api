<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist',
        'title',
        'feat',
        'genre',
        'track_path',
        'track_image',
        'launched_date',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
