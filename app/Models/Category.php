<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category_name',
        'slug',
        'created_by',
        'updated_by',
        'created_on',
        'updated_on',
    ];

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class);
    }
}
