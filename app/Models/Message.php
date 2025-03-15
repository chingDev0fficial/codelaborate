<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message', // Changed from 'content' to 'message'
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Relationship with sender user
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship with receiver user
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
