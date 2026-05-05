<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoundItem extends Model
{
    protected $fillable = [
        'user_id', 'item_name', 'category', 'brand',
        'color', 'date_found', 'time_found', 'place_found',
        'image_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
