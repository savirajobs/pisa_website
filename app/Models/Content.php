<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_id',
        'content_title',
        'content_desc',
        'content_type',
        'is_publish',
        'category_id',
        'published_at',
        'upcoming_date',
        'created_by',
        'updated_by',
    ];

    public function content_types(): BelongsTo
    {
        return $this->belongsTo(ContentType::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
