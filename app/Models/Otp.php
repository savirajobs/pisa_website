<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'otp',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    // Cek apakah OTP masih valid berdasarkan waktu kedaluwarsa
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expired_at);
    }
}
