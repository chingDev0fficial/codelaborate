<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'body', 
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hearts()
    {
        return $this->hasMany(Heart::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
