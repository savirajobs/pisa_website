<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackCategory extends Model
{
    use HasFactory;

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(feedback::class);
    }


}
