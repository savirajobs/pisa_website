<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id'; 

    protected $fillable = [
        'post_id',
        'file_name',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }

}
