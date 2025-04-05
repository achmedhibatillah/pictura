<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    protected $table = 'notif';
    protected $primaryKey = 'notif_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'notif_id',
        'src_id',
        'notif_user_id_sender',
        'notif_user_id_reader',
        'notif_state',
    ];
}