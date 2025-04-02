<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/index') . 
        view('templates/bottom-user') . 
        view('templates/footer');
    }

    public function profile($user_username)
    {
        $userData = User::where('user_username', $user_username)->first();
        $isMyProfile = $userData->user_username == session('user')['user_username'] ? true : false ;
        $connectStatus = [
            'src' => User::checkConnect(session('user')['user_id'], $userData['user_id'], 'src'),
            'dst' => User::checkConnect(session('user')['user_id'], $userData['user_id'], 'dst')
        ];
        $connectData = [
            'connected' => User::getConnect($userData->user_id, 'dst'),
            'connecting' => User::getConnect($userData->user_id, 'src'),
        ];

        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/profile', [
            'user' => $userData,
            'ismyprofile' => $isMyProfile,
            'connect' => $connectStatus,
            'connect_data' => $connectData,
        ]) . 
        view('templates/bottom-user') . 
        view('templates/footer');
    }

    public function profile_edit()
    {
        $userData = User::where('user_id', session('user')['user_id'])->first();

        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/profile-edit', [
            'user' => $userData,
        ]) . 
        view('templates/bottom-user') . 
        view('templates/footer');
    }

    public function post_new($post_public_id = null)
    {
        if ($post_public_id == null) {
            $postData = [
                'post_id' => LogicController::generateUniqueId('post', 'post_id'),
                'post_public_id' => LogicController::generateUniqueId('post', 'post_public_id', 55),
                'post_desc' => null,
                'post_status' => 3,
                'user_id' => session('user')['user_id'],
            ];
    
            Post::create($postData);
            return redirect()->to('new-post/' . $postData['post_public_id']);
        }

        $postData = Post::where('post_public_id', $post_public_id)->first();
        $slidesData = Slide::orderBy('slide_order', 'asc')->where('post_id', $postData->post_id)->get();

        $postsData = Post::where('post_status', 3)->where('user_id', $postData->user_id)->orderBy('created_at', 'desc')
            ->with(['slides' => function($query) {
                $query->orderBy('slide_order', 'asc');
            }])->get();

        // Cek ini
        foreach ($postsData as $x) {
            if ($postData->post_id !== $x->post_id && $x->slides->isEmpty()) {
                Post::where('post_id', $x->post_id)->delete();
            }
        }

        $postsData = Post::where('post_status', 3)->where('user_id', $postData->user_id)->orderBy('created_at', 'desc')
        ->with(['slides' => function($query) {
            $query->orderBy('slide_order', 'asc');
        }])->get();
    
        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/post-new', [
            'post' => $postData,
            'slides' => $slidesData,
            'posts' => $postsData,
        ]) . 
        view('templates/bottom-user') . 
        view('templates/footer');
    }
}
