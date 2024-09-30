<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'detail'
    ];

    public function roomTypeImgs(){
        return $this->hasMany(RoomTypeImage::class, 'room_type_id');
    }
}
