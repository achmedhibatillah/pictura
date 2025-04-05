<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function connecting(): HasMany
    {
        return $this->hasMany(UserToUserConnect::class, 'user_id_src');
    }

    public static function getPeoples($keyword = null, $user_id) {
        $keyword = '%' . $keyword . '%';
    
        $usersData = User::where('user_username', 'like', $keyword)
                        ->orWhere('user_fullname', 'like', $keyword)
                        ->get();
    
        foreach ($usersData as $x) {
            $isConnected = UserToUserConnect::where('user_id_src', $user_id)
                                            ->where('user_id_dst', $x->user_id)
                                            ->exists();
            $x->connect_status = $isConnected;
        }
    
        return $usersData;
    }    

    public static function checkConnect($my_user_id, $target_user_id, $src_or_dst)
    {
        if ($src_or_dst === 'src') {
            return DB::table('user_to_user_connect')->where('user_id_src', $my_user_id)->where('user_id_dst', $target_user_id)->exists();
        } elseif ($src_or_dst === 'dst') {
            return DB::table('user_to_user_connect')->where('user_id_src', $target_user_id)->where('user_id_dst', $my_user_id)->exists();
        }

        return false;
    }

    public static function getConnect($user_id, $src_or_dst, $else = false, $head = null)
    {
        $query = DB::table('user_to_user_connect')
            ->join('user', function ($join) use ($src_or_dst) {
                if ($src_or_dst === 'src') {
                    $join->on('user_to_user_connect.user_id_dst', '=', 'user.user_id');
                } else {
                    $join->on('user_to_user_connect.user_id_src', '=', 'user.user_id');
                }
            });

        if ($else) {
            if ($src_or_dst === 'src') {
                $query->where('user_to_user_connect.user_id_src', '!=', $user_id)->where('user_to_user_connect.user_id_dst', '!=', $user_id);
            } else {
                $query->where('user_to_user_connect.user_id_dst', '!=', $user_id)->where('user_to_user_connect.user_id_src', '!=', $user_id);
            }

            if (!is_null($head)) {
                $query->limit($head);
            }
        } else {
            if ($src_or_dst === 'src') {
                $query->where('user_to_user_connect.user_id_src', $user_id);
            } else {
                $query->where('user_to_user_connect.user_id_dst', $user_id);
            }
        }

        $users = $query->select('user.*')->get();

        return [
            'count' => $users->count(),
            'users' => $users->toArray()
        ];
    }

    

}
