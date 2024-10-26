<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Feedback extends Model
{
    use HasFactory;

    public function feedbackcategories(): hasOne
    {
        return $this->hasOne(feedbackcategory::class);
    }
}
