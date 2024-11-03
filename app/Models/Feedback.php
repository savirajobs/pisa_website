<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'feedback_id',
        'feedback_title',
        'slug',
        'sender_name',
        'email',
        'phone',
        'feedback_category',
        'verification_status',
        'spam_status',
        'duplication_status',
        'reply_status',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'feedback_id';

    public function feedbackcategories(): hasOne
    {
        return $this->hasOne(feedbackcategory::class);
    }
}
