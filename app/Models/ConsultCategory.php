<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultCategory extends Model
{
    use HasFactory;

    public function consultations(): BelongsTo
    {
        return $this->belongsTo(consultation::class);
    }


}
