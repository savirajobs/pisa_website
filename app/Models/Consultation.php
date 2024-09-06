<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Consultation extends Model
{
    use HasFactory;

    public function consultcategories(): hasOne
    {
        return $this->hasOne(consultcategory::class);
    }
}
