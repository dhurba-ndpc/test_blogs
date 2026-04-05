<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        
        'title_en',
        'title_np',
        'slug',
        'description_en',
        'description_np',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
