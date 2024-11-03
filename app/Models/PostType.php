<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostType extends Model
{
    use HasFactory;
  
    protected $table = 'posttypes';
    protected $fillable = [
        'type_id',
        'type_desc',
        'created_at',
        'updated_at',
    ];
    protected $primaryKey = 'type_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function posttype(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
