<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'feedback_id',
        'feedback_title',
        'slug',
        'sender_name',
        'email',
        'phone',
        'feedback_category',
        'feedback_desc',
        'verification_status',
        'spam_status',
        'duplication_status',
        'reply_status',
        'created_at',
        'updated_at'
    ];

    public function feedbackcategories(): hasOne
    {
        return $this->hasOne(feedbackcategory::class);
    }
}
