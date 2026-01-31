<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelanceInquiry extends Model
{
    protected $fillable = [
        'user_id', 
        'project_title', 
        'project_description', 
        'budget_range', 
        'status', 
        'estimated_completion_date', 
        'admin_notes'
    ];

    protected $casts = [
        'estimated_completion_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
