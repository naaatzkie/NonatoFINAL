<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    protected $fillable = [
        'user_id', 'item_name','category', 'brand',
        'color', 'date_lost', 'last_seen_location',
        'description', 'image_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
