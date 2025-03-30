<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'user_username',
        'user_fullname',
        'user_desc',
        'user_email',
        'user_pass',
        'user_photo',
        'user_who',
    ];
}
