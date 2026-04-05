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
        'user_id',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $hidden = [
        'id',
        'user_id', // You can hide the foreign key here too if you don't want it exposed
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
