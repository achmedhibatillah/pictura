<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SuperUserController extends Controller
{
    public function index()
    {
        $myUser = User::where('user_id', session('user')['user_id'])->first();
        $usersData = User::get();

        return 
        view('templates/header') . 
        view('superuser/index', [
            'user' => $myUser,
            'users' => $usersData,
        ]) . 
        view('templates/footer');
    }

    public function user_del(Request $request)
    {
        $userData = User::where('user_id', $request->user_id)->first();
        $postsData = Post::where('user_id', $userData->user_id)->get();

        foreach ($postsData as $x) {
            $slidesData = Slide::where('post_id', $x->post_id)->get();
    
            foreach ($slidesData as $y) {
                File::delete($y->slide_image);
            }

            Slide::where('post_id', $x->post_id)->delete();
        }
    }
}
