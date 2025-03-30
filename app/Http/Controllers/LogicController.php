<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LogicController extends Controller
{
    public static function generateUniqueId(string $table, string $column, int $length = 35): string
    {
        do {
            $randomString = Str::random($length);
            $exists = DB::table($table)->where($column, $randomString)->exists();
        } while ($exists);

        return $randomString;
    }
}
