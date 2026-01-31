<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['user_id', 'is_from_admin', 'message', 'is_read', 'friendship_id', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friendship()
    {
        return $this->belongsTo(Friendship::class);
    }
}
