<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToPostLike extends Model
{
    protected $table = 'user_to_post_like';
    protected $primaryKey = 'relation_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'relation_id',
        'user_id',
        'post_id',
        'like_status',
    ];
}
