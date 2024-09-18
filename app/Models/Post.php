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
        return $this->belongsTo(Category::class, 'category_id','category_id');
    }

    public function getProgramAnak()
    {
        $subquery = DB::table('media')
        ->select('post_id', DB::raw('MIN(file_name) as file_name'))
        ->groupBy('post_id');

        return self::select(
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
            // 'media.file_name as image_name',
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')            
        )
        // ->leftjoin('media','posts.post_id', '=', 'media.post_id')
        ->join('users','posts.created_by','=','users.id')
        ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
        ->where('posts.is_publish', 1)
        ->where('posts.post_type', 'CP') // program anak
        ->orderBy('posts.created_at', 'desc')
        // ->limit(3)
        ->get();
    }
    
    public function getLatestNews()
    {
        $subquery = DB::table('media')
            ->select('post_id', DB::raw('MIN(file_name) as file_name'))
            ->groupBy('post_id');

        return self::select(
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
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')            
        )
        ->join('users','posts.created_by','=','users.id')
        ->join('categories','posts.category_id','=','categories.category_id')
        ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
        ->where('posts.is_publish', 1)
        ->where('posts.post_type', 'CT') // content
        ->where('categories.category_name', 'News')
        ->orderBy('posts.created_at', 'desc')
        // ->limit(3)
        ->get();
    }

    public function getLatestEvent()
    {
        $subquery = DB::table('media')
        ->select('post_id', DB::raw('MIN(file_name) as file_name'))
        ->groupBy('post_id');

        $incl_categories = ['Event', 'Information'];

        return self::select(
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
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')            
        )
        ->join('users','posts.created_by','=','users.id')
        ->join('categories','posts.category_id','=','categories.category_id')
        ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
        ->where('posts.is_publish', 1)
        ->where('posts.post_type', 'CT') // content
        ->wherein('categories.category_name', $incl_categories)
        ->orderBy('posts.created_at', 'desc')
        // ->limit(3)
        ->get();
    }

    public function post_types()
    {
        return $this->belongsTo(PostType::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getProgramList()
    {
        $subquery = DB::table('media')
        ->select('post_id', DB::raw('MIN(file_name) as file_name'))
        ->groupBy('post_id');

        return self::select(
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
            'top_media.file_name as image_name',
            'users.name as user_name',
            DB::raw('LEFT(posts.post_desc, 100) as short_desc')           
        )
        ->join('users','posts.created_by','=','users.id')
        ->leftJoinSub($subquery, 'top_media', function ($join) {
                $join->on('posts.post_id', '=', 'top_media.post_id');
            })
        ->where('posts.is_publish', 1)
        ->where('posts.post_type', 'CP') // program anak
        ->orderBy('posts.created_at', 'desc')
        ->limit(5)
        ->get();
    }

    public function showprogram()
    {
        return self::select(
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
            'media.file_name as image_name',
            'users.name as user_name',          
        )
        ->join('users','posts.created_by','=','users.id')
        ->join('categories','posts.category_id','=','categories.category_id')
        ->leftjoin('media','posts.post_id', '=', 'media.post_id')
        ->where('posts.is_publish', 1)
        ->where('posts.post_type', 'CP') // program anak
        ->orderBy('posts.created_at', 'desc')
        // ->limit(5)
        ->get();
    }

    
}
