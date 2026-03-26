<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts():HasMany {
        return $this->hasMany(Post::class);
    }

    public function comments() : HasMany {
        return $this->hasMany(Comment::class);
    }

    public function likes() : HasMany {
        return $this->hasMany(Like::class);
    }
}
