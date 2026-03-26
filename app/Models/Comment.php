<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Comment extends Model
{
    protected $connection = 'mongodb';

    protected $table = "comments";

    protected $fillable = ['comment' , 'post_id' , 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
