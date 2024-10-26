<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory, Notifiable;

    // protected $table = 'post';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'post_id',
        'post_title',
        'slug',
        'post_desc',
        'post_type',
        'is_publish',
        'category_id',
        'event_at',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'post_id', 'post_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function post_types()
    {
        return $this->belongsTo(PostType::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
