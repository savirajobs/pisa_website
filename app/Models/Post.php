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
    // protected $primaryKey = 'post_id';
    protected $fillable = [
        'post_id',
        'post_title',
        'slug',
        'post_desc',
        'post_type',
        'is_publish',
        'category_id',
        'published_at',
        'upcoming_date',
        'created_by',
        'updated_by',
    ];

    public function getProgramAnak()
    {
        return self::where('is_publish', 1)
                ->where('post_type', 'CP') // program anak
                ->orderby('post_id', 'desc')
                ->limit(3)
                ->get();
    }
    
    public function getLatestNews()
    {
        return self::where('is_publish', 1)
                ->where('category_id', 1) //news
                ->orderby('post_id', 'desc')
                ->limit(3)
                ->get();
    }

    public function getLatestEvent()
    {
        return self::where('is_publish', 1)
                ->where('category_id', 2) //event
                ->orderby('post_id', 'desc')
                ->limit(3)
                ->get();
    }

    public static function getPostList()
    {

        // $subquery = DB::table('media')
        // ->select('post_id', 'file_name')
        // ->orderBy('file_name', 'desc')
        // ->groupBy('post_id') // Grup berdasarkan post_id
        // ->first(); /// Top 1 per group

        return self::with(['category', 'media'])
            ->select(
                'posts.post_id',
                'posts.post_title',
                'posts.slug',
                'posts.post_desc',
                'posts.is_publish',
                'posts.category_id',
                'posts.published_at',
                'posts.category_id',
                'posts.upcoming_date',
                'posts.created_by',
                'posts.created_at',
                'categories.category_name as category_name',
                'media.file_name as image_name',
                // 'top_media.file_name as image_name',
                'users.name as user_name'
            )
            ->join('categories', 'posts.category_id', '=', 'categories.category_id')
            ->leftjoin('media','posts.post_id', '=', 'media.post_id')
            ->join('users','posts.created_by','=','users.id')
            // ->leftJoinSub($subquery, 'top_media', function ($join) {
            //     $join->on('posts.post_id', '=', 'top_media.post_id');
            // })
            ->where('is_publish', 1)
            ->where('post_type', 'CP') // program anak
            ->orderBy('posts.created_at', 'desc')
            ->limit(3)
            ->get();
    }

    public function post_types()
    {
        return $this->belongsTo(PostType::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    
}
