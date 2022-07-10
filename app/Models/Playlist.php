<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code_list',
        'user_id',
        'mediafile_id',
        'created_at',
        'updated_at'
    ];
}
