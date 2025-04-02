<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'slide';
    protected $primaryKey = 'slide_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'slide_id',
        'slide_image',
        'slide_order',
        'post_id',
    ];
}
