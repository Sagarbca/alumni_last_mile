<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    //
    protected $connection =  'mongodb_conn';
    protected  $collection = 'posts';

    protected $fillable = [
        'user_id', 'caption', 'image','user','likes','comment'
    ];

    protected $attributes = [
        'status_id' => 1,
    ];
    public static $active_status_ids=[1];
    protected $casts = [
        'likes' => 'array',
        'comment' => 'array',
    ];

    public function scopeActive($query){
        return $query->whereIn('status_id',Post::$active_status_ids);
    }
}
