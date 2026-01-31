<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessInquiry extends Model
{
    protected $fillable = ['user_id', 'business_name', 'current_challenges', 'goals', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
