<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];

    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'facebook',
        'tiktok',
        'instagram',
        'image',
    ];
}
