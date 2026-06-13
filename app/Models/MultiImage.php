<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiImage extends Model
{
    use HasFactory;

    protected $table = 'multi_images';

    protected $fillable = [
        'rooms_id',
        'multi_img',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }
}
