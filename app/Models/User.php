<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function checkConnect($my_user_id, $target_user_id, $src_or_dst)
    {
        if ($src_or_dst === 'src') {
            return DB::table('user_to_user_connect')->where('user_id_src', $my_user_id)->where('user_id_dst', $target_user_id)->exists();
        } elseif ($src_or_dst === 'dst') {
            return DB::table('user_to_user_connect')->where('user_id_src', $target_user_id)->where('user_id_dst', $my_user_id)->exists();
        }

        return false;
    }

    public static function getConnect($user_id, $src_or_dst)
    {
        $query = DB::table('user_to_user_connect')
            ->join('user', function ($join) use ($src_or_dst) {
                if ($src_or_dst === 'src') {
                    $join->on('user_to_user_connect.user_id_dst', '=', 'user.user_id');
                } else {
                    $join->on('user_to_user_connect.user_id_src', '=', 'user.user_id');
                }
            });
    
        if ($src_or_dst === 'src') {
            $query->where('user_to_user_connect.user_id_src', $user_id);
        } else {
            $query->where('user_to_user_connect.user_id_dst', $user_id);
        }
    
        $users = $query->select('user.*')->get();
    
        return [
            'count' => $users->count(),
            'users' => $users->toArray()
        ];
    }
    

}
