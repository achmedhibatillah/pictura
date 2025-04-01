<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToUserConnect extends Model
{
    protected $table = 'user_to_user_connect';
    protected $primaryKey = 'relation_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'relation_id',
        'user_id_src',
        'user_id_dst',
        'connect_status',
    ];
}
