<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heart extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'share_id',
        'user_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function share()
    {
        return $this->belongsTo(Share::class);
    }
}
