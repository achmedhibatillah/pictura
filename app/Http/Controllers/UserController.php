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
        $usersConnectData = User::getConnect(session('user')['user_id'], 'src');

        $userIds = collect($usersConnectData['users'])->pluck('user_id')->all();
        $postsData = Post::getAllByUsers($userIds, 1, 5);

        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/index', [
            'posts' => $postsData,
        ]) . 
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
        $postsCount = Post::where('post_status', 1)->where('user_id', $userData->user_id)->count();
        $postsData = Post::getAll($userData->user_id);

        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/profile', [
            'user' => $userData,
            'ismyprofile' => $isMyProfile,
            'connect' => $connectStatus,
            'connect_data' => $connectData,
            'posts_count' => $postsCount,
            'posts' => $postsData,
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

        if (session('user')['user_id'] !== $postData->user_id) {
            return redirect()->back();
        }

        $slidesData = Slide::orderBy('slide_order', 'asc')->where('post_id', $postData->post_id)->get();

        $postsData = Post::where('post_status', 3)->where('user_id', $postData->user_id)->orderBy('created_at', 'desc')
            ->with(['slides' => function($query) {
                $query->orderBy('slide_order', 'asc');
            }])->get();

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

    public function post_edit($post_public_id = null)
    {
        if ($post_public_id == null) {
            return redirect()->back();
        }

        $postData = Post::where('post_public_id', $post_public_id)->first();

        if (session('user')['user_id'] !== $postData->user_id) {
            return redirect()->back();
        }

        $slidesData = Slide::orderBy('slide_order', 'asc')->where('post_id', $postData->post_id)->get();

        $postsData = Post::where('post_status', 3)->where('user_id', $postData->user_id)->orderBy('created_at', 'desc')
            ->with(['slides' => function($query) {
                $query->orderBy('slide_order', 'asc');
            }])->get();

        foreach ($postsData as $x) {
            if ($postData->post_id !== $x->post_id && $x->slides->isEmpty()) {
                Post::where('post_id', $x->post_id)->delete();
            }
        }

        $postsData = Post::where('post_status', 2)->where('user_id', $postData->user_id)->orderBy('created_at', 'desc')
        ->with(['slides' => function($query) {
            $query->orderBy('slide_order', 'asc');
        }])->get();
    
        return 
        view('templates/header') . 
        view('templates/top-user') . 
        view('user/post-edit', [
            'post' => $postData,
            'slides' => $slidesData,
            'posts' => $postsData,
        ]) . 
        view('templates/bottom-user') . 
        view('templates/footer');
    }

    public function people(Request $request)
    {
        $userData = User::where('user_username', session('user')['user_username'])->first();
        $isMyProfile = $userData->user_username === session('user')['user_username'];
        $postsData = Post::getAll($userData->user_id);
        $recommendedPeople = User::getConnect($userData->user_id, 'dst', true, 3);
    
        $keyword = trim($request->k ?? '');
        $hasValidKeyword = !empty($keyword);
    
        if ($request->ajax()) {
            $user_search = $hasValidKeyword
                ? User::getPeoples($keyword, $userData->user_id, 10)
                : null;
    
            return view('user.people-data', [
                'user' => $userData,
                'user_search' => $user_search
            ]);
        }
    
        $user_search = $hasValidKeyword
            ? User::getPeoples($keyword, $userData->user_id)
            : null;
    
        return view('templates/header') . 
            view('templates/top-user') . 
            view('user/people', [
                'user' => $userData,
                'ismyprofile' => $isMyProfile,
                'posts' => $postsData,
                'recommended' => $recommendedPeople,
                'user_search' => $user_search,
            ]) . 
            view('templates/bottom-user') . 
            view('templates/footer');
    }
      
}
