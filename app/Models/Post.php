<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'post';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'post_id',
        'post_public_id',
        'post_desc',
        'user_desc',
        'post_status',
        'user_id',
        'created_at'
    ];

    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class, 'post_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(UserToPostLike::class, 'post_id')->where('like_status', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public static function getAll($user_id, $post_status = 1)
    {
        return self::where('post_status', $post_status)
            ->where('user_id', $user_id)
            ->with(['slides' => function ($query) {
                $query->orderBy('slide_order', 'asc');
            }])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                $post->created_at_day = Carbon::parse($post->created_at)->format('d F Y');
                $post->created_at_hour = Carbon::parse($post->created_at)->format('H:i');
                return $post;
            });
    }  

    public static function getAllByUsers(array $user_ids, $post_status = 1)
    {
        return self::where('post_status', $post_status)
            ->whereIn('user_id', $user_ids)
            ->with([
                'slides' => function ($query) {
                    $query->orderBy('slide_order', 'asc');
                },
                'user' // ini untuk join ke tabel user
            ])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($post) {
                $post->created_at_day = Carbon::parse($post->created_at)->format('d F Y');
                $post->created_at_hour = Carbon::parse($post->created_at)->format('H:i');
                return $post;
            });
    }
    
}
