<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verification_otp',
        'email_verification_otp_expires_at',
        'email_verified_at',
    ];

    public function jobApplication()
    {
        return $this->hasOne(JobApplication::class);
    }

    public function businessInquiry()
    {
        return $this->hasOne(BusinessInquiry::class);
    }

    public function freelanceInquiry()
    {
        return $this->hasOne(FreelanceInquiry::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'email_verification_otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function generateEmailVerificationOtp()
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->email_verification_otp = $otp;
        $this->email_verification_otp_expires_at = now()->addMinutes(10);
        $this->save();
        return $otp;
    }

    public function verifyEmailOtp($otp)
    {
        if ($this->email_verification_otp === $otp && 
            $this->email_verification_otp_expires_at && 
            $this->email_verification_otp_expires_at->isFuture()) {
            $this->email_verified_at = now();
            $this->email_verification_otp = null;
            $this->email_verification_otp_expires_at = null;
            $this->save();
            return true;
        }
        return false;
    }

    public function isEmailVerified()
    {
        return !is_null($this->email_verified_at);
    }
}
