<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = ['user_id', 'job_title', 'cv_path', 'status', 'views'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
