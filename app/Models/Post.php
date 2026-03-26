<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Post extends Model
{
    /**
     * Use the MongoDB database connection defined in `config/database.php`.
     */
    protected $connection = 'mongodb';

    protected $table = 'posts';

    protected $fillable = ['title', 'content', 'slug', 'image', 'category_id', 'user_id', 'published_at'];

    public function user() :BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}
