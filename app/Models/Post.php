<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function slides()
    {
        return $this->hasMany(Slide::class, 'post_id');
    }
}
