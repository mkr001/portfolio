<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id', 
        'donor_name', 
        'amount', 
        'transaction_id', 
        'message', 
        'admin_thanks_note', 
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
