<?php

namespace App\Http\Controllers;

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
}
